<?php

require_once 'models/DetailDistribusi.php';
require_once 'config/database.php';

class DetailDistribusiController{
    private $detaildistrimodel;

    public function __construct(){
        $this->detaildistrimodel = new DetailDistribusi();
    }

    public function getAllDetails(){
        return $this->detaildistrimodel->getAll();
    }        
    public function index(){
        $details = $this->detaildistrimodel->getAll();
        $barang = $this->detaildistrimodel->getAllBarang();
        include 'views/content/detail_distribusi.php';
    }        
}
?>