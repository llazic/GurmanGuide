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

    public function index() {
        $this->load->view('sablon/headerGurman.php', ['title' => 'Pretraga']);
        //dodati pretragu kao sredinu
        $this->load->view('sablon/footer.php');
    }

    public function izmenaProfila() {
        $korisnik = $this->session->userdata('korisnik');
        $gurman = $this->M_Gurman->dohvatiGurmana($korisnik->id);
        
        $this->session->set_userdata('korisnik', $gurman);

        $this->load->view('sablon/headerGurman.php', ['title' => 'Moj profil']);
        $this->load->view('stranice/izmenaProfilaGurmana.php');
        $this->load->view('sablon/footer.php');
        $this->session->set_userdata('korisnik', $korisnik);
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
            $info['id'] = $korisnik->id;
            $this->M_Gurman->azuriranjeGurmana($info);
            $this->index();
        }
    }

}
