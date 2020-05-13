<?php
   /* $db_server = 'localhost'; // Adresse du serveur MySQL
    $db_name = '';            // Nom de la base de données
    $db_user_login = 'root';  // Nom de l'utilisateur
    $db_user_pass = '';       // Mot de passe de l'utilisateur */

    // Ouvre une connexion au serveur MySQL

    include_once '../src/Factory/DbAdaperFactory.php';
    $conn = (new DbAdaperFactory())->createService();

     // Récupère la recherche
     $recherchead =  isset($_POST['recherche']) ? "%" . $_POST['recherche'] . "%" : "%" ;

     // la requete mysql
    $sql=
    <<<SQL
    SELECT title,username,likes,ad.keyWords,ad.id,ad.description, "ad".created_at
    FROM ("user" JOIN "ad" ON authorId = "user".id)
    WHERE (username LIKE :recherchead) OR (ad.keyWords LIKE :recherchead) OR ("user".keyWords LIKE :recherchead) OR (ad.description LIKE :recherchead) ORDER BY likes, "ad".created_at LIMIT 30
SQL;
    $q = $conn->prepare($sql);
    $q->bindParam(":recherchead", $recherchead,PDO::PARAM_STR);

    $q->execute();
    $q = $q->fetchAll();
    if (count($q) != 0){
    foreach($q as $r) {?>
         <div class="card" style="width: 80rem;">
             <div class="card-body">
                 <h5 class="card-title"><?= $r['title'] ?></h5>

                 <p class="card-text"><?= $r['description'] ?></p>
             </div>
             <ul class="list-group list-group-flush">
                 <li class="list-group-item"><?= $r['created_at'] ?> </li>
                 <li class="list-group-item">Keywords : <span class="badge badge-secondary"><?=  $r['keywords'] ?></span> </li>
             </ul>
             <div class="card-body">
                 <form action="add.php" method="post" class="form-inline my-2 my-lg-0">
                     <input class="form-control mr-sm-2" type="hidden" id="ad" name="ad" value="<?=  $r['id'] ?>">
                     <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Aller voir l'annonce !</button>
                 </form>
             </div>
         </div>
        <?php  }
    }
else  { ?>
    <div class="card-body">
                 <h2 class="card-title"> Désolé </h2>
        <h4 class="card-title"> Nous n'avons rien trouvé :(</h4>
        <img class="fit-picture" src="burned_match.png" alt="Burned match">
    </div>
<?php  }  ?>
