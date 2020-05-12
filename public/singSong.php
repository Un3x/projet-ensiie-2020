<?php
include_once "../src/Utils/autoloader.php";
$dbAdapter = (new dbFactory())->createService();

if (empty($_GET) || !isset($_GET["action"]) || getDroits() == "visiteur" || getDroits() == "iien") {
    header("Location: /");
}

// 1 : chanter, 2 : ne plus chanter
$action = $_GET["action"] ?? 0;
$cs_id = $_GET["cs_id"] ?? 0;
$soiree_id = $_GET["soiree_id"];
$user_id = $_SESSION["Id"];

if ($action == 1) {
    // On ajoute l'utilisateur et la cs dans chanteur
    $sql=<<<SQL
	INSERT INTO chanteur (id_cs, id_utilisateur)
	VALUES (:cs_id, :user_id)
	ON CONFLICT DO NOTHING
	SQL;

    $result = $dbAdapter->prepare($sql);
    $result->bindValue(':cs_id', $cs_id, PDO::PARAM_INT);
    $result->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $result->execute();
} elseif ($action == 2) {
    // On supprime
    $sql=<<<SQL
	DELETE FROM chanteur
	WHERE id_utilisateur = :user_id AND id_cs = :cs_id
	SQL;

    $result = $dbAdapter->prepare($sql);
    $result->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $result->bindValue(':cs_id', $cs_id, PDO::PARAM_INT);
    $result->execute();
}

header("Location: /viewSoiree.php?id=" . $soiree_id);
