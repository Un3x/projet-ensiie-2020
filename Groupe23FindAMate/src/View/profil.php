<html>
    <head>
        <title>Profil de <?php $GET['pseudo'] ?></title>
        <meta charset="utf-8">

    </head>
    <body>
        <script src="scripts.js"></script>
        <?php
        
        if( isset($_GET['pseudo']) || isset($_SESSION['name']) )
        {
            if(isset($_POST['jeu']))
            {
                header('location:gamelist.php');
            }
            if(isset($_POST['action']) and !empty($_POST['action']))
            {
                $action=$_POST['action'];
            }
            else if (isset($_GET['action']))
            {
                $action=$_GET['action']; 
            }
            else
            {
                $action="consulter";
            }
            
            //$action=(isset($_POST['action']) || isset($_GET['action']))?'modifier' :'consulter';
            $username=isset($_GET['pseudo'])?(string) ($_GET['pseudo']):$_SESSION['name'];
            $dbAdapter = (new DbAdaperFactory())->createService();
            $userRepository = new \src\Model\repository\UserRepository($dbAdapter);
            $gameRepository= new \src\Model\repository\GameRepository($dbAdapter);
            $users=$userRepository->profil($username);
            foreach($users as $user)
            {
                $id=htmlspecialchars($user->getId());
                $username=htmlspecialchars($user->getUsername());
                $email=htmlspecialchars($user->getEmail());
                $promo=htmlspecialchars($user->getPromo());
                $discord=htmlspecialchars($user->getPseudoDiscord());
                $date=htmlspecialchars($user->getCreatedat());

            }
            
            $games = $gameRepository->showAcquired($username);
            switch($action)
            {
                case "consulter":
                    
                    
                    setlocale(LC_TIME,"fr_FR","French");
                    echo '<div align="center"> <h1>Profil de '.$username.'</h1></div><br/>';
                    echo '<p align="center"><strong>Adresse Mail : </strong>'.$email.'</p><br/>';
                    echo '<p align="center"><strong>Promo : </strong>'.$promo.'</p><br/>';
                    echo '<p align="center"><strong>Pseudo Discord: </strong>'.$discord.'</p><br/>';
                    //echo '<p>Ce membre est inscrit depuis le '.date("d F Y", $date).'</p><br/>';
            
                    
                    echo '<p align="center"><strong>Jeux possédés : </strong></p><br/>';
                    foreach($games as $game)
                    {
                        echo '<p align="center">'.htmlspecialchars($game->getName()).'</p><br/>';
                    }  
                if(isset($_SESSION['id']) && $_SESSION['id']==$id)
                {
                    echo '<div align="center">';
                    echo '<form action="profil.php?pseudo='.$username.'"'.' method="POST">';
                    echo '<button class="button" type="submit" name="jeu">Ajouter des jeux à ma liste</button></br></br>';
                    echo '<button class="button" type="submit" name="action" value="modifier" > Modifier mon profil</button></div>';
                }

                break;

                case "modifier": ?>
                        <head>
                            <title>Modification de profil</title>
                            <meta charset="utf-8">

                        </head>
                        <body>
                            <div align="center">
                                <h2>Modification de mon profil</h2>
                                <br /><br />
               
                                <form action="modifprofil.php?id=<?php echo htmlspecialchars($_SESSION['id']) ?>" method="POST">
                                    <table>
                                        <tr>
                                            <td align="center">
                                                <label><strong> Votre pseudo: <?php echo $username; ?> <br/>Entrez un pseudo si vous souhaitez le modifier: <br/></strong></label>
                                            </td>
                                                </tr>
                                                <tr>
                                            <td align="center">
                                                <input type="string" placeholder="Nouveau pseudo" name="newpseudo" />
                                            </td>
                                            </tr>
                                            <tr>
                                            <td align="center">
                                                <label><strong>Votre promo: <?php echo $promo; ?> <br/>Entrez une promo si vous souhaitez la modifier: <br/></strong></label>
                                            </td>
                                            </tr>
                                                <tr>
                                            <td align="center">
                                                <input type="int" placeholder="Nouvelle promo" name="newpromo" value="<?php if(isset($_GET['promo'])) { echo htmlspecialchars($_GET['promo']); } ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <label><strong>Pseudo Discord: <?php echo $discord; ?> <br/>Entrez un pseudo discord si vous souhaitez la modifier: <br/></strong></label>
                                            </td>
                                            </tr>
                                                <tr>
                                            <td align="center">
                                                <input type="text" placeholder="Nouveau pseudo discord" name="newds" value="<?php if(isset($_GET['pseudo_discord'])) { echo htmlspecialchars($_GET['pseudo_discord']); } ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <label><strong>Mot de passe: <br/>Entrez un Nouveau mot de passe si vous souhaitez le modifier:<br/></strong></label>
                                                </td>
                                            </tr>
                                                <tr>
                                            <td align="center">
                                                <input type="password" placeholder="Nouveau mot de passe" name="newmdp1" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <label><strong>Confirmez le nouveau mot de passe:<br/></strong></label>
                                                </td>
                                            </tr>
                                                <tr>
                                            <td align="center">
                                                <input type="password" placeholder="Champ obligatoire" name="newmdp2"  />
                                            </td>
                                        </tr>
                                    </table>
                                    <br/>
                                    <button type="submit" name="modifier">Modifier</button>
                                    </form>

                                    <form method="POST" action="deleteUser.php" id='id1'>
                                    <input name="user_id" type="hidden" value="<?= $user->getId() ?>">
                                    <input type="button" name="verif" value="Suppression de votre compte" onclick="verifOnDelete();">
                                    </form>
                                    <?php if(isset($_GET['err']) AND !empty($_GET['err']))
                                    {
                                        if($_GET['err']==1)
                                        {
                                            echo "<font color='red'>Vos mots de passe ne correspond pas</font color>";
                                        }
                                        else if($_GET['err']==2)
                                        {
                                            echo "<font color='red'>Ce pseudo est déjà pris!</font color>";
                                        }
                                    }
                                    ?>
                </div>
                <br/>
                    

                <?php
                break;
                       

            }

        
        }
        else
        {
            header('location: login.php');

        }
        ?>
    </body>