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
        $korisnik = new stdClass();
        $korisnik->tipKorisnika = 'gurman';
        $this->session->set_userdata('korisnik', $korisnik);
        $korisnik = $this->session->userdata('korisnik');
        switch($korisnik->tipKorisnika){
            case 'gost': redirect('C_Gost'); break;
            case 'restoran': redirect('C_Restoran'); break;
            case 'admin': redirect('C_Admin'); break;
        }
    }
    
    public function index(){
        $this->load->view('sablon/headerGurman.php', ['title' => 'Pretraga']);
        //dodati pretragu kao sredinu
        $this->load->view('sablon/footer.php');
    }
    
    public function izmenaProfila(){
//        $korisnik = $this->session->userdata('korisnik');
//        $gurman = $this->M_Gurman->dohvatiGurmana($korisnik);
        $gurman = $this->M_Gurman->dohvatiGurmana(4);
        $promenljive['korisnickoIme'] = $gurman->KorisnickoIme;
        $promenljive['lozinka'] = $gurman->Lozinka;
        $promenljive['email'] = $gurman->Email;
        $promenljive['ime'] = $gurman->Ime;
        $promenljive['prezime'] = $gurman->Prezime;
        $promenljive['pol'] = $gurman->Pol; //pol ne radi dobro
        //$promenljive['slika'] = dohvatiti sliku;
        
        $this->load->view('sablon/headerGurman.php', ['title' => 'Moj profil']);
        $this->load->view('stranice/izmenaProfilaGurmana.php', $promenljive);
        $this->load->view('sablon/footer.php');
    }
    
    public function izlogujSe(){
        $korisnik->tipKorisnika = 'gost';
        $this->session->set_userdata('korisnik',$korisnik);
        redirect('C_Gost');
    }
    
    public function kontakt(){
        
        $this->load->view('sablon/headerGurman.php', ['title' => 'Kontakt']);//ako je gurman ulogovan
        $this->load->view('stranice/kontakt.php');
        $this->load->view('sablon/footer.php');
    }
    
    public function onama(){
        
        $this->load->view('sablon/headerGurman.php', ['title' => 'O nama']);//ako je gurman ulogovan
        $this->load->view('stranice/onama.php');
        $this->load->view('sablon/footer.php');
    }
    
    public function sacuvajIzmene(){
        
    }
}

