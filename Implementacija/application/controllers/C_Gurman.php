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
            case 'admin': redirect('C_Admin');
                break;
        }
    }

    public function index($poruka = null) {
        $this->load->view('sablon/headerGurman.php', ['title' => 'Pretraga']);
        //dodati pretragu kao sredinu
        $this->load->view('sablon/footer.php');
    }

    public function izlogujSe() {
        $korisnik = new stdClass();
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

    public function izmenaProfila($poruka = null) {
        $korisnik = $this->session->userdata('korisnik');
        $gurman = $this->M_Gurman->dohvatiGurmana($korisnik->id);
        $slika = $this->M_Slika->dohvatiPutanju($gurman->IdSlika);
        
        $promenljive = array(
            'korisnickoIme' => $gurman->KorisnickoIme,
            'lozinka' => $gurman->Lozinka,
            'email' => $gurman->Email,
            'ime' => $gurman->Ime,
            'prezime' => $gurman->Prezime,
            'pol' => $gurman->Pol,
            'slika' => $slika->Putanja,
            'poruka' => $poruka
        );

        $this->load->view('sablon/headerGurman.php', ['title' => 'Moj profil']);
        $this->load->view('stranice/izmenaProfilaGurmana.php', $promenljive);
        $this->load->view('sablon/footer.php');
    }
    
    public function upload($putanja, $imeSlike, $vrstaSlike) {
        if(!file_exists($putanja)) {
           mkdir($putanja, 0777, true);
        }
        if (isset($_FILES["$vrstaSlike"]) && $_FILES["$vrstaSlike"]['error'] != UPLOAD_ERR_NO_FILE) {
            $config['upload_path'] = $putanja;
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 1000;
            $config['max_width'] = 2048;
            $config['max_height'] = 1024;
            $config['file_name'] = $imeSlike;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload("$vrstaSlike")) {
                //$message = (string)$this->upload->display_errors();
                return null;
            } else {
                //upload uspesan
                $ekstenzija = $this->upload->data('file_ext');
                return "$imeSlike" ."$ekstenzija";
            }
        } else {
            return null;
        }
    }
    
    public function sacuvajIzmeneProfila() {
        $info['sifra'] = $this->input->post("lozinkagurman");
        //$info['sifraPotvrda'] = $this->input->post("potvrdalozinkegurman");
        $info['ime'] = $this->input->post("imegurman");
        $info['prezime'] = $this->input->post("prezimegurman");
        $info['pol'] = $this->input->post("pol");
        //$info['slika'] = $this->input->post("slikagurman");

        $this->form_validation->set_rules('lozinkagurman', 'Sifra', 'required', array('required' => 'Niste uneli šifru'));
        $this->form_validation->set_rules('potvrdalozinkegurman', 'Potvrda sifre', 'required|matches[lozinkagurman]', array('required' => 'Niste uneli potvrdu šifre', 'matches' => 'Šifre koje ste uneli se ne poklapaju'));
        $this->form_validation->set_rules('imegurman', 'Ime', 'required|trim', array('required' => 'Niste uneli ime.'));
        $this->form_validation->set_rules('prezimegurman', 'Prezime', 'required|trim', array('required' => 'Niste uneli prezime.'));
        $this->form_validation->set_rules('pol', 'Pol', 'required', array('required' => 'Niste odabrali pol'));
        //provera za sliku?
        if ($this->form_validation->run() == FALSE) {
            $this->izmenaProfila();
        } else {
            $korisnik = $this->session->userdata('korisnik');
            $gurman = $this->M_Gurman->dohvatiGurmana($korisnik->id);
            
            if (isset($_FILES['slikagurman']) && $_FILES['slikagurman']['error'] != UPLOAD_ERR_NO_FILE) {
                
                if (file_exists("./uploads/gurman/".$korisnik->id."/profil.png")){
                    unlink("./uploads/gurman/".$korisnik->id."/profil.png");
                    rmdir("./uploads/gurman/".$korisnik->id);
                }
                if (file_exists("./uploads/gurman/".$korisnik->id."/profil.jpg")){
                    unlink("./uploads/gurman/".$korisnik->id."/profil.jpg");
                    rmdir("./uploads/gurman/".$korisnik->id);
                }
                if (file_exists("./uploads/gurman/".$korisnik->id."/profil.gif")){
                    unlink("./uploads/gurman/".$korisnik->id."/profil.gif");
                    rmdir("./uploads/gurman/".$korisnik->id);
                }
                
                $putanjaDoFoldera = "./uploads/gurman/".$korisnik->id;
                if (($nazivSlike = $this->upload($putanjaDoFoldera, "profil", "slikagurman")) == null) {
                    $this->izmenaProfila("Greška pri otpremanju slike. Slika mora da zadovoljava sledeće kriterijume: <br /> "
                            . "Podržani formati: gif, jpg, png. <br />"
                            . "Maksimalna veličina 1000 bajtova. <br />"
                            . "Maksimalna rezolucija 2048x1024px.");
                    return;
                } else {
                    if ($gurman->IdSlika == 1){
                        //ako je do sada bila genericka slika
                        //treba da se napravi nova slika
                        $poslednjaSlika = $this->M_Slika->poslednjiId()->poslednjiId;
                        $slikaId = $poslednjaSlika + 1;

                        $slika = new stdClass();
                        $slika->IdSlika = $slikaId;
                        $slika->Putanja = "http://localhost/GurmanGuide/Implementacija/uploads/gurman/" .$korisnik->id ."/" .$nazivSlike;
                        $this->M_Slika->unesiSliku($slika);
                        
                        //i da se apdejtuje Gurman
                        $info['idSlika'] = $slikaId;
                    } else {
                        //ako nije, samo menjamo putanju
                        //mada da li je potrebno ako je ista putanja??
                        $putanja = "http://localhost/GurmanGuide/Implementacija/uploads/gurman/" .$korisnik->id ."/" .$nazivSlike;
                        $this->M_Slika->promeniPutanjuSlike($gurman->IdSlika, $putanja);
                    }
                }
            }
            
            $info['id'] = $korisnik->id;
            $this->M_Gurman->azuriranjeGurmana($info);
            $this->index('Uspesno napravljene izmene.');
        }
    }
    
    function pregledProfilaGurmana($idGurman) {
        $korisnik = $this->session->userdata('korisnik');
        
        if($idGurman == $korisnik->id){
            redirect('C_Gurman/izmenaProfila');
        }
        
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
        
        $this->load->view('sablon/headerGurman.php', ['title' => 'Pregled profila']);
        $this->load->view('stranice/pregledGurmana.php', $info);
        $this->load->view('sablon/footer.php');
    }
    

    function postaviPromeniRecenziju($idJelo, $poruka = null){
        $jelo = $this->M_Jelo->dohvatiJelo($idJelo);
        $restoran = $this->M_Restoran->dohvatiRestoran($jelo->IdKorisnik);
        $korisnik = $this->session->userdata('korisnik');
        $recenzija = $this->M_Recenzija->dohvatiRecenziju($korisnik->id, $jelo->IdJelo);
        
        $ocena = null;
        $komentar = null;
        
        if($recenzija != null){
            $ocena = $recenzija->Ocena;
            $komentar = $recenzija->Komentar;
        }
        
        $info = array(
            'poruka' => $poruka, 
            'idJelo' => $jelo->IdJelo, 
            'nazivJela' => $jelo->Naziv,
            'ocena' => $ocena,
            'komentar' => $komentar,
            'nazivRestorana' => $restoran->imeRestorana
        );
        
        $this->load->view('sablon/headerGurman.php', ['title' => 'Recenzija']);
        $this->load->view('stranice/postavljanjeRecenzije.php', $info);
        $this->load->view('sablon/footer.php');
    }
    
    //ukoliko ne postoji recenzija ulogovanog korisnika za dato jelo pravi novu
    //u suprotnom menja postojecu
    function sacuvajRecenziju($idJelo){
        $korisnik = $this->session->userdata('korisnik');
        $ocena = $this->input->post('rate');
        $komentar = $this->input->post('komentar');
        
        if (isset($ocena) == false || $komentar == ''){
            $poruka = '';
            if (isset($ocena) == false) {$poruka .= 'Niste uneli ocenu. ';}
            if ($komentar == '') {$poruka .= 'Niste ostavili komentar. ';}
            $this->postaviPromeniRecenziju($idJelo, $poruka);
        } else {
            $this->M_Recenzija->napraviIzmeniRecenziju($korisnik->id, $idJelo, $ocena, $komentar);
            $this->index('Uspesno ste ostavili recenziju. Nakon odobrenja ce biti prikazana!');
        }
    }
    
    function prikaziRecenzije(){
        $korisnik = $this->session->userdata('korisnik');
        $info['recenzije'] = $this->M_Recenzija->dohvatiRecenzijeGurmana($korisnik->id);
        
        $this->load->view('sablon/headerGurman.php', ['title' => 'Pregled profila']);
        $this->load->view('stranice/recenzijeGurman.php', $info);
        $this->load->view('sablon/footer.php');
    }
}
