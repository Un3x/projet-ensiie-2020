

<?php
// Connexion à la base de données
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
// verrif email et mdp
if ((htmlspecialchars($_POST['password']))!=htmlspecialchars($_POST['password2'])){
    header("Status: 301 Moved Permanently", false, 301);  
    header("Location: /coroshop/public/formulaire_creation_perso.php?p=false");
}
else{
    $pass=password_hash(htmlspecialchars($_POST['password']),PASSWORD_DEFAULT);
    $req2 = $bdd->prepare('SELECT ID_personne FROM personne where adresse_mail=?');
    $req2->execute(array($_POST['adresse_mail']));
    $r=$req2->fetch();
    if (isset($r['ID_personne'])){
        header("Status: 301 Moved Permanently", false, 301);
        header("Location: /coroshop/public/formulaire_creation_perso.php?a=false");
    }
    else {
        $req1 = $bdd->prepare('INSERT INTO personne (nom, prenom,adresse_mail,adresse_postal,date_de_naissance,numero_de_telephone,mdp_hachee) VALUES(:nom, :prenom,:adresse_mail,:adresse_postal,:date_de_naissance,:numero_de_telephone,:mdp_hachee)');
        $req1->execute(array('nom'=>htmlspecialchars($_POST['nom']),
        'prenom'=> htmlspecialchars($_POST['prenom']),
        'adresse_mail'=>htmlspecialchars($_POST['adresse_mail']),
        'adresse_postal'=>htmlspecialchars($_POST['adresse_postal']),
        'date_de_naissance'=>htmlspecialchars($_POST['date_de_naissance']),
        'numero_de_telephone'=>htmlspecialchars($_POST['numero_de_telephone']),
        'mdp_hachee' =>$pass));

        if (isset($_POST['connexion'])){
            setcookie('adresse_mail', $_POST['adresse_mail'], time() + 365*24*3600, null, null, false, true);
            setcookie('pass', $pass, time() + 365*24*3600, null, null, false, true);
        }
        session_start();
        $_SESSION['adresse_mail'] = htmlspecialchars($_POST['adresse_mail']);
        header("Status: 301 Moved Permanently", false, 301);
        header('Location: ../index.php');
}}
?>
