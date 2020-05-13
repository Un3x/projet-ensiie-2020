<?php

session_start();

try {
/*$conn_string = "host=localhost port=5432 dbname=ipw user=cao_caroline password=123";*/
$conn_string = "host=localhost port=5432 dbname=projet_web user=lauriane password=lauriane";
$bdd = pg_connect($conn_string);
}

catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title> Votre profil FrIIEnd ++ </title>
        <link rel="stylesheet" type="text/css" href="../mises_en_pages/test_profil.css">
    </head>

    <body>

        <div class="topbar">
            <a href="4_Page_2.php">Accueil</a>
            <a href="formulaire_de_recherche.php">Rechercher un ami</a>
            <a class="actif" href="Profil.php">Mon profil</a> 
            <a href="deconnexion.php" class="param">Déconnexion</a>
            
        </div>

       

	    <div name = "photo">
        </div >

        <div class="form" name = "public">
            <fieldset>
                <legend><span class="number"></span>Votre profil actuel </legend>
                <?php
                print_r($_SESSION["prenom"]);
                echo "&nbsp";
                print_r($_SESSION["nom"]); ?> <br/> pseudo : <?php
                print_r($_SESSION["pseudo"]); ?> <br/> <?php
                $id = $_SESSION["id"];
                ?>
            </fieldset>
        </div>
        

        <div class="form" name = "news">
            <fieldset>
                <legend><span class="number"></span>ils vous ont demandé en amis </legend>
                <?php
                $req1 = 'SELECT id2 FROM demande_ami WHERE id1 = \''.$id.'\' AND statut = \'demande\'';
                $req = pg_query ($bdd, $req1);
                
                if ($req == false) { /*si la requete n'a pas abouti */
                    print_r(pg_last_error());
                } 

                $nb_lignes = pg_num_rows($req);

                for ($i = 0; $i < $nb_lignes; $i ++) {
                    $demandeur = pg_fetch_result($req, $i, 0);
                    
                    $data = pg_query($bdd, 'SELECT prenom, nom, pseudo FROM utilisateur WHERE id = \''.$demandeur.'\'');
                    
                    if ($data == false) { /*si la requete n'a pas abouti */
                        print_r(pg_last_error());
                    } 

                    $nb_lignes_data = pg_num_rows($data);

                    for ($j = 0; $j < $nb_lignes_data; $j ++) {

                        $prenom = pg_fetch_result($data, $j, 0);
                        $nom = pg_fetch_result($data, $j, 1);
                        $pseudo = pg_fetch_result($data, $j, 2);

                        print_r($prenom); 
                        echo "&nbsp";
                        print_r($nom) ?> alias <?php print_r($pseudo) ; ?> vous a ajouté en ami.

                        <?php $date = date("Y"); ?>
                        <form method="post" action="./pages_traitements/demande_ami.php" >
                            <input type="hidden" name="id2" value="<?php echo $demandeur?>">
                            <input type="hidden" name="id1" value="<?php echo $id?>">
                            <input type="hidden" name="annee" value="<?php echo $date ?>">
                            <input type="hidden" name="categorie" value="accepter">
                            <input type="submit" name="accepter" value="accepter">
                        </form>
                
                        <form method="post" action="./pages_traitements/demande_ami.php" >
                            <input type="hidden" name="id2" value="<?php echo $demandeur?>">
                            <input type="hidden" name="id1" value="<?php echo $id?>">
                            <input type="hidden" name="statut" value="refuser" />
                            <input type="hidden" name="categorie" value="refuser">
                            <input type="submit" name="refuser" value="refuser">
                        </form>
                        <br/>
                        <?php
                    }
                }
                

                ?>
            </fieldset>
        </div>

        <div class = "form" name = "private" >
            <fieldset>
                <legend><span class="number"></span>Seuls vos amis verrons cette partie <span class="number"></span></legend>

                <div class="form" name ="info_perso">
                    <fieldset>
                        <center> Informations personnelles </center>
                        <?php
                        $pseudo = $_SESSION["pseudo"];
                        $data = pg_query($bdd, 'SELECT * FROM utilisateur WHERE pseudo = \''.$pseudo.'\''); 
                        $req = pg_query($bdd, 'SELECT * FROM utilisateur WHERE pseudo = \''.$pseudo.'\'');

                        $req2 = pg_fetch_row($req);
                
                        if ($data == false) { /*si la requete n'a pas abouti */
                            print_r(pg_last_error());
                        } 

                        $nb_lignes = pg_num_rows($data);

                        for ($i = 0; $i < $nb_lignes; $i ++) {

                            if (pg_fetch_result($data, $i, 10) != NULL){ /*num telephone*/
                                ?>
                                numéro de téléphone : <?php print_r(pg_fetch_result($data, $i, 10)); ?>
                                <br/>
                                <form method = "post" action = "./pages_traitements/suppression.php">
                                    <input type="hidden" name="id" value="<?php echo $_SESSION["id"] ?> " />
                                    <input type="hidden" name="delete_tel" value="<?php echo pg_fetch_result($data, $i, 10) ?>"/>
                                    <input type="hidden" name= "categorie" value="tel">
                                    <input type="submit" name="modifier" value="Supprimer" id="supprimer_tel"/> <br/>
                                </form>

                                <input type="button" name="ajouter" value="Modifier mon numero de téléphone" id="modif_tel" onclick = "cacher('modifier_tel')"/> <br/>
                                <form method="post" action = "./pages_traitements/ajout.php" id = "modifier_tel" hidden>
                                    Modifier votre numéro de téléphone : <br/>
                                    <input type="tel" name="num_tel" id="num_tel" /> <br/>
                                    <input type="hidden" name= "categorie" value="tel">
                                    <input type="submit" name="valider" value="valider" id="valider"/> <br/>
                                </form>
                                <br/>
                                <?php
                            } 
                            else { ?>


                                <form method="post" action = "./pages_traitements/ajout.php" id = "ajouter_tel">
                                    Ajouter un numéro de téléphone : 
                                    <input type="tel" name="num_tel" id="num_tel" /> <br/>
   
                                    <input type="hidden" name= "categorie" value="tel">
                                    <input type="submit" name="valider" value="valider" id="valider"/> <br/>
                                </form>
                                <br/>

                                <?php   
                            } 
                        }?>

                        mail : <?php print_r($req2[6]) ?> <!--forcement non null-->
                        <input type="button" name="ajouter" value="Modifier mon adresse mail" id="modife_email" onclick = "cacher('modifier_email')"/> <br/>
                        <form method="post" action = "./pages_traitements/ajout.php" id = "modifier_email" hidden>
                            Modifier votre adresse mail: <br/>
                            <input type="email" name="email" id="email" /> <br/>
                            <input type="hidden" name= "categorie" value="email">
                            <input type="submit" name="valider" value="valider" id="valider"/> <br/>
                        </form>
                        <br/>

                        <?php
                        if ($req2[9] != NULL) {
                            ?>
                            adresse : 
                            <?php
                            print_r($req2[9]) ; ?>
                            <form method = "post" action = "s./pages_traitements/uppression.php">
                                <input type="hidden" name="id" value="<?php echo $_SESSION["id"] ?> " />
                
                                <input type="hidden" name= "categorie" value="adresse" />
                                <input type="submit" name="modifier" value="Supprimer" id="supprimer_adresse"/> <br/>
                            </form> 

                            <input type="button" name="modifier" value="Modifier mon adresse" id="modif_adresse" onclick = "cacher('modifier_adresse')"/> <br/>
                            <form method="post" action = "./pages_traitements/ajout.php" id = "modifier_adresse" hidden>
                                Modifier votre adresse: <br/>
                                <input type="text" name="adresse" id="adresse" /> <br/>
                                <input type="hidden" name= "categorie" value="adresse">
                                <input type="submit" name="valider" value="valider" id="valider"/> <br/>
                            </form>

                            <br/>
                            <?php
                            echo "&nbsp"; ?>
                            Ville : <?php print_r($req2[7]); ?>

                            <input type="button" name="ajouter" value="Modifier ma ville" id="modif_ville" onclick = "cacher('ajouter_ville')"/> <br/>

                            <form method="post" action = "./pages_traitements/ajout.php" id = "ajouter_ville" hidden>
                                Modifier la ville dans laquelle vous vivez : <br/>
                                <input type="texte" name="ville" id="ville" /> <br/>
                                <input type="hidden" name= "categorie" value="ville">
                                <input type="submit" name="valider" value="valider" id="valider"/> <br/>
                            </form>
                            <br/>
                            <?php
                        }

                        else { ?>
                             <form method="post" action = "./pages_traitements/ajout.php" id = "ajouter_adresse">
                                Ajouter une adresse : 
                                <input type="text" name="adresse" id = "adresse"> 
   
                                <input type="hidden" name= "categorie" value="adresse">
                                <input type="submit" name="valider" value="valider" id="valider"/> <br/>
                            </form> <br/>
                            Ville :
                            <?php
                            print_r($req2[7]); ?>

                            <input type="button" name="ajouter" value="Modifier ma ville" id="modif_ville" onclick = "cacher('ajouter_ville')"/> <br/>

                            <form method="post" action = "./pages_traitements/ajout.php" id = "ajouter_ville" hidden>
                                Modifier la ville dans laquelle vous vivez : <br/>
                                <input type="texte" name="ville" id="ville" /> <br/>
                                <input type="hidden" name= "categorie" value="ville">
                                <input type="submit" name="valider" value="valider" id="valider"/> <br/>
                            </form>
                            <br/>
                            <?php
                        } ?>

                        <br/>
                        date de naissance : <?php print_r($req2[11]) ?>
                        <br/>

                        <br/>
                    </fieldset>
                </div>
<!--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                <div class="form" name ="Amis">
                    Mes Amis : <br/> <br/>

                    <?php
                    $req1 = 'SELECT id2 from amis WHERE id1 = \''.$id.'\'';
                    $req = pg_query($bdd, $req1);

                    if ($req == false) { /*si la requete n'a pas abouti */
                        print_r(pg_last_error());
                    }


                    $nb_lignes_req = pg_num_rows($req);

                    for ($j = 0; $j < $nb_lignes_req; $j++) {
                        $id_psn = pg_fetch_result($req, $j, 0);


                        $data = pg_query($bdd, 'SELECT prenom, nom, pseudo, annee_etude FROM utilisateur WHERE id = \''.$id_psn.'\''); /*execution requete*/

                        if ($data == false) { /*si la requete n'a pas abouti */
                            print_r(pg_last_error());
                        } 
                        $nb_lignes = pg_num_rows($data);

                        for ($i = 0; $i < $nb_lignes; $i ++) {
                            print_r(pg_fetch_result($data, $i, 0)); /*prenom*/
                            echo "&nbsp";
                            print_r(pg_fetch_result($data, $i, 1)); /*nom*/
                            ?>

                            <br/>
                            <?php
                            print_r(pg_fetch_result($data, $i, 2)); /*pseudo*/
                            ?>  
                            <br/>
                            <?php 
                            print_r(pg_fetch_result($data, $i, 3)); /*annee d'etude */
                            ?>
                            <br/>
                            <br/>
                            <?php

                        }
                    }


                    ?>
                    <br/>
                </div>


<!--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
            <div class="form" name ="Associations"> 
                Mes Associations : <br/>

                <?php
                $data = pg_query($bdd, 'SELECT nom_association FROM association WHERE id = \''.$id.'\''); /*execution requete*/

                if ($data == false) { /*si la requete n'a pas abouti */
                    print_r(pg_last_error());
                } 
                $nb_lignes = pg_num_rows($data);

                for ($i = 0; $i < $nb_lignes; $i ++) {
                    print_r(pg_fetch_result($data, $i, 0));   
                    ?>

                   <br/>
                   <form method = "post" action = "./pages_traitements/suppression.php">
                        <input type="hidden" name="id" value="<?php echo $_SESSION["id"] ?> " />
                        <input type="hidden" name="delete_asso" value="<?php echo pg_fetch_result($data, $i, 0) ?>"/>
                        <input type="hidden" name= "categorie" value="asso">
                        <input type="submit" name="modifier" value="Supprimer" id="supprimer_asso"/> <br/>
                    </form>
                    <br/>
                    <?php
                    
                }


                pg_free_result($data); /*on libère la mémoire */
           
                ?>

                <input type="button" name="ajouter" value="Ajouter une association" id="ajout_asso" onclick = "cacher('ajouter_asso')"/> <br/>

                <form method="post" action = "./pages_traitements/ajout.php" id = "ajouter_asso" hidden>
                    Ajouter une association dans laquelle vous êtes actif : <br/>
                    Nom : <input type="texte" name="nom" id="nom" /> <br/>
                    <input type="hidden" name= "categorie" value="asso">
                    <input type="submit" name="valider" value="valider" id="valider"/> <br/>
                </form>
                <br/>
            </div>


<!--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->            

            <div class="form" name ="Sport">
                Sports : <br/>

                <?php
                /*requete*/
                $data = pg_query($bdd, 'SELECT * FROM sport WHERE id = \''.$id.'\''); /*execution requete*/

                if ($data == false) { /*si la requete n'a pas abouti */
                    print_r(pg_last_error());
                } 

                /*si la requete à abouti */
                $nb_lignes = pg_num_rows($data);

                for ($i = 0; $i < $nb_lignes; $i ++) {
                
                    if (pg_fetch_result($data, $i, 1) != null) { /*nom_sport*/
                        ?>
                        <!-- on affiche le lieu -->
                        Sport pratiqué : <?php print_r(pg_fetch_result($data, $i, 1)); ?> <br/>
                        <?php
                    }
                
                    if (pg_fetch_result($data, $i, 2) != null){ /*club*/
                        ?>
                        En club: <?php print_r(pg_fetch_result($data, $i, 2)); ?> <br/>
                        <?php
                    }

                    if (pg_fetch_result($data, $i, 3) != null) { /*niveau*/
                        ?>
                        Niveau: <?php print_r(pg_fetch_result($data, $i, 3)); ?> <br/>
                        <?php
                    }
                    ?>
                    <form method = "post" action = "./pages_traitements/suppression.php">
                        <input type="hidden" name="id" value="<?php echo $_SESSION["id"] ?> " />
                        <input type="hidden" name="delete_sport" value="<?php echo pg_fetch_result($data, $i, 1) ?>"/>
                        <input type="hidden" name= "categorie" value="sport">
                        <input type="submit" name="modifier" value="Supprimer" id="supprimer_sport"/> <br/>
                    </form>
             
                    <?php
                }

            
                pg_free_result($data); /*on libère la mémoire */
           
                ?>

                <input type="button" name="ajouter" value="Ajouter un sport" id="ajout_sport" onclick = "cacher('ajouter_sport')"/> <br/>

                <form method="post" action = "./pages_traitements/ajout.php" id = "ajouter_sport" hidden>
                    Quels sports pratiquez vous ou aimez vous ? <br/>
                    <input type="texte" name="sports" id = "sports1" placeholder="Ex: Volley" /> <br>
                    En club ? <br>
                    <select name="club" >
                        <option value="oui"> OUI </option>
                        <option value = "non"> NON </option>
                    </select>
                    <br>
                    Quel niveau ?<br>
                    <select name="nivSportif" id = "nivSportif1">
                        <option value="deb"> Débutant </option>
                        <option value="moy"> Moyen </option>
                        <option value="conf"> Confirmé </option>
                        <option value="pro"> Professionel </option>
                    </select> <br>
                    <input type="hidden" name= "categorie" value="sport">
                    <input type="submit" name="modifier" value="Ajouter" id="ajout_sport"/> <br/>
                </form>
                <br/>
            </div>

<!--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->            
            <div class="form" name ="Voyages">
            Mes Voyages : <br/>
            <?php
            $gout = pg_query($bdd, 'SELECT aime_voyager FROM gout WHERE id =  \''.$id.'\'');
            if ($gout == false) {
                print_r(pg_last_error());
            }
            $nb_lignes = pg_num_rows($gout);

            for ($i = 0; $i < $nb_lignes; $i ++) {
                if (pg_fetch_result($gout, $i, 0) == 'oui') {
                    ?>J'aime voyager <br/><?php
                }
                if (pg_fetch_result($gout, $i, 0) == 'non'){
                    ?>Je n'aime pas voyager <br/> <?php
                }
            }
            ?>
            <input type="button" name="ajouter" value="Modifier mes gouts" id="gout" onclick = "cacher('modifier_gout_v')"/> <br/>

            <form method="post" action = "./pages_traitements/ajout.php" id = "modifier_gout_v" hidden>
                Aimez-vous voyager ? 
                <select name = "aimer_voyager"  id = "aimer_voyager" >
                    <option value="oui" id="oui"> Oui </option>
                    <option value="non" id="non"> Non </option>
                </select>
                <input type="hidden" name= "categorie" value="aimer_voyager">
                <input type="submit" name="modifier" value="Valider" id="modifie_gout"/> <br/>
                <br/>
            </form>
            

            <?php
            /*requete*/
            $data = pg_query($bdd, 'SELECT * FROM voyage WHERE id = \''.$id.'\''); /*execution requete*/

            if ($data == false) { /*si la requete n'a pas abouti */
                print_r(pg_last_error());
            } 

            /*si la requete à abouti */
            $nb_lignes = pg_num_rows($data);

            for ($i = 0; $i < $nb_lignes; $i ++) {
                
                if (pg_fetch_result($data, $i, 1) != null) { /*lieu*/
                    ?>
                    <!-- on affiche le lieu -->
                    Lieu : <?php print_r(pg_fetch_result($data, $i, 1)); ?> <br/>
                    <?php
                }
                
                if (pg_fetch_result($data, $i, 2) != null){ /*ville*/
                    ?>
                    Ville : <?php print_r(pg_fetch_result($data, $i, 2)); ?> <br/>
                    <?php
                }

                if (pg_fetch_result($data, $i, 3) != null) {
                    ?>
                    Pays : <?php print_r(pg_fetch_result($data, $i, 3)); ?> <br/>
                    <?php
                }
                ?>
               <form method = "post" action = "./pages_traitements/suppression.php">
                    <input type="hidden" name="id" value="<?php echo $_SESSION["id"] ?> " />
                    <input type="hidden" name="delete_lieu" value="<?php echo pg_fetch_result($data, $i, 1) ?>"/>
                    <input type="hidden" name="delete_ville" value="<?php echo pg_fetch_result($data, $i, 2) ?>"/>
                    <input type="hidden" name="delete_pays" value="<?php echo pg_fetch_result($data, $i, 3) ?>"/>
                    <input type="hidden" name= "categorie" value="voyage">
                    <input type="submit" name="modifier" value="Supprimer" id="supprimer_voyage"/> <br/>
                </form>
             
             <?php
             ?>
                <br/>
                <br/>
             <?php
            }

            
            pg_free_result($data); /*on libère la mémoire */
           
            ?>

            <input type="button" name="ajouter" value="Ajouter un voyage" id="ajout_voyage" onclick = "cacher('ajouter_voyage')"/> <br/>

            <form method="post" action = "./pages_traitements/ajout.php" id = "ajouter_voyage" hidden>
                Ajouter un endroit que vous avez visitez et particulièrement aimé : <br/>
                Lieu : <input type="texte" name="lieu" id="lieu" /> <br/>
                Ville : <input type="texte" name="ville" id="ville" /> <br/>
                Pays : <input type="texte" name="pays" id="pays" /> <br/>
                <input type="hidden" name= "categorie" value="voyage">
                <input type="submit" name="valider" value="valider" id="valider"/> <br/>
            </form>
            <br/>
        </div>
<!--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->            
            <div class="form" name ="Lectures">
            Mes lectures : <br/>

            <?php
            $gout = pg_query($bdd, 'SELECT aime_lire FROM gout WHERE id =  \''.$id.'\'');
            if ($gout == false) {
                print_r(pg_last_error());
            }
            $nb_lignes = pg_num_rows($gout);

            for ($i = 0; $i < $nb_lignes; $i ++) {
                if (pg_fetch_result($gout, $i, 0) == 'oui') {
                    ?>J'aime lire <br/><?php
                }
                if (pg_fetch_result($gout, $i, 0) == 'non'){
                    ?>Je n'aime pas lire <br/> <?php
                }
            }
            ?>

            <input type="button" name="ajouter" value="Modifier mes gouts" id="gout" onclick = "cacher('modifier_gout_l')"/> <br/>

            <form method="post" action = "./pages_traitements/ajout.php" id = "modifier_gout_l" hidden>
                Aimez-vous lire ? 
                <select name = "aimer_lire"  id = "aimer_lire" >
                    <option value="oui" id="oui"> Oui </option>
                    <option value="non" id="non"> Non </option>
                </select>
                <input type="hidden" name= "categorie" value="aimer_lire">
                <input type="submit" name="modifier" value="Valider" id="modifie_gout"/> <br/>
                <br/>
            </form>            

            <?php
            /*requete*/
            $data = pg_query($bdd, 'SELECT * FROM lecture WHERE id = \''.$id.'\''); /*execution requete*/

            if ($data == false) { /*si la requete n'a pas abouti */
                print_r(pg_last_error());
            } 

            /*si la requete à abouti */
            $nb_lignes = pg_num_rows($data);

            for ($i = 0; $i < $nb_lignes; $i ++) {
                
                if (pg_fetch_result($data, $i, 3) != null) { /*lieu*/
                    ?>
                    <!-- on affiche le lieu -->
                    Titre : <?php print_r(pg_fetch_result($data, $i, 3)); ?> <br/>
                    <?php
                }
                
                if (pg_fetch_result($data, $i, 4) != null){ /*ville*/
                    ?>
                    Auteur: <?php print_r(pg_fetch_result($data, $i, 4)); ?> <br/>
                    <?php
                }

                if (pg_fetch_result($data, $i, 1) != null) {
                    ?>
                    Type : <?php print_r(pg_fetch_result($data, $i, 1)); ?> <br/>
                    <?php
                }

                if (pg_fetch_result($data, $i, 1) != null) {
                    ?>
                    Genre : <?php print_r(pg_fetch_result($data, $i, 1)); ?> <br/>
                    <?php
                }
                ?>

               <form method = "post" action = "./pages_traitements/suppression.php">
                    <input type="hidden" name="id" value="<?php echo $_SESSION["id"] ?> " />
                    <input type="hidden" name="delete_titre" value="<?php echo pg_fetch_result($data, $i, 3) ?>"/>
                    <input type="hidden" name="delete_auteur" value="<?php echo pg_fetch_result($data, $i, 4) ?>"/>
                    <input type="hidden" name= "categorie" value="oeuvre">
                    <input type="submit" name="modifier" value="Supprimer" id="supprimer_livre"/> <br/>
                </form>
             
             <?php
             ?>
                <br/>
                <br/>
             <?php
            }

            
            pg_free_result($data); /*on libère la mémoire */
            ?>

            <input type="button" name="ajouter" value="Ajouter un livre" id="ajout_livre" onclick = "cacher('ajouter_livre')"/> <br/>


            <form method="post" action = "./pages_traitements/ajout.php" id = "ajouter_livre" hidden>
                Ajouter une oeuvre de votre choix, BD, roman, poème : <br/>
                Titre : <input type="texte" name="titre" id="titre" /> <br/>
                Auteur : <input type="texte" name="auteur" id="auteur" /> <br/>
                Type : <input type="texte" name="type" id="type" /> <br/>
                Genre : <input type="texte" name="genre" id="genre" /> <br/>
                <input type="hidden" name= "categorie" value="oeuvre">
                <input type="submit" name="valider" value="valider" id="valider"/> <br/>
            </form>
            <br/>
        </div>
<!--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->            
            <div class="form" name ="Films">
            Mes films : <br/>

            <?php
            /*requete*/
            $data = pg_query($bdd, 'SELECT * FROM film WHERE id = \''.$id.'\''); /*execution requete*/

            if ($data == false) { /*si la requete n'a pas abouti */
                print_r(pg_last_error());
            } 

            /*si la requete à abouti */
            $nb_lignes = pg_num_rows($data);

            for ($i = 0; $i < $nb_lignes; $i ++) {

                if (pg_fetch_result($data, $i, 1) != null) { /*lieu*/
                    ?>
                    <!-- on affiche le lieu -->
                    Type : <?php print_r(pg_fetch_result($data, $i, 1)); ?> <br/>
                    <?php
                }
                
                if (pg_fetch_result($data, $i, 2) != null){ /*ville*/
                    ?>
                    Titre : <?php print_r(pg_fetch_result($data, $i, 2)); ?> <br/>
                    <?php
                }

                if (pg_fetch_result($data, $i, 3) != null) {
                    ?>
                    Réalisateur : <?php print_r(pg_fetch_result($data, $i, 3)); ?> <br/>
                    <?php
                }

                
                ?>

               <form method = "post" action = "./pages_traitements/suppression.php">
                    <input type="hidden" name="id" value="<?php echo $_SESSION["id"] ?> " />
                    <input type="hidden" name="delete_titre" value="<?php echo pg_fetch_result($data, $i, 2) ?>"/>
                    <input type="hidden" name="delete_realisateur" value="<?php echo pg_fetch_result($data, $i, 3)?>"/>
                    <input type="hidden" name= "categorie" value="films">
                    <input type="submit" name="modifier" value="Supprimer" id="supprimer_films"/> <br/>
                </form>
             
             <?php
             ?>
                 <br/>
                 <br/>
             <?php
            }

            
            pg_free_result($data); /*on libère la mémoire */
            ?>

            <input type="button" name="ajouter" value="Ajouter un film" id="ajout_film" onclick = "cacher('ajouter_films')"/> <br/>


            <form method="post" action = "./pages_traitements/ajout.php" id = "ajouter_films" hidden>
                Ajouter un film de votre choix : <br/>
                Titre : <input type="texte" name="titre" id="titre" /> <br/>
                Réalisateur : <input type="texte" name="realisateur" id="realisateur" /> <br/>
                Type : <input type="texte" name="type" id="type" /> <br/>
                <input type="hidden" name= "categorie" value="films">
                <input type="submit" name="valider" value="valider" id="valider"/> <br/>
            </form>
            <br/>
        </div>
<!--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->            
            <div class="form" name ="Situation">
            Ma situation : <br/>

            <?php
            /*requete*/
            $req = pg_query($bdd, 'SELECT * FROM relation WHERE id = \''.$id.'\''); /*execution requete*/
            $data = pg_fetch_row($req);

            if ($req == false) { /*si la requete n'a pas abouti */
                print_r(pg_last_error());
            } 
            

            if (isset($data[2])) {
                ?>
                situation amoureuse : <?php print_r($data[2]) ?>.
                <br/>
                <?php
            }


            if (isset($data[1]) && $data[2] == 'en couple') {
                ?>
                Je ne recherche pas de relation <br/>
                <?php
            }

            if (isset($data[1]) && $data[2] != 'en couple') {
                ?>
                je recherche une relation <?php print_r($data[1]) ?>
                <br/>
                <?php
            }
            

            if (isset($data[3]) && $data[2] != 'en couple'){
                if ( $data[3] == 'femme' || $data[3] == 'homme'){
                    ?>
                    Je suis plus interessé(e) par les <?php print_r($data[3]) ?>.
                    <br/>
                    <?php
                }
                if ( $data[3] == 'bi') {
                    ?>
                    Je suis interessé(e) par les homms et les femmes.
                    <br/>
                    <?php
                }
                if ($data[3] == 'aucun') {
                    ?>
                    Pas interessé(e) !
                    <?php
                }
            }
                
                ?>
                <input type="button" name="modifier" value="Modifier" id="modification_situation" onclick = "cacher('modifier_situation')"/> <br/>

               <form method = "post" action = "./pages_traitements/modification.php" id = "modifier_situation" hidden>
                    
                    Situations amoureuse : <br/>
                    <select name="situation_amoureuse" >
                        <option value="en couple"> En couple </option>
                        <option value="célibataire"> Célibataire </option>
                        <option value="marié"> Marié </option>
                        <option value = "compliqué"> Wallah c'est compliqué </option>
                    </select> <br/>

                    Relation recherchée : <br/>
                    <select name="relation_rechercher">
                        <option value="serieux"> Serieux</option>
                        <option value="libre"> On est jeune, profitons de la vie ! </option>
                    </select> <br/>

                    Orientation sexuelle : <br/>
                    <select name="osexe" id="osexe">
                        <option value="femme" > Femmes </option>
                        <option value="homme"> Hommes</option> 
                        <option value= "bi"> Les deux </option>
                        <option value = "aucun"> Aucun </option>
                    </select> <br/>

                    <input type="hidden" name="redirection4" value="Profil.php">
                    <input type="submit" name="modifier" value="Valider" id="modification_situation"/> <br/>
                </form>
                <form method="POST" action = "4_Page_2.php">
                    <input type="submit" name = "retour" value = "Retour à la page d'accueil"/> <br/>
                </form>
        </div>
             
             <?php

            
            pg_free_result($req); /*on libère la mémoire */
            ?>
        </fieldset>

            

        </div>

        <script type = "text/javascript">
            function cacher (idparagraphe){
                var ajter2 = document.getElementById(idparagraphe);
                ajter2.removeAttribute('hidden');
            }       
        </script>
        

         <?php pg_close() ?>
    </body>
</html>