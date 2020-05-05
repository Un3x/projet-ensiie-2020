<?php
session_start();

set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

include_once 'Users/User.php';
include_once 'Users/UserRepository.php';
include_once 'Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
$users = $userRepository->fetchAll();
?>

<div class="col-sm-12">
    <h1>User List</h1>
</div>
<div class="col-sm-12">
    <table class="table">
        <tr>
            <th>id</th>
            <th>username</th>
            <th>email</th>
            <th>creation date</th>
            <th>Rights</th>
            <th>Action</th>
        </tr>
        <?php foreach($users as $user): ?>
            <tr>
                <td><?= $user->getId() ?></td>
                <td><?= $user->getUsername() ?></td>
                <td><?= $user->getEmail() ?></td>
                <td><?= $user->getCreatedAt()->format(\DateTime::ATOM) ?></td>
                <td><?php 
$tmprights=$user->getRights();
if ( $tmprights === 0 )
echo "Peasant";
elseif ( $tmprights === 1 )
echo "Admin";
elseif ( $tmprights === 2 )
echo "Root";
elseif ( $tmprights === -1 )
echo "Trash";
else
echo "UNKNOWN";
                    ?></td>
                <td>
<?php if ( ($user->getId() !== $_SESSION['id']) && ($user->getRights() <= $_SESSION['rights']) )
echo 
'<form method="POST" action="Forms/deleteUser.php">
    <input name="user_id" type="hidden" value="' . $user->getId() . '">
    <button type="submit">Delete</button>
</form>';
?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
