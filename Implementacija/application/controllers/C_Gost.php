<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of C_Gost
 *
 * @author Nenad
 */
class C_Gost extends CI_Controller{
    public function __construct() {
        parent::__construct();
        
        if (($this->session->userdata('korisnik')) != NULL) {
            switch ($this->session->userdata('korisnik')->tipKorisnika) {
                case 'gurman':
                    redirect("C_Gurman");
                    break;
                case 'restoran':
                    redirect("C_Restoran");
                    break;
                case 'admin':
                    redirect("C_Administrator");
                    break;
            }
        }
        
        $this->load->model("M_Gurman");
        $this->load->model("M_Restoran");
        $this->load->model("M_Administrator");
        $this->load->model("M_Slika");
    }
    
    public function index(){
        $this->load->view("sablon/headerGost.php", ['title' => 'GurmanGuide']);
        $this->load->view('stranice/main.php');
    }
    
    public function registrujGurmana($poruka = null, $informacije = null) {
        $this->load->view("sablon/headerGost.php", ['title' => 'Registracija']);
        $this->load->view('stranice/registracijaGurmana.php', ['poruka' => $poruka, 'informacije' => $informacije]);
    }
    
    public function registrujRestoran() {
        $this->load->view("sablon/headerGost.php", ['title' => 'Registracija']);
        $this->load->view('stranice/registracijaRestorana.php');
    }
    
    public function prijaviSe($poruka = null) {
        $this->load->view("sablon/headerGost.php", ['title' => 'Login']);
        $this->load->view('stranice/login.php', ['poruka' => $poruka]);
    }
    
    public function proveraPrijave() {
        $korime = $this->input->post("korimegurman");
        $sifra = $this->input->post("lozinkagurman");
        
        $this->form_validation->set_rules('korimegurman', 'Korisnicno ime', 'required');
        $this->form_validation->set_rules('lozinkagurman', 'Sifra', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $this->prijaviSe("Niste popunili oba polja!");
        } else {
            
            $informacijeOKornisniku = null;
            //provera da li je gurman
            if ($this->M_Gurman->proveraKorImena($korime) != null) {
                if (($informacijeOKornisniku = $this->M_Gurman->proveraSifre($korime, $sifra)) != null) {
                    $korisnik = new stdClass();
                    $korisnik->id = $informacijeOKornisniku->IdKorisnik;
                    $korisnik->korisnickoIme = $informacijeOKornisniku->KorisnickoIme;
                    $korisnik->ime = $informacijeOKornisniku->Ime;
                    $korisnik->prezime = $informacijeOKornisniku->Prezime;
                    $korisnik->idSlika = $informacijeOKornisniku->IdSlika;
                    $korisnik->tipKorisnika = 'gurman';
                    $this->session->set_userdata('korisnik', $korisnik);
                    redirect("C_Gurman");
                } else {
                    $this->prijaviSe("Šifra ne odgovara korisničkom imenu!");
                }
                
            } else {
                //provera da li je restoran
                if ($this->M_Restoran->proveraKorImena($korime) != null) {
                    if (($informacijeOKornisniku = $this->M_Restoran->proveraSifre($korime, $sifra)) != null) {
                        $korisnik = new stdClass();
                        $korisnik->id = $informacijeOKornisniku->IdKorisnik;
                        $korisnik->korisnickoIme = $informacijeOKornisniku->KorisnickoIme;
                        $korisnik->naziv = $informacijeOKornisniku->Naziv;
                        $korisnik->telefon = $informacijeOKornisniku->Telefon;
                        $korisnik->idSlika = $informacijeOKornisniku->IdSlika;
                        $korisnik->idGrad = $informacijeOKornisniku->IdGrad;
                        $korisnik->adresa = $informacijeOKornisniku->Adresa;
                        $korisnik->radnoVreme = $informacijeOKornisniku->RadnoVreme;
                        $korisnik->tipKorisnika = 'restoran';
                        $this->session->set_userdata('korisnik', $korisnik);
                        redirect("C_Restoran");
                    } else {
                        $this->prijaviSe("Šifra ne odgovara korisničkom imenu!");
                    }   
                } else {
                    //provera da li je admin
                    if ($this->M_Administrator->proveraKorImena($korime) != null) {
                        if (($informacijeOKornisniku = $this->M_Administrator->proveraSifre($korime, $sifra)) != null) {
                            $korisnik = new stdClass();
                            $korisnik->id = $informacijeOKornisniku->IdKorisnik;
                            $korisnik->korisnickoIme = $informacijeOKornisniku->KorisnickoIme;
                            $korisnik->tipKorisnika = 'admin';
                            $this->session->set_userdata('korisnik', $korisnik);
                            redirect("C_Administrator");
                        }
                        else {
                            $this->prijaviSe("Šifra ne odgovara korisničkom imenu!");
                        }
                    } else {
                        $this->prijaviSe("Ne postoji korisnik sa korisničnim imenom " .$korime ."!");
                    }
                }
            }
        }
    }
    
    public function proveraRegistracije() {
        $korime = $this->input->post("korimegurman");
        $sifra = $this->input->post("lozinkagurman");
        $sifraPotvrda = $this->input->post("potvrdalozinkegurman");
        $email = $this->input->post("email");
        $ime = $this->input->post("imegurman");
        $prezime = $this->input->post("prezimegurman");
        $pol = $this->input->post("pol");
        $slika = $this->input->post("slikagurman");
        
        $this->load->helper('email');
        $this->form_validation->set_rules('korimegurman', 'Korisnicno ime', 'required|trim|is_unique[korisnik.KorisnickoIme]', array('required' => 'Niste uneli korisničko ime', 'is_unique' => 'Korisničko ime već postoji'));
        $this->form_validation->set_rules('lozinkagurman', 'Sifra', 'required', array('required' => 'Niste uneli šifru'));
        $this->form_validation->set_rules('potvrdalozinkegurman', 'Potvrda sifre', 'required|matches[lozinkagurman]', array('required' => 'Niste uneli potvrdu šifre', 'matches' =>'Šifre koje ste uneli se ne poklapaju'));
        $this->form_validation->set_rules('email', 'Mejl', 'trim|required|is_unique[korisnik.Email]|callback_regex_check', array('required' => 'Niste uneli mejl', 'is_unique' => 'Mejl već koristi drugi korisnik'));
        $this->form_validation->set_rules('imegurman', 'Ime', 'required|trim', array('required' => 'Niste uneli ime'));
        $this->form_validation->set_rules('prezimegurman', 'Prezime', 'required|trim', array('required' => 'Niste uneli prezime'));
        $this->form_validation->set_rules('pol', 'Pol', 'required', array('required' => 'Niste odabrali pol'));
        //$this->form_validation->set_rules('slikagurman', 'Slika', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->registrujGurmana();
        } else {
            
            $poslednjiId = $this->M_Gurman->poslednjiId()->poslednjiId;
            $id = $poslednjiId + 1;

            //pravimo gurmanu njegov direktorijum
            if (!file_exists("./uploads/gurman/" ."$id")) {
                  mkdir("./uploads/gurman/" ."$id", 0777, true);
            }
            
            //ako je uploadovana slika
            if (isset($_FILES['slikagurman']) && $_FILES['slikagurman']['error'] != UPLOAD_ERR_NO_FILE) {
                
                $putanjaDoFoldera = "./uploads/gurman/" ."$id";
                if (($putanjaDoSlike = $this->upload($putanjaDoFoldera, "profil")) == null) {
                    $this->registrujGurmana("Greška pri otpremanju slike. Slika mora da zadovoljava sledeće kriterijume: <br /> "
                            . "Podržani formati: gif, jpg, png. <br />"
                            . "Maksimalna veličina 1000 bajtova. <br />"
                            . "Maksimalna rezolucija 2048x1024px.");
                } {
                   
                    $poslednjaSlika = $this->M_Slika->poslednjiId()->poslednjiId;
                    $slikaId = $poslednjaSlika + 1;
                    
                    $slika = new stdClass();
                    $slika->IdSlika = $slikaId;
                    $slika->Putanja = $putanjaDoSlike;
                    $this->M_Slika->unesiSliku($slika);
                }
            }
            
            $gurman = new stdClass();
            $gurman->IdKorisnik = $id;
            $gurman->KorisnickoIme = $korime;
            $gurman->Lozinka = $sifra;
            $gurman->Email = $email;
            $gurman->Ime = $ime;
            $gurman->Prezime = $prezime;
            $gurman->Pol = $pol;
            
            if (isset($slikaId)) {
                $gurman->IdSlika = $slikaId;
            } else {
                $gurman->IdSlika = 1; //genericka slika za gurmana
            }

            $this->M_Gurman->unesiGurmana($gurman);
        }        
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
    
    public function upload($putanja, $imeSlike) {
        if(!file_exists($putanja)) {
           mkdir($putanja, 0777, true);
        }
        if (isset($_FILES['slikagurman']) && $_FILES['slikagurman']['error'] != UPLOAD_ERR_NO_FILE) {
            $config['upload_path'] = $putanja;
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 1000;
            $config['max_width'] = 2048;
            $config['max_height'] = 1024;
            $config['file_name'] = $imeSlike;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('slikagurman')) {
                //$message = (string)$this->upload->display_errors();
                return null;
            } else {
                //upload uspesan
                $ekstenzija = $this->upload->data('file_ext');
                return $putanja ."/" ."$imeSlike" ."$ekstenzija";
            }
        } else {
            return null;
        }
    }
    
}