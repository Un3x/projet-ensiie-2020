<?php


use Book\BookRepository;


include '../src/Book.php';
include '../src/BookRepository.php';
include '../src/Factory/DbAdapterFactory.php';

$dbAdapter = (new DbAdapterFactory())->createService();

// Permet d'emprunter un livre suivant son Id uniquement si on est connecté, sinon nous demande de nous connecter
$bookId = $_POST['book_id'] ?? null;
if ($bookId) {
    session_start();
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
        $bookRepository = new BookRepository($dbAdapter);
        $bookRepository->borrow($bookId);
        include_once '../src/View/template.php';
    $data = ['books'=> $bookRepository->fetchAll()];
    loadView('home',$data);
    }
    else{
        include_once '../src/View/template.php';
        $data = [];
        loadView('login',$data);
    }
}

$delBookId = $_GET['delBookId'] ?? null;
if($delBookId){
    $bookRepository = new BookRepository($dbAdapter);
    $bookRepository->delete($delBookId);
    include_once '../src/View/template.php';
    $data = ['books'=> $bookRepository->fetchAll()];
    loadView('home',$data);
}

$renduBook = $_GET['rendu'] ?? null;
if($renduBook){
    $bookRepository = new BookRepository($dbAdapter);
    $bookRepository->rendre($renduBook);
    include_once '../src/View/template.php';
    $data = ['books'=> $bookRepository->fetchAll()];
    loadView('home',$data);
}

//Permet d'afficher des suggestions de Nom lors de la recherche
$search = $_GET['search'] ?? null;
if($search){
    $bookRepository = new BookRepository($dbAdapter);
    $bookRepository->getHint($search);
}
//permet d'afficher les oeuvres suite à une recherche
$bookName = $_POST['book'] ?? null;
if($bookName){
    $bookRepository = new BookRepository($dbAdapter);
    $data = ['books'=> $bookRepository->findBookByName($bookName)];
    include_once '../src/View/template.php';
    loadView('home',$data);
}

//lorsqu'on clique sur un lien Sign up, charge la page d'enregistrement
$compte = $_GET['compte'] ?? null;
if($compte){
    include_once '../src/View/template.php';
    $data = [];
    loadView('register',$data);
}

//lance la fonction qui ajoute un user dans la BDD
$register = $_GET['register'] ?? null;
if($register){
    $bookRepository = new BookRepository($dbAdapter);
    $bookRepository->register($_POST["username"],$_POST["password"],$_POST["confirm_password"]);
}

//lorsqu'on clique sur un lien login, charge la page de connexion
$loggingin = $_GET['log'] ?? null;
if($loggingin){
    include_once '../src/View/template.php';
    $data = [];
    loadView('login',$data);
}

//lance la fonction qui connecte un utilisateur
$login = $_GET['login'] ?? null;
if($login){
    $bookRepository = new BookRepository($dbAdapter);
    $bookRepository->login($_POST["username"],$_POST["password"]);
}

//déconnecte l'utilisateur
$logout = $_GET['logout'] ?? null;
if($logout){
    session_start(); //initialize session
    $_SESSION = array(); //clean session
    session_destroy(); //destroy session
    header("Location: index.php");
}

//lance la page de gestion des livres des administrateurs
$gestion = $_GET['gestion'] ?? null;
if($gestion){
    include_once '../src/View/template.php';
    $data = [];
    loadView('gestion',$data);
}

//lance la fonction d'ajout d'un livre
$addBook = $_POST['title'] ?? null;
$auteuraddBook = $_POST['auteur'] ?? null;
if ($addBook && $auteuraddBook) {
    $file = $_FILES["imageToUpload"] ;
    $descr = $_POST['descr'] ?? null;
    $bookRepository = new BookRepository($dbAdapter);
    $bookRepository->add($addBook,$auteuraddBook,$descr,$file);
    include_once '../src/View/template.php';
    $data = ['books'=> $bookRepository->fetchAll()];
    loadView('home',$data);
}

//affiche la page du détail de l'oeuvre en fonction de son ID
$descBook = $_GET['descBook'] ?? null;
if($descBook){
    $bookRepository = new BookRepository($dbAdapter);
    $data = ['books'=>$bookRepository->findBookById($descBook)];
    include_once '../src/View/template.php';
    loadView('description',$data);
}

$home = $_GET['home'] ?? null;
if($home){
    include_once '../src/View/template.php';
    $bookRepository = new BookRepository($dbAdapter);
    $data=['books'=>$bookRepository->fetchAll()];
    loadView('home',$data);
}

$likes = $_POST['likes'] ?? null;
if ($likes){
    $bookId=$_POST['id_book'];
    $bookRepository = new BookRepository($dbAdapter);
    $bookRepository->likes($likes,$bookId);
    include_once '../src/View/template.php';
    $data=['books'=>$bookRepository->fetchAll()];
    loadView('home',$data);
}

$dislikes = $_POST['dislikes'] ?? null;
if ($dislikes){
    $bookId=$_POST['id_book'];
    $bookRepository = new BookRepository($dbAdapter);
    $bookRepository->dislikes($dislikes,$bookId);
    include_once '../src/View/template.php';
    $data=['books'=>$bookRepository->fetchAll()];
    loadView('home',$data);
}

?>