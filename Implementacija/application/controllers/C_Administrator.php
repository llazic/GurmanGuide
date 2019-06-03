<?php

include_once('C_Zajednicki.php');

/**
 * Kontroler za Administratora
 *
 * @author Nikola Bozovic 0439/2016
 * @version 1.0
 */
 
 
class C_Administrator extends C_Zajednicki {

    /**
     * Kreiranje nove instance
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct();

        $korisnik = $this->session->userdata('korisnik');

        if ($korisnik == null) {
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

    /**
     * Pocetna stranica
     * 
     * @param string $poruka 
     * 
     * @return void
     */
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

        $this->load->view('sablon/headerAdmin.php', ['title' => 'Pretraga']);
        $this->load->view('stranice/main.php', ['poruka' => $poruka, 'jelo' => $klasa]);
        $this->load->view('sablon/footer.php');
    }

    /**
     * Prikaz stranice za upravljanje dodatim jelima
     * 
     * @return void
     */
    public function upravljanjeJelima() {
        $jela = $this->M_Jelo->dohvatiNepregledanaJela();
        $sastojci = NULL;
        $rest = NULL;
        if ($jela != NULL) {
            foreach ($jela as $jelo) {
                $sastojci[$jelo->IdJelo] = $this->M_Sastojak->dohvatiSastojkeJela($jelo->IdJelo);
                $rest[$jelo->IdJelo] = $this->M_Restoran->dohvatiIme($jelo->IdKorisnik);
            }
        }
        $this->load->view('sablon/headerAdmin.php', ['title' => 'Upravljanje Jelima']);
        $this->load->view('stranice/upravljanjeJelima.php', ['jela' => $jela, 'sastojci' => $sastojci, 'restoran' => $rest]);
        $this->load->view('sablon/footer.php');
    }

    /** Prikaz stranice za upravljanje dodatim recenzijama
     * 
     * @return void
     */
    public function upravljanjeRecenzijama() {
        $recenzije = $this->M_Recenzija->dohvatiNepregledaneRecenzije();
        $this->load->view('sablon/headerAdmin.php', ['title' => 'Upravljanje Recenzijama']);
        $this->load->view('stranice/upravljanjeRecenzijama.php', ['recenzije' => $recenzije]);
        $this->load->view('sablon/footer.php');
    }

    /** Prikaz stranice za upravljanje novim  registaracijama
     * 
     * @return void
     */
    public function upravljanjeRegistracijama() {
        $registracije = $this->M_Restoran->dohvatiNepregledaneRegistracije();
        $this->load->view('sablon/headerAdmin.php', ['title' => 'Upravljanje Registracijama']);
        $this->load->view('stranice/upravljanjeRegistracijama.php', ['registracije' => $registracije]);
        $this->load->view('sablon/footer.php');
    }

    /** Obrada pregledanog jela
     * 
     * @return void
     */
    public function pregledanoJelo() {
        $id = $this->input->get('id');
        $this->M_Jelo->postaviPregledano($id);
        $this->upravljanjeJelima();
    }

    /** Brisanje pregledanog jela
     * 
     * @return void
     */
    public function obrisiJelo() {
        $id = $this->input->get('id');
        $this->M_Jelo->obrisiJelo($id);
        $this->upravljanjeJelima();
    }

    /** Obrada pregledane recenzije
     * 
     * @return void
     */
    public function pregledanaRecenzija() {
        $idk = $this->input->get('idk');
        $idj = $this->input->get('idj');
        $this->M_Recenzija->postaviPregledano($idk, $idj);
        $this->upravljanjeRecenzijama();
    }

    /** Brisanje pregledane recenzije
     * 
     * @return void
     */
    public function obrisiRecenziju() {
        $idk = $this->input->get('idk');
        $idj = $this->input->get('idj');
        $this->M_Recenzija->obrisiRecenziju($idk, $idj);
        $this->upravljanjeRecenzijama();
    }

    /** Obrada pregledane registracije
     * 
     * @return void
     */
    public function pregledanaRegistracija() {
        $id = $this->input->get('id');
        $this->M_Restoran->postaviPregledano($id);
        $this->upravljanjeRegistracijama();
    }

    /** Brisanje pregledane registracije
     * 
     * @return void
     */
    public function obrisiRegistraciju() {
        $id = $this->input->get('id');
        $this->M_Restoran->obrisiRegistraciju($id);
        $this->upravljanjeRegistracijama();
    }

    /**
     * Sluzi da se Administrator izloguje
     * 
     * @return void
     */
    public function izlogujSe() {
        $korisnik = new stdClass();
        $korisnik->tipKorisnika = 'gost';
        $this->session->set_userdata('korisnik', $korisnik);
        redirect('C_Gost');
    }

    /**
     * Funkcija za ispis kontakt informacija
     * 
     * @return void
     */
    public function kontakt() {

        $this->load->view('sablon/headerAdmin.php', ['title' => 'Kontakt']); //ako je gurman ulogovan
        $this->load->view('stranice/kontakt.php');
        $this->load->view('sablon/footer.php');
    }

    /**
     * Funkcija za ispis informacija o nama
     * 
     * @return void
     */
    public function onama() {

        $this->load->view('sablon/headerAdmin.php', ['title' => 'O nama']); //ako je gurman ulogovan
        $this->load->view('stranice/onama.php');
        $this->load->view('sablon/footer.php');
    }

    /**
     * Prikaz profila Gurmana
     * 
     * @param int $idGurman
     * 
     * @return void
     */
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

    /**
     * Prikaz jela
     * 
     * @param int $id -> idJelo
     * 
     * @return void
     */
    public function prikaziJelo($id) {
        $info = parent::prikaziJelo($id);

        $this->load->view('sablon/headerAdmin.php', ['title' => $info['jelo']->Naziv]);
        $this->load->view("stranice/prikazJela.php", $info);
        $this->load->view('sablon/footer.php');
    }

    /**
     * Prikaz rezultata pretrage jela po nazivu
     * 
     * @param string $val
     * 
     * @return void
     */
    public function pretragaJelaPoNazivu($val) {
        $info = parent::pretragaJelaPoNazivu($val);
        $info['naslov'] = 'Rezultat pretrage';

        $this->load->view('sablon/headerAdmin.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/rezultatPretrage.php", $info);
        $this->load->view('sablon/footer.php');
    }

    /**
     * Prikaz rezultata pretrage jela po sastojku
     * 
     * @param string $val
     * 
     * @return void
     */
    public function pretragaJelaPoSastojku($val) {
        $info = parent::pretragaJelaPoSastojku($val);
        $info['naslov'] = 'Rezultat pretrage';

        $this->load->view('sablon/headerAdmin.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/rezultatPretrage.php", $info);
        $this->load->view('sablon/footer.php');
    }

    /**
     * Prikaz rezultata pretrage jela po restoranu
     * 
     * @param string $val
     * 
     * @return void
     */
    public function pretragaJelaPoRestoranu($val) {
        $info = parent::pretragaJelaPoRestoranu($val);
        $info['naslov'] = 'Rezultat pretrage';

        $this->load->view('sablon/headerAdmin.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/rezultatPretrage.php", $info);
        $this->load->view('sablon/footer.php');
    }

    /**
     * Prikaz rezultata pretrage restorana po nazivu
     * 
     * @param string $val
     * 
     * @return void
     */
    public function pretragaRestoranaPoNazivu($val) {
        $info = parent::pretragaRestoranaPoNazivu($val);
        $info['naslov'] = 'Rezultat pretrage';

        $this->load->view('sablon/headerAdmin.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/rezultatPretrageRestoran.php", $info);
        $this->load->view('sablon/footer.php');
    }

    /**
     * Prikaz rezultata pretrage restorana po adresi
     * 
     * @param string $val
     * 
     * @return void
     */
    public function pretragaRestoranaPoAdresi($val) {
        $info = parent::pretragaRestoranaPoAdresi($val);
        $info['naslov'] = 'Rezultat pretrage';

        $this->load->view('sablon/headerAdmin.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/rezultatPretrageRestoran.php", $info);
        $this->load->view('sablon/footer.php');
    }

    /**
     * Prikaz profila restorana
     * 
     * @param int $idRestorana
     * 
     * @return void
     */
    public function pregledRestorana($idRestorana) {
        $info = parent::pregledRestorana($idRestorana);

        $this->load->view('sablon/headerAdmin.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/pregledRestorana.php", $info);
        $this->load->view('sablon/footer.php');
    }

    /**
     * Prikaz menija restorana
     * 
     * @param int $idRestorana
     * 
     * @return void
     */
    public function prikaziMeniRestorana($idRestorana) {
        $info = parent::prikaziMeniRestorana($idRestorana);

        $this->load->view('sablon/headerAdmin.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/meniRestorana.php", $info);
        $this->load->view('sablon/footer.php');
    }

}
