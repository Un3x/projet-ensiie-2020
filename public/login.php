<?php
include_once "../src/Utils/autoloader.php";
$dbAdapter = (new dbFactory())->createService();

if (isset($_SESSION) && !empty($_SESSION["Id"])) {
    $sql = <<<SQL
    SELECT pseudo, nom, prenom, role_utilisateur FROM utilisateur WHERE id LIKE :id
SQL;
    $result = $dbAdapter->prepare($sql);
    $result->bindValue(':id', $_SESSION["Id"], PDO::PARAM_STR);
    $result->execute();
    $row = $result->fetch();
    $_SESSION["Pseudo"] = $row["pseudo"];
    $_SESSION["Nom"] = $row["nom"];
    $_SESSION["Prenom"] = $row["prenom"];
    $_SESSION["Droits"] = $row["role_utilisateur"];

    $_SESSION["Authenticated"] = 1;
}

header("Location: /");
