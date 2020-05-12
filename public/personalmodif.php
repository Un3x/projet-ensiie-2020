<?php
/*
use User\UserRepository;
*/
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);

$id = $_POST['id'] ?? 0;
$nom = $_POST['nom'] ?? null;
$prenom = $_POST['prenom'] ?? null;
$pseudo= $_POST['pseudo'] ?? null;
$email= $_POST['email'] ?? null;
$password= $_POST['password'] ?? null;
$adresse= $_POST['adresse'] ?? null;
$telephone= $_POST['telephone'] ?? null;

$user=$userRepository->select($id);

if ($id!=0)
{   
    if($pseudo&&$password){
        $userRepository->modif($id,$nom,$prenom,$pseudo,$email,$password,$adresse,$telephone);
        header('Location: usercnt.php');
    }
    else{
		//echo '<h1>Le mot de passe et le pseudo doivent être existant</h1>';         
    }
}
else 
{
    //afficher erreur
}


//header('Location: test.php');
/*
include_once '../public/template.php';
loadView('usercnt', $id);
*/
header('Location: usercnt.php');
/*
if ($user->getRole()=="Membre")
{
    loadView('test',$id);    
}
if ($user->getRole()=="Administrateur")
{
    loadView('testadm',$id);    
}
*/

?>
