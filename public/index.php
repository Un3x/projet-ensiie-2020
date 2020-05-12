<?php

include '../src/Book.php';
include '../src/BookRepository.php';
include '../src/Factory/DbAdapterFactory.php';

//create the database connection
$dbAdapter = (new DbAdapterFactory())->createService();
$bookRepository = new \Book\BookRepository($dbAdapter);

$data =['books'=> $bookRepository->fetchAll()];

include_once '../src/View/template.php';
loadView('accueil',$data);
?>