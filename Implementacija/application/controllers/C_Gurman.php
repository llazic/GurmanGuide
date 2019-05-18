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
class C_Gurman extends CI_Controller {

    public function __construct() {
        parent::__construct();
//        $korisnik = new stdClass();
//        $korisnik->tipKorisnika = 'gurman';
//        $this->session->set_userdata('korisnik', $korisnik);
        $korisnik = $this->session->userdata('korisnik');
        switch ($korisnik->tipKorisnika) {
            case 'gost': redirect('C_Gost');
                break;
            case 'restoran': redirect('C_Restoran');
                break;
            case 'admin': redirect('C_Admin');
                break;
        }
    }

    public function index($poruka = null) {
        $this->load->view('sablon/headerGurman.php', ['title' => 'Pretraga']);
        //dodati pretragu kao sredinu
        $this->load->view('sablon/footer.php');
    }

    public function izmenaProfila() {
        $korisnik = $this->session->userdata('korisnik');
        $gurman = $this->M_Gurman->dohvatiGurmana($korisnik->id);

        $promenljive['korisnickoIme'] = $gurman->KorisnickoIme;
        $promenljive['lozinka'] = $gurman->Lozinka;
        $promenljive['email'] = $gurman->Email;
        $promenljive['ime'] = $gurman->Ime;
        $promenljive['prezime'] = $gurman->Prezime;
        $promenljive['pol'] = $gurman->Pol;

        $this->load->view('sablon/headerGurman.php', ['title' => 'Moj profil']);
        $this->load->view('stranice/izmenaProfilaGurmana.php', $promenljive);
        $this->load->view('sablon/footer.php');
    }

    public function izlogujSe() {
        $korisnik->tipKorisnika = 'gost';
        $this->session->set_userdata('korisnik', $korisnik);
        redirect('C_Gost');
    }

    public function kontakt() {

        $this->load->view('sablon/headerGurman.php', ['title' => 'Kontakt']); //ako je gurman ulogovan
        $this->load->view('stranice/kontakt.php');
        $this->load->view('sablon/footer.php');
    }

    public function onama() {

        $this->load->view('sablon/headerGurman.php', ['title' => 'O nama']); //ako je gurman ulogovan
        $this->load->view('stranice/onama.php');
        $this->load->view('sablon/footer.php');
    }

    public function sacuvajIzmene() {
        $info['sifra'] = $this->input->post("lozinkagurman");
        //$info['sifraPotvrda'] = $this->input->post("potvrdalozinkegurman");
        $info['ime'] = $this->input->post("imegurman");
        $info['prezime'] = $this->input->post("prezimegurman");
        $info['pol'] = $this->input->post("pol");
        $info['slika'] = $this->input->post("slikagurman");

        $this->form_validation->set_rules('lozinkagurman', 'Sifra', 'required', array('required' => 'Niste uneli šifru'));
        $this->form_validation->set_rules('potvrdalozinkegurman', 'Potvrda sifre', 'required|matches[lozinkagurman]', array('required' => 'Niste uneli potvrdu šifre', 'matches' => 'Šifre koje ste uneli se ne poklapaju'));
        $this->form_validation->set_rules('imegurman', 'Ime', 'required|trim', array('required' => 'Niste uneli ime.'));
        $this->form_validation->set_rules('prezimegurman', 'Prezime', 'required|trim', array('required' => 'Niste uneli prezime.'));
        $this->form_validation->set_rules('pol', 'Pol', 'required', array('required' => 'Niste odabrali pol'));
        //provera za sliku?
//        if ($this->form_validation->run() == FALSE) {
//            $this->izmenaProfila();
//        } else {
        $korisnik = $this->session->userdata('korisnik');
//            
//            if (!file_exists("./uploads/gurman/" ."$korisnik->id")) {
//                mkdir("./uploads/gurman/" ."$korisnik->id", 0777, true);
//            }
//            
//            //ako je uploadovana slika
//            if (isset($_FILES['slikagurman']) && $_FILES['slikagurman']['error'] != UPLOAD_ERR_NO_FILE) {
//                
//                $putanjaDoFoldera = "http://localhost/GurmanGuide/Implementacija/uploads/gurman/" ."$id";
//                if (($putanjaDoSlike = $this->upload($putanjaDoFoldera, "profil", "slikagurman")) == null) {
//                    $this->registrujGurmana("Greška pri otpremanju slike. Slika mora da zadovoljava sledeće kriterijume: <br /> "
//                            . "Podržani formati: gif, jpg, png. <br />"
//                            . "Maksimalna veličina 1000 bajtova. <br />"
//                            . "Maksimalna rezolucija 2048x1024px.");
//                } else {
//                    $poslednjaSlika = $this->M_Slika->poslednjiId()->poslednjiId;
//                    $slikaId = $poslednjaSlika + 1;
//                    
//                    $slika = new stdClass();
//                    $slika->IdSlika = $slikaId;
//                    $slika->Putanja = $putanjaDoSlike;
//                    $this->M_Slika->unesiSliku($slika);
//                }
//            }
        $info['id'] = $korisnik->id;
        $this->M_Gurman->azuriranjeGurmana($info);
        $this->index('Uspesno napravljene izmene.');
//        }
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
