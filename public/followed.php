<?php

use User\UserRepository;


include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);
$username = $_REQUEST['username']?? null;
$users = $userRepository->fetchfollowed($username) ?? null;
echo "<table class=\"table\">
  <thead class=\"thead-dark\">
    <tr>
      <th scope=\"col\">Username</th>
      <th scope=\"col\">Email</th>
    </tr>
  </thead>
  <tbody>";
foreach ($users as $user): echo "
                <tr>
                    <td> <a href='profile.php?username={$user->getUsername()}'>{$user->getUsername()}</a></td>
                    <td> {$user->getEmail()}</td>
                </tr>";
endforeach;
echo "     </tbody>  </table>";