<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of C_Restoran
 *
 * @author Dunja
 */
class C_Restoran extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $korisnik = new stdClass();
        $korisnik->tipKorisnika = 'restoran';
        $this->session->set_userdata('korisnik', $korisnik);
        $korisnik = $this->session->userdata('korisnik');
        switch($korisnik->tipKorisnika){
            case 'gost': redirect('C_Gost'); break;
            case 'gurman': redirect('C_Gurman'); break;
            case 'admin': redirect('C_Admin'); break;
        }
    }
    
    public function index(){ //u indexu da se ide na land
        $this->load->view('sablon/headerRestoran.php', ['title'=>'Pretraga']);
        //dodati sredisnji deo
        $this->load->view('sablon/footer.php');
    }
    
    public function izmenaRestorana(){
        $restoran = $this->M_Restoran->dohvatiRestoran(3);
        
       // $this->M_Restoran->proveriIzmene($restoran);
        $this->load->view('sablon/headerRestoran.php', ['title'=>'Pretraga']);
        $this->load->view('stranice/izmenaRestorana.php', $restoran);
        $this->load->view('sablon/footer.php');
    }
    
    public function pregledRestorana(){
        $restoran = $this->M_Restoran->dohvatiRestoran(3);
        /*$promenljive['brTelefona'] = $restoran->Telefon;
        $promenljive['imeRestorana'] = $restoran->Naziv;
        $promenljive['adresaRestorana'] = $restoran->Adresa;
        $promenljive['radnovreme'] = $restoran->RadnoVreme;
        $promenljive['gradRestorana'] = $restoran->Grad;
        $promenljive['drzavaRestorana'] = $restoran->Drzava;*/
        //$promenljive['slika'] = dohvatiti sliku;
                
        $this->load->view('sablon/headerRestoran.php', ['title'=>'Pretraga']);
        $this->load->view('stranice/pregledRestorana.php', $restoran);
        $this->load->view('sablon/footer.php');
    }
    
    public function izlogujse(){
        //echo 'izlogujse'; dodati i set userdata na Gost
        $korisnik->tipKorisnika = 'gost';
        $this->session->set_userdata('korisnik',$korisnik);
        redirect('C_Gost');
    }
    
    public function kontakt(){
        //proveriti ko je ulogovan i uraditi redirekt
        $this->load->view('sablon/headerRestoran.php', ['title'=>'Kontakt']);
        $this->load->view('stranice/kontakt.php');
        $this->load->view('sablon/footer.php');
    }
    
    public function onama(){
        //proveriti ko je ulogovan i uraditi redirekt
        $this->load->view('sablon/headerRestoran.php', ['title'=>'O nama']);
        $this->load->view('stranice/onama.php');
        $this->load->view('sablon/footer.php');
    }
}



