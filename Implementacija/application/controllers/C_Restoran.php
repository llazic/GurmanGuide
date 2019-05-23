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
class C_Restoran extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $korisnik = new stdClass();
        $korisnik->tipKorisnika = 'restoran';
        $this->session->set_userdata('korisnik', $korisnik);
        $korisnik = $this->session->userdata('korisnik');
        switch ($korisnik->tipKorisnika) {
            case 'gost': redirect('C_Gost');
                break;
            case 'gurman': redirect('C_Gurman');
                break;
            case 'admin': redirect('C_Admin');
                break;
        }
    }

    public function index() { //u indexu da se ide na land
        $this->load->view('sablon/headerRestoran.php', ['title' => 'Pretraga']);
        //dodati sredisnji deo
        $this->load->view('sablon/footer.php');
    }

    public function izmenaRestorana() {
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
        $this->load->view('sablon/headerRestoran.php', ['title' => 'Pretraga']);
        $this->load->view('stranice/izmenaRestorana.php', $info);
        $this->load->view('sablon/footer.php');
    }

    public function pregledRestorana() {
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

        $this->load->view('sablon/headerRestoran.php', ['title' => 'Pretraga']);
        $this->load->view('stranice/pregledRestorana.php', $info);
        $this->load->view('sablon/footer.php');
    }

    public function izlogujse() {
        //echo 'izlogujse'; dodati i set userdata na Gost
        $korisnik->tipKorisnika = 'gost';
        $this->session->set_userdata('korisnik', $korisnik);
        redirect('C_Gost');
    }

    public function kontakt() {
        //proveriti ko je ulogovan i uraditi redirekt
        $this->load->view('sablon/headerRestoran.php', ['title' => 'Kontakt']);
        $this->load->view('stranice/kontakt.php');
        $this->load->view('sablon/footer.php');
    }

    public function regex_check($str) {
        if (preg_match("/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})/i", $str)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('regex_check', 'Mejl nije u očekivanom formatu');
            return FALSE;
        }
    }

    public function sacuvajIzmeneRestorana() {
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

    public function onama() {
        //proveriti ko je ulogovan i uraditi redirekt
        $this->load->view('sablon/headerRestoran.php', ['title' => 'O nama']);
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

        $this->load->view('sablon/headerRestoran.php', ['title' => 'Pregled profila']);
        $this->load->view('stranice/pregledGurmana.php', $info);
        $this->load->view('sablon/footer.php');
    }

    public function unosJela($poruka = null) {

        $this->load->view('sablon/headerRestoran.php', ['title' => 'Unos jela']);
        $this->load->view('stranice/unosJela.php', ['poruka' => $poruka]);
        $this->load->view('sablon/footer.php');
    }

    public function unesiJelo() {
        var_dump($_POST);
        $poruka = '';
        $uneto['naziv'] = $this->input->post('naziv');
        $uneto['opisjela'] = $this->input->post('opisjela');
        $uneto['idKorisnik'] = 3;

        $this->form_validation->set_rules('naziv', 'Naziv', 'required|trim', array('required' => 'Niste uneli naziv jela.'));
        $this->form_validation->set_rules('opisjela', 'Opis', 'required|trim', array('required' => 'Niste uneli opis jela.'));



        if ($this->form_validation->run() == FALSE) {
            $this->unosJela();
        } else {

            $postojiJelo = $this->M_Jelo->proveriNazivJela($uneto);
            if ($postojiJelo != null) {
                $poruka = 'Jelo sa datim imenom vec postoji!';
                $this->unosJela($poruka);
            } else {
                $poslednjiId = $this->M_Jelo->poslednjiId()->poslednjiId;
                $uneto['idJela'] = $poslednjiId + 1;
                $this->M_Jelo->napraviJelo($uneto);
                
                $brojacSastojaka = 0;
                foreach ($_POST as $key => $value) {
                    if (strlen(strstr($key, "name")) > 0) {
                        $brojacSastojaka = $brojacSastojaka + 1;
                        $imeSastojka = strtolower($value);

                        $postojiSastojak = $this->M_Sastojak->postojiSastojak($imeSastojka);

                        if ($postojiSastojak != null) {
                            $idSastojka = $postojiSastojak->IdSastojak;
                        } else {
                            $idSastojka = $this->M_Sastojak->dodajSastojak($imeSastojka);
                        }
                        $this->M_Jelo->poveziSastojakSaJelom($idSastojka, $uneto['idJela']);
                    } 
                }
                if ($brojacSastojaka == 0) {
                    $this->M_Jelo->obrisiJelo($uneto['idJela']);
                    $poruka = "Nisu uneti sastojci!";
                    $this->unosJela($poruka);
                } else {
                    redirect('C_Restoran/index');
                }
            }
        }
    }
    
    public function pretragaJelaPoRestoranu($val) {
        $input = str_replace('%20', ' ', $val);
        $input = trim($input);
        
        $jela = $this->M_Restoran->dohvatiJelaRestorana($input);
        
        $niz = [];
        
        foreach ($jela as $jelo) {
            $klasa = new stdClass();
            $klasa->IdJelo = $jelo->IdJelo;
            $klasa->IdRestoran = $jelo->IdKorisnik;
            $klasa->Opis = $jelo->Opis;
            $klasa->Naziv = $jelo->Naziv;
            $klasa->Putanja = $this->M_Slika->dohvatiPutanju($jelo->IdSlika)->Putanja;
            $klasa->Recenzija = $this->M_Recenzija->dohvatiJednuRecenziju($jelo->IdJelo);
            
            if ($klasa->Recenzija == null) {
                $klasa->Recenzija = "Nema recenzije za ovo jelo.";
            } else {
                $klasa->Recenzija = $klasa->Recenzija->Komentar;
            }
            
            $klasa->Restoran = $this->M_Restoran->dohvatiRestoran($jelo->IdKorisnik)->imeRestorana;
            
            $sastojci = $this->M_Sastojak->dohvatiSastojkeJela($jelo->IdJelo);
            
            $sastojciString = "";
            
            for ($i = 0; $i < count($sastojci); $i++) {
                $sastojciString .= $sastojci[$i]->Naziv;
                
                if ($i != (count($sastojci) - 1)) {
                    $sastojciString .= ", ";
                }
                
            }
            
            $klasa->Sastojci = $sastojciString;
            
            $niz [] = $klasa;
        }
        
        $this->load->view("sablon/headerRestoran.php", ['title' => 'Meni restorana']);
        $this->load->view("stranice/rezultatPretrage.php", ['jela' => $niz/*, 'naslovStranice' =>'Meni restorana'*/]);
    }
    
    public function prikaziMeniRestorana(){
        $imeRestorana = $this->M_Restoran->dohvatiRestoran(3)->imeRestorana;
        $this->pretragaJelaPoRestoranu($imeRestorana);
    }

}
