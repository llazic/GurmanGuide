<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of C_Gurman
 *
 * @author Lazar
 */
class C_Gurman extends CI_Controller{
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->load->view('sablon/headerGurman.php');
        $this->load->view('sablon/footer.php');
    }
    
    public function izmenaProfila(){
        echo 'izmenaProfila';
        //$this->load->view('sablon/proba.html');
    }
    
    public function izlogujSe(){
        echo 'izlogujSe';
        $this->load->view('sablon/proba.html');
    }
    
    public function kontakt(){
        //provera ko je ulogovan i redirekcija
        $this->load->view('sablon/headerGurman.php');//ako je gurman ulogovan
        $this->load->view('stranice/kontakt.php');
        $this->load->view('sablon/footer.php');
    }
    
    public function onama(){
        //provera ko je ulogovan i redirekcija
        $this->load->view('sablon/headerGurman.php');//ako je gurman ulogovan
        $this->load->view('stranice/onama.php');
        $this->load->view('sablon/footer.php');
    }
}

