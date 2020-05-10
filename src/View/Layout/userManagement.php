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
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Creation date</th>
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
{
    echo "Peasant</td><td>";
    echo
        '<form method="POST" action="Forms/modifyUserRights.php">
            <input name="user_id" type="hidden" value="' . $user->getId() . '">
            <input name="action" type="hidden" value="1">
            <button onclick="return confirm(\'Are you sure ?\')" type="submit">Upgrade</button>
        </form>';
    echo
        '<form method="POST" action="Forms/modifyUserRights.php">
            <input name="user_id" type="hidden" value="' . $user->getId() . '">
            <input name="action" type="hidden" value="-1">
            <button onclick="return confirm(\'Are you sure ?\')" type="submit">Downgrade</button>
        </form>';
}

elseif ( $tmprights === 1 )
{
    echo "Admin</td><td>";
    echo
        '<form method="POST" action="Forms/modifyUserRights.php">
            <input name="user_id" type="hidden" value="' . $user->getId() . '">
            <input name="action" type="hidden" value="-1">
            <button onclick="return confirm(\'Are you sure ?\')" type="submit">Downgrade</button>
        </form>';
}

elseif ( $tmprights === 2 )
{
    echo "Root</td><td>";
}

elseif ( $tmprights === -1 )
{
    echo "Trash</td><td>";
    echo
        '<form method="POST" action="Forms/modifyUserRights.php">
            <input name="user_id" type="hidden" value="' . $user->getId() . '">
            <input name="action" type="hidden" value="1">
            <button onclick="return confirm(\'Are you sure ?\')" type="submit">Upgrade</button>
        </form>';
}
else
{
    echo "UNKNOWN</td><td>";
}

if ( ($user->getId() !== $_SESSION['id']) && ($user->getRights() <= $_SESSION['rights']) && ($user->getRights() != 2) )
echo 
'<form method="POST" action="Forms/deleteUser.php">
    <input name="user_id" type="hidden" value="' . $user->getId() . '">
    <button onclick="return confirm(\'Are you sure ?\')" type="submit">Delete</button>
</form>';
?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
