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
        
//        if (($this->session->userdata('korisnik')) != NULL) {
//            switch ($this->session->userdata('korisnik')->tipKorisnika) {
//                case 'gurman':
//                    redirect("C_Gurman");
//                    break;
//                case 'restoran':
//                    redirect("C_Restoran");
//                    break;
//                case 'admin':
//                    redirect("C_Administrator");
//                    break;
//            }
//        }
    }
    
    public function index(){
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
        
        $this->load->view("sablon/headerGost.php", ['title' => 'GurmanGuide']);
        $this->load->view('stranice/main.php', ['jelo' => $klasa]);
        $this->load->view('sablon/footer.php');
    }
    
    public function registrujGurmana($poruka = null) {
        $this->load->view("sablon/headerGost.php", ['title' => 'Registracija']);
        $this->load->view('stranice/registracijaGurmana.php', ['poruka' => $poruka]);
        $this->load->view('sablon/footer.php');
    }
    
    public function registrujRestoran() {
        $gradovi = $this->M_Grad->gohvatiSveGradove();
        $this->load->view("sablon/headerGost.php", ['title' => 'Registracija']);
        $this->load->view('stranice/registracijaRestorana.php', ['gradovi' => $gradovi]);
        $this->load->view('sablon/footer.php');
    }
    
    public function prijaviSe($poruka = null) {
        $this->load->view("sablon/headerGost.php", ['title' => 'Login']);
        $this->load->view('stranice/login.php', ['poruka' => $poruka]);
        $this->load->view('sablon/footer.php');
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
    
    public function proveraRegistracijeGurman() {
        $korime = $this->input->post("korimegurman");
        $sifra = $this->input->post("lozinkagurman");
        $sifraPotvrda = $this->input->post("potvrdalozinkegurman");
        $email = $this->input->post("email");
        $ime = $this->input->post("imegurman");
        $prezime = $this->input->post("prezimegurman");
        $pol = $this->input->post("pol");
        
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
                if (($nazivSlike = $this->upload($putanjaDoFoldera, "profil", "slikagurman")) == null) {
                    $this->registrujGurmana("Greška pri otpremanju slike. Slika mora da zadovoljava sledeće kriterijume: <br /> "
                            . "Podržani formati: gif, jpg, png. <br />"
                            . "Maksimalna veličina 1000 bajtova. <br />"
                            . "Maksimalna rezolucija 2048x1024px.");
                    return;
                } else {
                   
                    $poslednjaSlika = $this->M_Slika->poslednjiId()->poslednjiId;
                    $slikaId = $poslednjaSlika + 1;
                    
                    $slika = new stdClass();
                    $slika->IdSlika = $slikaId;
                    $slika->Putanja = "http://localhost/GurmanGuide/Implementacija/uploads/gurman/" .$id ."/" .$nazivSlike;
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
            
            $this->prijaviSe("Uspešno ste se registrovali. Možete se prijaviti.");
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
    
    //vrsta slike moze biti:
    //      slikagurman
    //      slikarestoran
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
    
    public function proveraRegistracijeRestoran() {
        $korime = $this->input->post("korimerestoran");
        $sifra = $this->input->post("lozinkarestoran");
        $sifraPotvrda = $this->input->post("potvrdalozinkerestoran");
        $email = $this->input->post("email");
        $telefon = $this->input->post("telefon");
        $naziv = $this->input->post("nazivrestorana");
        $radnoVreme = $this->input->post("radnovreme");
        $adresa = $this->input->post("adresarestorana");
        $idGrad = $this->input->post("grad");
        
        $this->form_validation->set_rules('korimerestoran', 'Korisnicno ime', 'required|trim|is_unique[korisnik.KorisnickoIme]', array('required' => 'Niste uneli korisničko ime', 'is_unique' => 'Korisničko ime već postoji'));
        $this->form_validation->set_rules('lozinkarestoran', 'Sifra', 'required', array('required' => 'Niste uneli šifru'));
        $this->form_validation->set_rules('potvrdalozinkerestoran', 'Potvrda sifre', 'required|matches[lozinkarestoran]', array('required' => 'Niste uneli potvrdu šifre', 'matches' =>'Šifre koje ste uneli se ne poklapaju'));
        $this->form_validation->set_rules('email', 'Mejl', 'trim|required|is_unique[korisnik.Email]|callback_regex_check', array('required' => 'Niste uneli mejl', 'is_unique' => 'Mejl već koristi drugi korisnik'));
        $this->form_validation->set_rules('telefon', 'Telefon', 'required|trim', array('required' => 'Niste uneli broj telefona'));
        $this->form_validation->set_rules('nazivrestorana', 'Naziv', 'required|trim', array('required' => 'Niste uneli naziv restorana'));
        $this->form_validation->set_rules('radnovreme', 'Radno Vreme', 'required', array('required' => 'Niste uneli radno vreme'));
        $this->form_validation->set_rules('adresarestorana', 'Adresa', 'required', array('required' => 'Niste uneli adresu'));
        //$this->form_validation->set_rules('gradrestorana', 'Grad', 'required', array('required' => 'Niste uneli grad'));
        
        if ($this->form_validation->run() == FALSE) {
            $this->registrujRestoran();
        } else {
            $poslednjiId = $this->M_Restoran->poslednjiId()->poslednjiId;
            $id = $poslednjiId + 1;

            //pravimo restoranu njegov direktorijum
            if (!file_exists("./uploads/restoran/" ."$id")) {
                  mkdir("./uploads/restoran/" ."$id", 0777, true);
            }
            
            //ako je uploadovana slika
            if (isset($_FILES['slikarestoran']) && $_FILES['slikarestoran']['error'] != UPLOAD_ERR_NO_FILE) {
                
                $putanjaDoFoldera = "./uploads/restoran/" ."$id";
                if (($nazivSlike = $this->upload($putanjaDoFoldera, "profil", "slikarestoran")) == null) {
                    $this->registrujRestoran("Greška pri otpremanju slike. Slika mora da zadovoljava sledeće kriterijume: <br /> "
                            . "Podržani formati: gif, jpg, png. <br />"
                            . "Maksimalna veličina 1000 bajtova. <br />"
                            . "Maksimalna rezolucija 2048x1024px.");
                    return;
                } else {
                   
                    $poslednjaSlika = $this->M_Slika->poslednjiId()->poslednjiId;
                    $slikaId = $poslednjaSlika + 1;
                    
                    $slika = new stdClass();
                    $slika->IdSlika = $slikaId;
                    $slika->Putanja = "http://localhost/GurmanGuide/Implementacija/uploads/restoran/" .$id ."/" .$nazivSlike;
                    $this->M_Slika->unesiSliku($slika);
                }
            }
            
            $restoran = new stdClass();
            $restoran->IdKorisnik = $id;
            $restoran->KorisnickoIme = $korime;
            $restoran->Lozinka = $sifra;
            $restoran->Email = $email;
            $restoran->Telefon = $telefon;
            $restoran->Naziv = $naziv;
            $restoran->Adresa = $adresa;
            $restoran->IdGrad = $idGrad;
            
            if (isset($slikaId)) {
                $restoran->IdSlika = $slikaId;
            } else {
                $restoran->IdSlika = 2; //genericka slika za restoran
            }
            
            $restoran->RadnoVreme = $radnoVreme;
            $restoran->Pregledano = 'N';

            $this->M_Restoran->unesiRestoran($restoran);
            
            $this->prijaviSe("Uspešno ste se registrovali. Možete se prijaviti.");
        }        
    }
    
    public function pretragaJelaPoNazivu($val) {
        $input = str_replace('%20', ' ', $val);
        $input = trim($input);
        $jela = $this->M_Jelo->dohvatiJelaPoNazivu($input);
        
        $niz = [];
        
        foreach ($jela as $jelo) {
            $klasa = new stdClass();
            $klasa->IdJelo = $jelo->IdJelo;
            $klasa->IdRestoran = $jelo->IdKorisnik;
            if ($jelo->Opis != null) {
                $klasa->Opis = $jelo->Opis;
            }else {
                $klasa->Opis = "Trenutno ne postoji opis.";
            }
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
            
            if ($sastojciString != "") {
                $klasa->Sastojci = $sastojciString;
            } else {
            $klasa->Sastojci = "Sastojci trenutno nisu poznati.";
            }
            
            $niz [] = $klasa;
        }
        
        $korisnik = $this->session->userdata('korisnik');
        if ($korisnik == null || $korisnik->tipKorisnika == 'gost') {
            $this->load->view('sablon/headerGost.php', ['title' => 'Rezultat pretrage']);
        } else if ($korisnik->tipKorisnika == 'gurman'){
            $this->load->view('sablon/headerGurman.php', ['title' => 'Rezultat pretrage']);
        } else if ($korisnik->tipKorisnika == 'restoran'){
            $this->load->view('sablon/headerRestoran.php', ['title' => 'Rezultat pretrage']);
        } else if ($korisnik->tipKorisnika == 'admin'){
            $this->load->view('sablon/headerAdmin.php', ['title' => 'Rezultat pretrage']);
        }
        $this->load->view("stranice/rezultatPretrage.php", ['jela' => $niz]);
        $this->load->view('sablon/footer.php');
    }
    
    function pretragaJelaPoSastojku($val) {
        $input = str_replace('%20', ' ', $val);
        $input = trim($input);
        $jela = $this->M_Sastojak->dohvatiJelaZaSastojak($input);
        
        $niz = [];
        
        foreach ($jela as $jelo) {
            $klasa = new stdClass();
            $klasa->IdJelo = $jelo->IdJelo;
            $klasa->IdRestoran = $jelo->IdKorisnik;
            if ($jelo->Opis != null) {
                $klasa->Opis = $jelo->Opis;
            }else {
                $klasa->Opis = "Trenutno ne postoji opis.";
            }
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
            
            if ($sastojciString != "") {
                $klasa->Sastojci = $sastojciString;
            } else {
                $klasa->Sastojci = "Sastojci trenutno nisu poznati.";
            }
            
            $niz [] = $klasa;
        }
        
        $korisnik = $this->session->userdata('korisnik');
        if ($korisnik == null || $korisnik->tipKorisnika == 'gost') {
            $this->load->view('sablon/headerGost.php', ['title' => 'Rezultat pretrage']);
        } else if ($korisnik->tipKorisnika == 'gurman'){
            $this->load->view('sablon/headerGurman.php', ['title' => 'Rezultat pretrage']);
        } else if ($korisnik->tipKorisnika == 'restoran'){
            $this->load->view('sablon/headerRestoran.php', ['title' => 'Rezultat pretrage']);
        } else if ($korisnik->tipKorisnika == 'admin'){
            $this->load->view('sablon/headerAdmin.php', ['title' => 'Rezultat pretrage']);
        }
        $this->load->view("stranice/rezultatPretrage.php", ['jela' => $niz]);
        $this->load->view('sablon/footer.php');
    }
    
    function pretragaJelaPoRestoranu($val) {
        $input = str_replace('%20', ' ', $val);
        $input = trim($input);
        
        $jela = $this->M_Restoran->dohvatiJelaRestorana($input);
        
        $niz = [];
        
        foreach ($jela as $jelo) {
            $klasa = new stdClass();
            $klasa->IdJelo = $jelo->IdJelo;
            $klasa->IdRestoran = $jelo->IdKorisnik;
            if ($jelo->Opis != null) {
                $klasa->Opis = $jelo->Opis;
            }else {
                $klasa->Opis = "Trenutno ne postoji opis.";
            }
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
            
           if ($sastojciString != "") {
                $klasa->Sastojci = $sastojciString;
            } else {
                $klasa->Sastojci = "Sastojci trenutno nisu poznati.";
            }
            
            $niz [] = $klasa;
        }
        
        $korisnik = $this->session->userdata('korisnik');
        if ($korisnik == null || $korisnik->tipKorisnika == 'gost') {
            $this->load->view('sablon/headerGost.php', ['title' => 'Rezultat pretrage']);
        } else if ($korisnik->tipKorisnika == 'gurman'){
            $this->load->view('sablon/headerGurman.php', ['title' => 'Rezultat pretrage']);
        } else if ($korisnik->tipKorisnika == 'restoran'){
            $this->load->view('sablon/headerRestoran.php', ['title' => 'Rezultat pretrage']);
        } else if ($korisnik->tipKorisnika == 'admin'){
            $this->load->view('sablon/headerAdmin.php', ['title' => 'Rezultat pretrage']);
        }
        $this->load->view("stranice/rezultatPretrage.php", ['jela' => $niz]);
        $this->load->view('sablon/footer.php');
    }
    
    function pretragaRestoranaPoNazivu($val) {
        $input = str_replace('%20', ' ', $val);
        $input = trim($input);
        
        $restorani = $this->M_Restoran->dohvatiRestoranePoNazivu($input);
        
        $niz = [];
        
        foreach ($restorani as $restoran) {
            $klasa = new stdClass();
            $klasa->IdKorisnik = $restoran->IdKorisnik;
            $klasa->Telefon = $restoran->Telefon;
            $klasa->Adresa = $restoran->Adresa;
            $klasa->RadnoVreme = $restoran->RadnoVreme;
            $klasa->Naziv = $restoran->Naziv;
            $klasa->Putanja = $this->M_Slika->dohvatiPutanju($restoran->IdSlika)->Putanja;
            $klasa->IdGrad = $restoran->IdGrad;
            $klasa->Grad = $this->M_Grad->dohvatiNazivGrada($restoran->IdGrad)->Naziv;
            
            $jelaRestorana = $this->M_Restoran->dohvatiJelaRestoranaId($restoran->IdKorisnik);
            
            $najboljaOcena = "-1";
            $najboljeJelo = null;
            foreach ($jelaRestorana as $jelo) {
                if ($najboljaOcena < ($tempOcena = $this->M_Recenzija->ocenaJela($jelo->IdJelo))) {
                    $najboljeJelo = $jelo;
                    $najboljaOcena = $tempOcena;
                }
            }
            
            if ($najboljeJelo != null) {
                $klasa->topJeloNaziv = $najboljeJelo->Naziv;
                $klasa->topJeloId = $najboljeJelo->IdJelo;
            } else {
                $klasa->topJeloNaziv = "Restoran nema jela";
                $klasa->topJeloId = -1;
            }
            
            $niz [] = $klasa;
        }
        
        $korisnik = $this->session->userdata('korisnik');
        if ($korisnik == null || $korisnik->tipKorisnika == 'gost') {
            $this->load->view('sablon/headerGost.php', ['title' => 'Rezultat pretrage']);
        } else if ($korisnik->tipKorisnika == 'gurman'){
            $this->load->view('sablon/headerGurman.php', ['title' => 'Rezultat pretrage']);
        } else if ($korisnik->tipKorisnika == 'restoran'){
            $this->load->view('sablon/headerRestoran.php', ['title' => 'Rezultat pretrage']);
        } else if ($korisnik->tipKorisnika == 'admin'){
            $this->load->view('sablon/headerAdmin.php', ['title' => 'Rezultat pretrage']);
        }
        $this->load->view("stranice/rezultatPretrageRestoran.php", ['restorani' => $niz]);
        $this->load->view('sablon/footer.php');
    }
    
    public function pretragaRestoranaPoAdresi($val) {
        $input = str_replace('%20', ' ', $val);
        $input = trim($input);
        
        $restorani = $this->M_Restoran->dohvatiRestoranePoAdresi($input);
        
        $niz = [];
        
        foreach ($restorani as $restoran) {
            $klasa = new stdClass();
            $klasa->IdKorisnik = $restoran->IdKorisnik;
            $klasa->Telefon = $restoran->Telefon;
            $klasa->Adresa = $restoran->Adresa;
            $klasa->RadnoVreme = $restoran->RadnoVreme;
            $klasa->Naziv = $restoran->Naziv;
            $klasa->Putanja = $this->M_Slika->dohvatiPutanju($restoran->IdSlika)->Putanja;
            $klasa->IdGrad = $restoran->IdGrad;
            $klasa->Grad = $this->M_Grad->dohvatiNazivGrada($restoran->IdGrad)->Naziv;
            
            $jelaRestorana = $this->M_Restoran->dohvatiJelaRestoranaId($restoran->IdKorisnik);
            
            $najboljaOcena = "-1";
            $najboljeJelo = null;
            foreach ($jelaRestorana as $jelo) {
                if ($najboljaOcena < ($tempOcena = $this->M_Recenzija->ocenaJela($jelo->IdJelo))) {
                    $najboljeJelo = $jelo;
                    $najboljaOcena = $tempOcena;
                }
            }
            
            if ($najboljeJelo != null) {
                $klasa->topJeloNaziv = $najboljeJelo->Naziv;
                $klasa->topJeloId = $najboljeJelo->IdJelo;
            } else {
                $klasa->topJeloNaziv = "Restoran nema jela";
                $klasa->topJeloId = -1;
            }
            
            $niz [] = $klasa;
        }
        
        $korisnik = $this->session->userdata('korisnik');
        if ($korisnik == null || $korisnik->tipKorisnika == 'gost') {
            $this->load->view('sablon/headerGost.php', ['title' => 'Rezultat pretrage']);
        } else if ($korisnik->tipKorisnika == 'gurman'){
            $this->load->view('sablon/headerGurman.php', ['title' => 'Rezultat pretrage']);
        } else if ($korisnik->tipKorisnika == 'restoran'){
            $this->load->view('sablon/headerRestoran.php', ['title' => 'Rezultat pretrage']);
        } else if ($korisnik->tipKorisnika == 'admin'){
            $this->load->view('sablon/headerAdmin.php', ['title' => 'Rezultat pretrage']);
        }
        $this->load->view("stranice/rezultatPretrageRestoran.php", ['restorani' => $niz]);
        $this->load->view('sablon/footer.php');
    }
    
    public function prikaziJelo($id) {
        $jelo = $this->M_Jelo->dohvatiJelo($id);
        
        $klasa = new stdClass();
        $klasa->Naziv = $jelo->Naziv;
        $klasa->Putanja = $this->M_Slika->dohvatiPutanju($jelo->IdSlika)->Putanja;
        
        $sastojci = $this->M_Sastojak->dohvatiSastojkeJela($jelo->IdJelo);
            
        $sastojciString = "";

        for ($i = 0; $i < count($sastojci); $i++) {
            $sastojciString .= $sastojci[$i]->Naziv;

            if ($i != (count($sastojci) - 1)) {
                $sastojciString .= ", ";
            }

        }
        if ($sastojciString != "") {
            $klasa->Sastojci = $sastojciString;
        } else {
            $klasa->Sastojci = "Sastojci trenutno nisu poznati.";
        }
        
        //Zaokruzivanje na jednu decimalu
        $klasa->Ocena = round($this->M_Recenzija->ocenaJela($jelo->IdJelo)->ocena, 1);
        if ($jelo->Opis != null) {
            $klasa->Opis = $jelo->Opis;
        }else {
            $klasa->Opis = "Trenutno ne postoji opis.";
        }
        $klasa->IdRestoran = $jelo->IdKorisnik;
        $klasa->imeRestorana = $this->M_Restoran->dohvatiRestoran($jelo->IdKorisnik)->imeRestorana;
        
        //recenzije
        $recenzije = $this->M_Recenzija->dohvatiRecenzijeJela($jelo->IdJelo);
        
        $niz = [];
        
        foreach ($recenzije as $recenzija) {
            $objekat = new stdClass();
            $objekat->Komentar = $recenzija->Komentar;
            $gurman = $this->M_Gurman->dohvatiGurmana($recenzija->IdKorisnik);
            $slikaGurmanaId = $gurman->IdSlika;
            $objekat->Slika = $this->M_Slika->dohvatiPutanju($slikaGurmanaId)->Putanja;
            $objekat->kIme = $gurman->KorisnickoIme;
            $objekat->idK = $gurman->IdKorisnik;
            $objekat->Ocena = $recenzija->Ocena;
            
            $niz [] = $objekat;
        }
        
        
        $korisnik = $this->session->userdata('korisnik');
        if ($korisnik == null || $korisnik->tipKorisnika == 'gost') {
            $this->load->view('sablon/headerGost.php', ['title' => $klasa->Naziv]);
        } else if ($korisnik->tipKorisnika == 'gurman'){
            $this->load->view('sablon/headerGurman.php', ['title' => $klasa->Naziv]);
        } else if ($korisnik->tipKorisnika == 'restoran'){
            $this->load->view('sablon/headerRestoran.php', ['title' => $klasa->Naziv]);
        } else if ($korisnik->tipKorisnika == 'admin'){
            $this->load->view('sablon/headerAdmin.php', ['title' => $klasa->Naziv]);
        }
        $this->load->view("stranice/prikazJela.php", ['jelo' => $klasa, 'recenzije' => $niz]);
        $this->load->view('sablon/footer.php');
    }
    
    public function kontakt(){
        //proveriti ko je ulogovan i uraditi redirekt
        $korisnik = $this->session->userdata('korisnik');
        if ($korisnik == null || $korisnik->tipKorisnika == 'gost') {
            $this->load->view('sablon/headerGost.php', ['title' => 'Kontakt']);
        } else if ($korisnik->tipKorisnika == 'gurman'){
            $this->load->view('sablon/headerGurman.php', ['title' => 'Kontakt']);
        } else if ($korisnik->tipKorisnika == 'restoran'){
            $this->load->view('sablon/headerRestoran.php', ['title' => 'Kontakt']);
        } else if ($korisnik->tipKorisnika == 'admin'){
            $this->load->view('sablon/headerAdmin.php', ['title' => 'Kontakt']);
        }
        $this->load->view('stranice/kontakt.php');
        $this->load->view('sablon/footer.php');
    }
    
    public function onama(){
        //proveriti ko je ulogovan i uraditi redirekt
        $korisnik = $this->session->userdata('korisnik');
        if ($korisnik == null || $korisnik->tipKorisnika == 'gost') {
            $this->load->view('sablon/headerGost.php', ['title' => 'O nama']);
        } else if ($korisnik->tipKorisnika == 'gurman'){
            $this->load->view('sablon/headerGurman.php', ['title' => 'O nama']);
        } else if ($korisnik->tipKorisnika == 'restoran'){
            $this->load->view('sablon/headerRestoran.php', ['title' => 'O nama']);
        } else if ($korisnik->tipKorisnika == 'admin'){
            $this->load->view('sablon/headerAdmin.php', ['title' => 'O nama']);
        }
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
        
        
        $korisnik = $this->session->userdata('korisnik');
        if($idGurman == $korisnik->id){
            redirect('C_Gurman/izmenaProfila');
        }
        if ($korisnik == null || $korisnik->tipKorisnika == 'gost') {
            $this->load->view('sablon/headerGost.php', ['title' => 'Pregled profila']);
        } else if ($korisnik->tipKorisnika == 'gurman'){
            $this->load->view('sablon/headerGurman.php', ['title' => 'Pregled profila']);
        } else if ($korisnik->tipKorisnika == 'restoran'){
            $this->load->view('sablon/headerRestoran.php', ['title' => 'Pregled profila']);
        } else if ($korisnik->tipKorisnika == 'admin'){
            $this->load->view('sablon/headerAdmin.php', ['title' => 'Pregled profila']);
        }
        $this->load->view('stranice/pregledGurmana.php', $info);
        $this->load->view('sablon/footer.php');
    }
}