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
        <title> Profil FrIIEnd ++ </title>
        <link rel="stylesheet" type="text/css" href="../mises_en_pages/profil_visite.css">
    </head>
    <body>

        <div class="topbar">
            <a href="4_Page_2.php">Accueil</a>
            <a href="formulaire_de_recherche.php">Rechercher un ami</a>
            <a href="Profil.php">Mon profil</a> 
            <a href="deconnexion.php" class="param">Déconnexion</a>
            
        </div>

        <div name = "photo">
		   
        </div >

        
		<div class="form" name = "public">
            <fieldset>
                <legend><span class="number"></span>Profil du membre :</legend>

        	<?php
            if (isset($_GET["prenom"]) && isset($_GET["nom"]) && isset($_GET["pseudo"]))
            {
                if ($_SESSION["pseudo"] == $_GET["pseudo"])
                {
                    header('Location: Profil.php');
                }
                $pseudo = $_GET["pseudo"];
                $nom = $_GET["nom"];
                $prenom = $_GET["prenom"];
                $req = pg_query($bdd, 'SELECT id FROM utilisateur WHERE nom = \''.$nom.'\'AND prenom = \''.$prenom.'\' AND pseudo = \''.$pseudo.'\'' );
                $exists = pg_num_rows($req);
                if ($exists == 1)
                {
                    $row = pg_fetch_row($req);
                    $id = $row[0];
        	        $id_utilisateur = $_SESSION["id"];
                    $q = pg_query($bdd, 'SELECT * FROM amis WHERE id1 = \''.$id.'\' AND id2 = \''.$id_utilisateur.'\'');
                    $nb_ligne = pg_num_rows($q);
        	        if ($nb_ligne != 0)
        	        	$statut_ami = 'ami';
        	        else
        	        	$statut_ami = NULL;

                    $statut_util = $_SESSION["statut"];
                    
                    ?>

                    <h2>
                    <?php 
        
                    $req = pg_query($bdd, 'SELECT * FROM utilisateur WHERE pseudo = \''.$pseudo.'\''); 
                    $data = pg_fetch_row($req);
                    if ($data == false) { /*si la requete n'a pas abouti */
                           print_r(pg_last_error());
                    }
                    print_r($data[1]); /*prenom*/
                    echo "&nbsp";
                    print_r($data[2]); /*nom*/
                    ?>
                    <br/>
                    <?php
                    print_r($pseudo); /*pseudo*/
                    ?>
                    </h2>
        
                    <br/>
                    <?php if (isset($data[5]) ){ ?>
                    Année d'étude : <?php print_r($data[5]) ?>
                    <?php } ?>
                </div>
                        
                <?php 
                if ($statut_ami == 'ami' || $statut_util == 'admin') { ?>
                    <div class="form" name = "private" id = "private" >
					
					<fieldset>
						<legend><span class="number"></span>Informations</legend>
                        numéro de téléphone : <?php print_r($data[10]) ?>
                        <br/>
                        mail : <?php print_r($data[6]) ?>
                        <br/>
                        adresse : <?php print_r($data[9]) ;
                        echo "&nbsp";
                        print_r($data[7]);
                        ?>
                        <br/>
                        date de naissance : <?php print_r($data[11]) ?>
                        <br/>
                        <?php pg_free_result($req) ?>
					</fieldset>
					
        <!--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                       <legend><span class="number"></span>Amis</legend><br/>
        
                        <?php
                        $ami = pg_query($bdd, 'SELECT id2 from amis WHERE id1 = \''.$id.'\'');
                        $nb_ami = pg_num_rows($ami);
                        for ($j = 0; $j < $nb_ami; $j++) {
                            $data = pg_query($bdd, 'SELECT * FROM utilisateur WHERE id = \''.pg_fetch_result($ami, $j, 0).'\''); /*execution requete*/
        
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
                            }
                            ?>
                            <br/>
                            <br/>
                            <?php
                            pg_free_result($data);
                        }
                        pg_free_result($ami); 
                        ?>
        
        <!--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                    <legend><span class="number"></span>Associations</legend><br/>
        
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
                        <?php
                    }
                    pg_free_result($data); 
    
    
                    ?>
        
        <!--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->            
        
                    <legend><span class="number"></span>Sport</legend><br/>
        
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
                    }
                    pg_free_result($data); 
                        ?>
        
        <!--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->            
        
                    <legend><span class="number"></span>Voyages</legend><br/>

                                <?php
                    $gout = pg_query($bdd, 'SELECT aime_voyager FROM gout WHERE id =  \''.$id.'\'');
                    if ($gout == false) {
                        print_r(pg_last_error());
                    }
                    $nb_lignes = pg_num_rows($gout);

                    for ($i = 0; $i < $nb_lignes; $i ++) {
                        if (pg_fetch_result($gout, $i, 0) == 'oui') {
                            ?>Aime voyager <br/><?php
                        }
                        if (pg_fetch_result($gout, $i, 0) == 'non'){
                            ?>N'aime pas voyager <br/> <?php
                        }
                    }   
                    ?>
        
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
                    }
                    pg_free_result($data); 
                        ?>
        
        
        <!--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->            
                    <legend><span class="number"></span>Lectures</legend><br/>

                    <?php
                    $gout = pg_query($bdd, 'SELECT aime_lire FROM gout WHERE id =  \''.$id.'\'');
                    if ($gout == false) {
                        print_r(pg_last_error());
                    }
                    $nb_lignes = pg_num_rows($gout);

                    for ($i = 0; $i < $nb_lignes; $i ++) {
                        if (pg_fetch_result($gout, $i, 0) == 'oui') {
                            ?>Aime lire <br/><?php
                        }
                        if (pg_fetch_result($gout, $i, 0) == 'non'){
                            ?>N'aime pas lire <br/> <?php
                        }
                    }
                    ?>
        
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
                        
                       
                    }
        
                    
                    pg_free_result($data); /*on libère la mémoire */
                    ?>
        
        <!--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->            
        
                    <legend><span class="number"></span>Films</legend><br/>
        
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
        
        
                    }
        
                    
                    pg_free_result($data); /*on libère la mémoire */
                    ?>
        
        
        <!--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->            
        
                    <legend><span class="number"></span>Situation</legend><br/>
        
                   <?php
                    /*requete*/
                    $req = pg_query($bdd, 'SELECT * FROM relation WHERE id = \''.$id.'\''); /*execution requete*/
                    $data = pg_fetch_row($req);
        
                    if ($req == false) { /*si la requete n'a pas abouti */
                        print_r(pg_last_error());
                    } 
                    
                    if (isset($data[1])) {
                        ?>
                        situation amoureuse : <?php print_r($data[1]) ?>
                        <br/>
                        <?php
                    }
        
                    
                    if (isset($data[2])) {
                        ?>
                        je recherche une relation <?php print_r($data[2]) ?>.
                        <br/>
                        <?php
                    }
        
                    if (isset($data[3])){
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
                    
                    pg_free_result($req); /*on libère la mémoire */
                    ?>
        
        
                </div>
        
                <div class="form">
                    <fieldset>

                    <?php 
        
                    if ( $statut_util == 'admin') {

                        ?>
                         <legend><span class="number"></span>Paramètre Administrateur</legend>
                        Supprimer le profil : <br/>
                        En tant qu'administrateur vous pouvez supprimer ce profil, cette action est irreversible. <br/>
                         <form method = "post" action = "./pages_traitements/suppression.php">
                                    <input type="hidden" name="id" value="<?php echo $id ?> " />
                                    <input type="hidden" name="categorie" value="supr_profil" />
                                    <input type="submit" name="modifier" value="Supprimer" id="supprimer_profil"/> <br/>
                        </form>
                    
                        <?php
        
                    }
                } /*ferme le cas "si on est amis ou admin*/
        
                    else {
                        
                        
                        ?>
                        <div class="form">
                        <fieldset>
                        <form method = "POST" action="./pages_traitements/demande_ami.php">
                            <input type="hidden" name="id1" value="<?php echo $id ?> " />
                            <input type="hidden" name="id2" value="<?php echo $id_utilisateur ?> " />
                            <input type="hidden" name="statut" value="demande" />
                            <input type="hidden" name="categorie" value="demande" />
                            <input type="submit" name = "ajouter_ami" value="ajouter en tant qu'ami" />
                        </form>
                    </fieldset>
                    </div>
                        <?php
                    }
                } /*si le profil existe */
                
            } /*ferme le si la demande est bonne" */
            else
            { ?>
                La personne que vous recherchez n'existe malheureusement pas encore dans notre base de données...
                <?php
            }
            ?>
            </fieldset>
            </div>
            <br/>
            <div class="form">
                <fieldset>

            <form type = "post" action="4_Page_2.php"> 
                <input type="submit" name = "ajouter_ami" value="Retour à la page d'accueil" />
            </form>   
        </fieldset> 
       
    </body>

</html>