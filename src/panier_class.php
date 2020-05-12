<?php

class panier{

    private $DB;


    public function __construct($DB){
        if(!isset($_SESSION)){
            session_start();
        }
        if(!isset($_SESSION['panier'])){
            $_SESSION['panier']=array();
        }
        $this->DB=$DB;
    }

    public function add($product_id){
        if(isset($_SESSION['panier'][$product_id])){
            $_SESSION['panier'][$product_id]++;
        }else {
            $_SESSION['panier'][$product_id]=1;
        }

        
    }

    public function del($product_id){
        if($_SESSION['panier'][$product_id] >= 2){
            $_SESSION['panier'][$product_id]=$_SESSION['panier'][$product_id]-1;
        }
        else {
            unset($_SESSION['panier'][$product_id]);  
        }
        
    }
 
    public function total(){
        $total=0;
        $ids=array_keys($_SESSION['panier']);
        $usersData = $this->DB->fetchAll_panier($ids);
        
        foreach($usersData as $product){
            $total = $total + ($product->getPrix_aliment() * $_SESSION['panier'][$product->getId_aliment()]);
        }
        
        return $total;
    }






}