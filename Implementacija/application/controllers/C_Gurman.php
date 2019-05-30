<?php
include_once('C_Zajednicki.php');
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
class C_Gurman extends C_Zajednicki {

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
            case 'admin': redirect('C_Administrator');
                break;
        }
    }

    public function index($poruka = null) {
        $topJeloId = $this->M_Recenzija->dohvatiTopJelo();
        $recenzija = $this->M_Recenzija->dohvatiTopRecenziju($topJeloId->IdJelo);
        $jelo = $this->M_Jelo->dohvatiJelo($topJeloId->IdJelo);
        
        $klasa = new stdClass();
        $klasa->Putanja = $this->M_Slika->dohvatiPutanju($jelo->IdSlika)->Putanja;
        $klasa->IdJelo = $topJeloId->IdJelo;
        $klasa->Komentar = $recenzija->Komentar;
        $klasa->Ocena = $recenzija->Ocena;
        $klasa->Naziv = $jelo->Naziv;
        $gurman = $this->M_Gurman->dohvatiGurmana($recenzija->IdKorisnik);
        $klasa->kIme = $gurman->KorisnickoIme;
        $klasa->idK = $gurman->IdKorisnik;
        
        $this->load->view('sablon/headerGurman.php', ['title' => 'Pretraga']);
        $this->load->view('stranice/main.php', ['poruka' => $poruka, 'jelo' => $klasa]);
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
                if (($nazivSlike = parent::upload($putanjaDoFoldera, "profil", "slikagurman")) == null) {
                    if ($gurman->IdSlika != 1) {
                        $prosliId = $gurman->IdSlika;
                        $this->M_Gurman->promeniSlikuGurmanu($korisnik->id, 1);
                        $this->M_Slika->obrisiSliku($prosliId);
                    }
                    $this->izmenaProfila("Greška pri otpremanju slike. Slika mora da zadovoljava sledeće kriterijume: <br /> "
                            . "Podržani formati: gif, jpg, png. <br />"
                            . "Maksimalna veličina 1000 kilobajta. <br />"
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
    
    public function pregledProfilaGurmana($idGurman) {
        $korisnik = $this->session->userdata('korisnik');
        
        if($idGurman == $korisnik->id){
            redirect('C_Gurman/izmenaProfila');
        }
        
        $info = parent::pregledProfilaGurmana($idGurman);
        
        $this->load->view('sablon/headerGurman.php', ['title' => 'Pregled profila']);
        $this->load->view('stranice/pregledGurmana.php', $info);
        $this->load->view('sablon/footer.php');
    }
    

    public function postaviPromeniRecenziju($idJelo, $poruka = null){
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
    public function sacuvajRecenziju($idJelo){
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
    
    public function prikaziRecenzije(){
        $korisnik = $this->session->userdata('korisnik');
        $info['recenzije'] = $this->M_Recenzija->dohvatiRecenzijeGurmana($korisnik->id);
        
        $this->load->view('sablon/headerGurman.php', ['title' => 'Pregled profila']);
        $this->load->view('stranice/recenzijeGurman.php', $info);
        $this->load->view('sablon/footer.php');
    }
    
    public function prikaziJelo($id) {
        $info = parent::prikaziJelo($id);
        
        $this->load->view('sablon/headerGurman.php', ['title' => $info['jelo']->Naziv]);
        $this->load->view("stranice/prikazJela.php", $info);
        $this->load->view('sablon/footer.php');
    }
    
    public function pretragaJelaPoNazivu($val) {
        $info = parent::pretragaJelaPoNazivu($val);
        $info['naslov'] = 'Rezultat pretrage';
        
        $this->load->view('sablon/headerGurman.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/rezultatPretrage.php", $info);
        $this->load->view('sablon/footer.php');
    }
    
    public function pretragaJelaPoSastojku($val) {
        $info = parent::pretragaJelaPoSastojku($val);
        $info['naslov'] = 'Rezultat pretrage';
        
        $this->load->view('sablon/headerGurman.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/rezultatPretrage.php", $info);
        $this->load->view('sablon/footer.php');
    }
    
    public function pretragaJelaPoRestoranu($val) {
        $info = parent::pretragaJelaPoRestoranu($val);
        $info['naslov'] = 'Rezultat pretrage';
        
        $this->load->view('sablon/headerGurman.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/rezultatPretrage.php", $info);
        $this->load->view('sablon/footer.php');
    }
    
    public function pretragaRestoranaPoNazivu($val) {
        $info = parent::pretragaRestoranaPoNazivu($val);
        $info['naslov'] = 'Rezultat pretrage';
        
        $this->load->view('sablon/headerGurman.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/rezultatPretrageRestoran.php", $info);
        $this->load->view('sablon/footer.php');
    }
    
    public function pretragaRestoranaPoAdresi($val) {
        $info = parent::pretragaRestoranaPoAdresi($val);
        $info['naslov'] = 'Rezultat pretrage';
        
        $this->load->view('sablon/headerGurman.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/rezultatPretrageRestoran.php", $info);
        $this->load->view('sablon/footer.php');
    }
    
    public function pregledRestorana($idRestorana){
        $info = parent::pregledRestorana($idRestorana);
        
        $this->load->view('sablon/headerGurman.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/pregledRestorana.php", $info);
        $this->load->view('sablon/footer.php');
    }
    
    public function prikaziMeniRestorana($idRestorana) {
        $info = parent::prikaziMeniRestorana($idRestorana);
        
        $this->load->view('sablon/headerGurman.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/meniRestorana.php", $info);
        $this->load->view('sablon/footer.php');
    }
}
