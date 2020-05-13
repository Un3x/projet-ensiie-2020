<?php
session_start();
if (!isset($_SESSION['id'])) {
  header ('Location: /index.php');
    exit();
}
?> 

<?php
include '../src/Factory/DbAdaperFactory.php';
include '../src/Entities/User.php';
include '../src/Entities/Ad.php';
include '../src/Repositories/UserRepository.php';
include '../src/Repositories/AdRepository.php';

$connexion = (new DbAdaperFactory())->createService();
$userId=$_SESSION['id'];
?>

<html lang="fr">
<head>
    <?php include_once '../src/view/head.php' ?>

    <link rel="stylesheet" href="./css/espace_membre.css">
</head>
<body>
    <?php include_once '../src/view/header.php' ?>
    <div class=informations_personnelles>
        <h2> Rechercher un utilisateur: </h2>
        <form action="search_user.php" method="post" name="Formulaire">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="md-form mt-0">
                        <input class="form-control" type="text" placeholder="Rechercher un utilisateur ..." id="recherche" name ="recherche" aria-label="Search">
                    </div>
                </div>
            </div>
        </form>
        <?php
        $req=$connexion->prepare('SELECT username, name, fname, email,age, created_at FROM "user" WHERE id=:userId');
        $req->bindParam(":userId",$userId);
        $req->execute();
        $req=$req->fetch();
        ?>

            <br />
            <br />
            <br /><br />
            <div id=info>
            <h2> Informations sur votre compte: </h2>
            <br />
            <br />



                <span> Pseudo :<?=$req['username']?> <input type="button" value="Modifier->" onclick="aff_form('modifpseudo')" class="btn btn-outline-secondary btn-sm"><form id="modifpseudo" action="modiftable.php" method="post">
                <input type="text" name="pseudo" value="nouveau pseudo" id="pseudo" required> <input type="submit"  class="btn btn-outline-primary btn-sm" value="valider" >
                <input value="retour <-" type="button" class="btn btn-outline-secondary btn-sm" onclick="hide_form(event,'modifpseudo')">
                </form> </span>
                <script>
                    document.getElementById('modifpseudo').style.display = 'none';
                </script>
            
            <div>
                <span> Nom : <?= $req['name'] ?> </span>
            </div>
            
            <div>
                <span> Prénom : <?= $req['fname']?> </span>
            </div>
            
            <div>
                <span> Adresse-mail : <?= $req['email'] ?> 
                <input type="button" class="btn btn-outline-secondary btn-sm" value="Modifier->" onclick="aff_form('modifmail')">
                <form id="modifmail" action="modiftable.php" method="post">
                    <input type="text" name="email" id="email" value="nouvel email"><small id="wrongEmail" class="text-danger"></small>
                    <input class="btn btn-outline-primary btn-sm" type="submit" value="valider" name='valider'>
                    <input class="btn btn-outline-secondary btn-sm" value="retour <-" type="button" onclick="hide_form(event,'modifmail')">
                </span>
                </form>
                <script>
                    document.getElementById('modifmail').style.display = 'none';
                </script>
            </div>
            
            <div>
                <span> âge <?= $req['age'] ?> </span>
            </div>
            
            <div>
                <span1> Date de création du compte : <?= $req['created_at'] ?> </span1>
            </div>
    <br />
    <br />
    
    </div>
     </div>
  
    <br /><br /><br /><br /><br /><br />
    <div class=annonce>
    <h2> Vos annonces:</h2><br />                                                             
        <?php
        $ads_info=$connexion->prepare('SELECT id,title, description, keyWords,created_at,reportCounter FROM "ad" WHERE authorId=:userId');
        $ads_info->bindParam(":userId",$userId);
        $ads_info->execute();
        $ads_info=$ads_info->fetchAll();
        if (count($ads_info) == 0){?>
            <div class="card-body">
                 <h2 class="card-title"> Désolé </h2>
                <h4 class="card-title"> Vous n'avez pas encore d'annonces!(</h4>
            </div>
        <?php } else{
        foreach($ads_info as $ad_info):?>
            <div class="card" style="width: 80rem;">
             <div class="card-body">
                <h5 class="card-title"><?= $ad_info['title'] ?></h5>
                <p class="card-text"><?= $ad_info['description'] ?></p>
             </div>
             <ul class="list-group list-group-flush">
                 <li class="list-group-item"><?= $ad_info['created_at'] ?> </li>
                 <li class="list-group-item">Keywords : <span class="badge badge-secondary"><?=  $ad_info['keywords'] ?></span> </li>
                 <li class="list-group-item"><?= "nombre de signalement" . strval($ad_info['reportcounter'])?></li>
             </ul>
             <div class="card-body">
                <form method="post" action="/delete.php" onsubmit="return confirmation1()" class="form-inline my-2 my-lg-0">
                    <span>
                    <input class="form-control mr-sm-2" name="ad_id" type="hidden" value="<?= $ad_info['id'] ?>" >
                    <button class="btn btn-outline-dark btn-sm" type="submit">Delete</button></form>
                    
                    <form  class="form-inline my-2 my-lg-0" method="post" action="/modifad.php">
                    <input class="form-control mr-sm-2" name="ad_id" type="hidden" value="<?= $ad_info['id'] ?>">
                    <button class="btn btn-outline-primary btn-sm" type="submit">Modifier</button></form>
                    </span>
                </div>
                 </div>
        <?php endforeach;} ?>
    </div>
    
    <div class="lien_utile">
        <h4><a href="/create_ad.php"> Créer votre annonce </a></h4>
    </div>
    
    <br /><br /><br /><br /><br /><br />
    
    <?php
        $admin=$connexion->prepare('SELECT isAdmin FROM "user" WHERE id=:userId');
        $admin->bindParam(":userId",$userId);
        $admin->execute();
        $admin=$admin->fetch();
        if($admin['isadmin']){ ?>
        <div class="p-3 mb-2 bg-secondary text-white">
        <h1>Partie administrateur </h1>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2>Liste des utilisateurs : </h2>
                </div>
                <div class="col-sm-12">
                    <table class="table">
                        <tr>
                            <th>id</th>
                            <th>Pseudo</th>
                            <th>email</th>
                            <th>creation date</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        $users=$connexion->query('SELECT * FROM "user"');
                        $users=$users->fetchAll();
                        foreach($users as $user): ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td><?= $user['username'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['created_at'] ?></td>
                                <td>
                                    <form method="POST" action="/delete.php" onsubmit="return confirmation2()">
                                        <input name="user_id" type="hidden" value="<?= $user['id'] ?>" >
                                        <button  class="btn btn-outline-dark btn-sm" type="submit">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
        <br /><br /><br /><br /><br /><br />
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2>Liste des annonces signalées: </h2>
                </div>
                <div class="col-sm-12">
                    <table class="table">
                        <tr>
                            <th>id</th>
                            <th>authorId</th>
                            <th>titre</th>
                            <th>description</th>
                            <th>Date de création</th>
                            <th>Nombre de signalement</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        $Reports=$connexion->query('SELECT * FROM "ad" WHERE reportCounter!=0');
                        $Reports=$Reports->fetchAll();
                        
                        foreach($Reports as $Report): 
                        $rid=$Report['id']?>
                            <tr>
                                <td><?= $Report['id'] ?></td>
                                <td><?= $Report['authorid'] ?></td>
                                <td><?= $Report['title']?></td>
                                <td><?= $Report['description']?></td>
                                <td><?= $Report['created_at'] ?></td>
                                <td><?= $Report['reportcounter'] ?></td>
                                <td>
                                    <form method="POST" action="/delete.php" onsubmit="return confirmation3()">
                                        <input name="ad_id" type="hidden" value="<?= $Report['id'] ?>" >
                                        <button class="btn btn-outline-dark btn-sm" type="submit">Delete</button>
                                    </form>
                                    
                                    <form method="POST" action="/affreport.php" >
                                        <input name="ad_id" type="hidden" value="<?= $Report['id'] ?>" >
                                        <button class="btn btn-outline-danger btn-sm" type="submit">Voir les signalements</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
        
    <?php }
    else {} ?>
    <br />  <br />
        <br />
        <br />  <br />
        <div class="modifmdp">
      
        <h3> Modifier votre mot de passe  <input class="btn btn-outline-secondary btn-sm" type="button" value="↓" onclick="aff_form('formmdp')"> </h3>
            <div id="formmdp">
                <form name="modifpwd" action="modiftable.php" method="post" onsubmit="return validationmdp(this);">
                        <div>
                        <label for="pwd1"> Nouveau mot de passe</label>
                        <input  type="password" name="pwd1" id="pwd1" required>
                         <small id="wrongPwd1" >
                        </small>
                         </div>
                    <div>
                        <label for="pwd2"> Confirmer le nouveau mot de passe</label>
                        <input name="pwd2" type="password"  id="pwd2" required>
                        <small id="wrongPwd2" >
                        </small>
                    </div>
                    <div id=validate>
                    <br />
                        <input class="btn btn-outline-primary btn-sm" type="submit" value="valider" name="valider" >
                    </div>
                    
                </form>
                <span id="arriere"> retour en arrière <input class="btn btn-outline-secondary btn-sm" value="↑" type="button" onclick="hide_form(event,'formmdp')"></span>
            </div>
    </div>
  <script>
        document.getElementById('formmdp').style.display = 'none';
  </script>
  <br/><br/>
    <div class="lien_utile">
        <p8> Suppression du compte
        <form method="post" action="/delete.php" onsubmit="return confirmation4()">
            <input name="sup_id" id="sup_id" type="hidden" value="<?= $userId ?>" >
            <button type="submit">Supprimer </button>
        </form> </p8>
    </div>
    <script src="membre.js"></script>
    <?php include_once '../src/view/footer.php' ?>
</body>
</html>

