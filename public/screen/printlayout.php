<?php
session_start();

function printNav($friends,$userRepository,$page){
    echo "<header>
    <form action=\"../search.php\" method='post'>
            <div class=\"navbar\">
                <input type=\"text\" name=\"search_words\" id=\"search_words\" placeholder=\"Rechercher par utilisateur...\">";
                if (isset($_SESSION['id']) AND isset($_SESSION['pseudo']))
                    {
                        echo '<span class="welcometext">Bonjour ' . $_SESSION['pseudo'].' !</span>';
                    }
            echo "</div></form>
            <div class=\"navbarphone\">
                <a href='home.php'><img src=\"./images/home.png\" class=\"imagenav\" width=\"50\" height=\"50\"></a>
                <input type=\"text\" id=\"search_words\" placeholder=\"Rechercher par mot-dièse...\">
                <a href='profile.php'><img src=\"./images/user.png\" class=\"imagenav\" width=\"50\" height=\"50\"></a>
                <a href='settings.php'><img src=\"./images/settings.png\" class=\"imagenav\" width=\"50\" height=\"50\"></a>
            </div>
        </header>
        <div class='sidenav'>
            
            <div class=\"linkbigscreen\">
                <a href='home.php'><img src=\"./images/home.png\" class=\"imagenav\" width=\"50\" height=\"50\">FacebIIkE</a><br/>
                <a href='profile.php'><img src=\"./images/user.png\" class=\"imagenav\" width=\"50\" height=\"50\">Profil</a>
                <a href='settings.php'><img src=\"./images/settings.png\" class=\"imagenav\" width=\"50\" height=\"50\">Paramètres</a>
                <a href='home.php#writenewpost'><img src=\"./images/post.png\" class=\"imagenav\" width=\"50\" height=\"50\">Poster</a>
            </div>
            
            <div class=\"linksmallscreen\">
                <a href='home.php'><img src=\"./images/home.png\" class=\"imagenav\" width=\"50\" height=\"50\"></a><br/>
                <a href='profile.php'><img src=\"./images/user.png\" class=\"imagenav\" width=\"50\" height=\"50\"></a>
                <a href='settings.php'><img src=\"./images/settings.png\" class=\"imagenav\" width=\"50\" height=\"50\"></a>
                <a href='home.php#writenewpost'><img src=\"./images/post.png\" class=\"imagenav\" width=\"50\" height=\"50\"></a>
            </div>

        </div>";

        echo"
        <div class='rightpanel'>";
            if (isset($_SESSION['id'])) {
                echo "<a href=\"DeconnectUser.php\"><span class=\"minusbold\">Déconnexion</span></a><br><br>";
                echo "<span class=\"superbold\">Amis</span>
                <br />";
                $nbfriends=0;
                foreach ($friends as $friend) {
                    #echo $friend->getIdUser2();
                    if($friend->getIdUser1()==$_SESSION['id']|| $friend->getIdUser2() == $_SESSION['id']){
                        $nbfriends=$nbfriends+1;
                        echo "<hr><p>";
                        if($friend->getStatus()){
                            if ($friend->getIdUser1() == $_SESSION['id']){
                                $friendsinfos= $userRepository->fetchByID($friend->getIdUser2());
                                foreach ($friendsinfos as $friendinfo){
                                    if ($friendinfo->getId() == $friend->getIdUser2()){
                                        echo "<a style=\"color:white;\" href=\"./userprofile.php?user=" . $friendinfo->getUsername() . "&amp;useridincoming=" . $friendinfo->getId() . "\">" . $friendinfo->getUsername() . "</a>";
                                    }
                                }
                            }
                            else{
                                $friendsinfos = $userRepository->fetchByID($friend->getIdUser1());
                                foreach ($friendsinfos as $friendinfo) {
                                    if ($friendinfo->getId() == $friend->getIdUser1()){
                                        echo "<a style=\"color:white;\" href=\"./userprofile.php?user=" . $friendinfo->getUsername() . "&amp;useridincoming=" . $friendinfo->getId() . "\">" . $friendinfo->getUsername() . "</a>";
                                     }
                                }
                            }
                        }
                        else{
                            echo "<span style=\"color:red;\">";
                            if ($friend->getIdUser1() == $_SESSION['id']){
                                $friendsinfos= $userRepository->fetchByID($friend->getIdUser2());
                                foreach ($friendsinfos as $friendinfo){
                                    if ($friendinfo->getId() == $friend->getIdUser2()){
                                        echo "<a style=\"color:red;\" href=\"./userprofile.php?user=" . $friendinfo->getUsername() . "&amp;useridincoming=" . $friendinfo->getId() . "\">" . $friendinfo->getUsername() . " ...</a>";
                                    }
                                }
                            }
                            else{
                                $friendsinfos = $userRepository->fetchByID($friend->getIdUser1());
                                foreach ($friendsinfos as $friendinfo) {
                                    if ($friendinfo->getId() == $friend->getIdUser1()){
                                        echo "<a style=\"color:orange;\" href=\"./userprofile.php?user=" . $friendinfo->getUsername() . "&amp;useridincoming=". $friendinfo->getId()."\">" . $friendinfo->getUsername() . " ...</a><form action =\"AcceptFriendship.php\" method='POST'><input type='hidden' name=\"redirection\" value=".$page."><input type='hidden' name='user1f' value=". strval($friend->getIdUser1()). "><input type='hidden' name='user2f' value=" . strval($friend->getIdUser2()) . "><input type='submit' name='acceptdemand' value=\"Accepter\"></form>";
                                    }
                                }
                            }
                            echo"</span>";
                        }
                        echo "</p>";
                    }
                }

                if ($nbfriends==0) {echo "<hr><p>Vous n'avez (pour l'instant) aucun ami</p>";}

            } else {
                echo "<a href=\"index.php\"><span class=\"minusbold\">Connexion</span></a><br>";
            }
            
            
            
            echo"</p>
        </div>
        ";
        
}