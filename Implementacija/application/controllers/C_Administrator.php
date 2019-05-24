<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of C_Administrator
 *
 * @author Nikola
 */
class C_Administrator extends CI_Controller{
    public function __construct() {
        parent::__construct();
        
        $korisnik = $this->session->userdata('korisnik');
        
        if ($korisnik == null){
            $korisnik = new stdClass();
            $korisnik->tipKorisnika = 'gost';
            $this->session->set_userdata('korisnik', $korisnik);
        }
        switch ($korisnik->tipKorisnika) {
            case 'gost': redirect('C_Gost');
                break;
            case 'restoran': redirect('C_Restoran');
                break;
            case 'gurman': redirect('C_Gurman');
                break;
        }
    }
    
    public function index(){
         $this->load->view('sablon/headerAdmin.php', ['title' => 'Pregled profila']);
         //fali nesto ovde
          $this->load->view('sablon/footer.php');
    }
    public function upravljanjeJelima() {
        $jela = $this->M_Jelo->dohvatiNepregledanaJela();
        $sastojci = NULL;
        $rest = NULL;
        if($jela!=NULL){
            foreach ($jela as $jelo) {
                $sastojci[ $jelo->IdJelo ] = $this->M_Sastojak->dohvatiSastojkeJela($jelo->IdJelo);
                $rest[$jelo->IdJelo] = $this->M_Restoran->dohvatiIme($jelo->IdKorisnik);
             
            }
        }
        $this->load->view('sablon/headerAdmin.php', ['title' => 'Pregled profila']);
        $this->load->view('stranice/upravljanjeJelima.php',['jela'=>$jela,'sastojci'=>$sastojci,'restoran'=>$rest]);
        $this->load->view('sablon/footer.php');
    }
    public function izlogujSe() {
        $korisnik = new stdClass();
        $korisnik->tipKorisnika = 'gost';
        $this->session->set_userdata('korisnik', $korisnik);
        redirect('C_Gost');
    }
    
    function pregledProfilaGurmana($idGurman) {
        $gurman = $this->M_Gurman->dohvatiGurmana($idGurman);
        $recenzije = $this->M_Recenzija->dohvatiRecenzijeGurmana($idGurman);
        
        
        $info['slikagurman'] = $this->M_Slika->dohvatiPutanju($gurman->IdSlika)->Putanja;
        $info['korime'] = $gurman->KorisnickoIme;
        $info['lozinka'] = $gurman->Lozinka;
        $info['email'] = $gurman->Email;
        $info['ime'] = $gurman->Ime;
        $info['prezime'] = $gurman->Prezime;
        $info['pol'] = $gurman->Pol;
        $info['recenzije'] = $recenzije;
        
        $this->load->view('sablon/headerAdmin.php', ['title' => 'Pregled profila']);
        $this->load->view('stranice/pregledGurmana.php', $info);
        $this->load->view('sablon/footer.php');
    }
}

