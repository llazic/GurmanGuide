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
        $korisnik = $this->session->userdata('korisnik');
        $restoran = $this->M_Restoran->dohvatiRestoran(3);
        
        $info['korime'] = $restoran->korime;
        $info['lozinka'] = $restoran->lozinka;
        $info['email'] = $restoran->email;
        $info['brTelefona'] = $restoran->brTelefona;
        $info['imeRestorana'] = $restoran->imeRestorana;
        $info['radnoVreme'] = $restoran->radnoVreme;
        $info['adresaRestorana'] = $restoran->adresaRestorana;
        $info['gradRestorana'] = $restoran->gradRestorana;
        $info['drzavaRestorana'] = $restoran->drzavaRestorana;
       // $this->M_Restoran->proveriIzmene($restoran);
        $this->load->view('sablon/headerRestoran.php', ['title'=>'Pretraga']);
        $this->load->view('stranice/izmenaRestorana.php', $info);
        $this->load->view('sablon/footer.php');
    }
    
    public function pregledRestorana(){
        $korisnik = $this->session->userdata('korisnik');
        $restoran = $this->M_Restoran->dohvatiRestoran(3);
        
        $info['korime'] = $restoran->korime;
        $info['lozinka'] = $restoran->lozinka;
        $info['email'] = $restoran->email;
        $info['brTelefona'] = $restoran->brTelefona;
        $info['imeRestorana'] = $restoran->imeRestorana;
        $info['radnoVreme'] = $restoran->radnoVreme;
        $info['adresaRestorana'] = $restoran->adresaRestorana;
        $info['gradRestorana'] = $restoran->gradRestorana;
        $info['drzavaRestorana'] = $restoran->drzavaRestorana;
                
        $this->load->view('sablon/headerRestoran.php', ['title'=>'Pretraga']);
        $this->load->view('stranice/pregledRestorana.php', $info);
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
    
       
    public function regex_check($str) {
        if (preg_match("/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})/i", $str))
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('regex_check', 'Mejl nije u očekivanom formatu');
            return FALSE;
        }
    }
    
    public function sacuvajIzmeneRestorana(){
        $promenljive['lozinkarestoran'] = $this->input->post('lozinkarestoran');
        $potvrdalozinkerestoran = $this->input->post('potvrdalozinkerestoran');
        $promenljive['telefon'] = $this->input->post('telefon');
        $promenljive['imerestorana'] = $this->input->post('imerestorana');
        $promenljive['radnovreme'] = $this->input->post('radnovreme');
        $promenljive['adresarestorana'] = $this->input->post('adresarestorana');
        $promenljive['gradrestorana'] = $this->input->post('gradrestorana');
        $promenljive['drzavarestorana'] = $this->input->post('drzavarestorana');
        
        $this->form_validation->set_rules('lozinkarestoran', 'Sifra', 'required', array('required' => 'Niste uneli šifru.'));
        $this->form_validation->set_rules('potvrdalozinkerestoran', 'Potvrda sifre', 'required|matches[lozinkarestoran]', array('required' => 'Niste uneli potvrdu šifre.', 'matches' => 'Šifre koje ste uneli se ne poklapaju.'));
        $this->form_validation->set_rules('telefon', 'Telefon', 'required|trim', array('required' => 'Niste uneli broj telefona.'));
        $this->form_validation->set_rules('imerestorana', 'Naziv', 'required|trim', array('required' => 'Niste uneli naziv restorana.'));
        $this->form_validation->set_rules('radnovreme', 'Radno Vreme', 'required', array('required' => 'Niste uneli radno vreme.'));
        $this->form_validation->set_rules('adresarestorana', 'Adresa', 'required', array('required' => 'Niste uneli adresu.'));
        $this->form_validation->set_rules('gradrestorana', 'Grad', 'required', array('required' => 'Niste uneli grad.'));
        $this->form_validation->set_rules('drzavarestorana', 'Drzava', 'required', array('required' => 'Niste uneli državu.'));
        
        if ($this->form_validation->run() == FALSE) {
            $this->izmenaRestorana();
        } else {
            //$korisnik = $this->session->userdata('korisnik');
            $promenljive['id'] = 3;
            $this->M_Restoran->azuriranjeRestorana($promenljive);
            $this->index('Uspesno napravljene izmene.');
        }
        
    }
 
    
    public function onama(){
        //proveriti ko je ulogovan i uraditi redirekt
        $this->load->view('sablon/headerRestoran.php', ['title'=>'O nama']);
        $this->load->view('stranice/onama.php');
        $this->load->view('sablon/footer.php');
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
        
        $this->load->view('sablon/headerGost.php', ['title' => 'Pregled profila']);
        $this->load->view('stranice/pregledGurmana.php', $info);
        $this->load->view('sablon/footer.php');
    }
}



