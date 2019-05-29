<?php
include_once('C_Zajednicki.php');

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
class C_Restoran extends C_Zajednicki {

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
            case 'gurman': redirect('C_Gurman');
                break;
            case 'admin': redirect('C_Admin');
                break;
        }
    }

    public function index($poruka = null) { //u indexu da se ide na land
        $topJeloId = $this->M_Recenzija->dohvatiTopJelo();
        $recenzija = $this->M_Recenzija->dohvatiTopRecenziju($topJeloId->IdJelo);
        $jelo = $this->M_Jelo->dohvatiJelo($topJeloId->IdJelo);

        $klasa = new stdClass();
        $klasa->Putanja = $this->M_Slika->dohvatiPutanju($jelo->IdSlika)->Putanja;
        $klasa->IdJelo = $topJeloId->IdJelo;
        $klasa->Komentar = $recenzija->Komentar;
        $klasa->Ocena = $recenzija->Ocena;
        $klasa->Naziv = $jelo->Naziv;

        $this->load->view("sablon/headerRestoran.php", ['title' => 'GurmanGuide']);
        $this->load->view('stranice/main.php', ['jelo' => $klasa, 'poruka' => $poruka]);
        $this->load->view('sablon/footer.php');
    }

    public function izmenaRestorana($poruka = null) {
        $korisnik = $this->session->userdata('korisnik');
        $restoran = $this->M_Restoran->dohvatiRestoran($korisnik->id);
        $slika = $this->M_Slika->dohvatiPutanju($restoran->IdSlika);

        $info['korime'] = $restoran->korime;
        $info['lozinka'] = $restoran->lozinka;
        $info['email'] = $restoran->email;
        $info['brTelefona'] = $restoran->brTelefona;
        $info['imeRestorana'] = $restoran->imeRestorana;
        $info['radnoVreme'] = $restoran->radnoVreme;
        $info['adresaRestorana'] = $restoran->adresaRestorana;
        $info['gradRestorana'] = $restoran->gradRestorana;
        $info['drzavaRestorana'] = $restoran->drzavaRestorana;
        $info['slika'] = $slika->Putanja;
        $info['poruka'] = $poruka;

        $this->load->view('sablon/headerRestoran.php', ['title' => 'Moj profil']);
        $this->load->view('stranice/izmenaRestorana.php', $info);
        $this->load->view('sablon/footer.php');
    }

    public function pregledRestorana($idRestorana) {
        $korisnik = $this->session->userdata('korisnik');
        
        $info = parent::pregledRestorana($idRestorana);
        
        if ($idRestorana == $korisnik->id) {
            redirect('C_Restoran/IzmenaRestorana');
        }

        $this->load->view('sablon/headerRestoran.php', ['title' => 'Pretraga']);
        $this->load->view('stranice/pregledRestorana.php', $info);
        $this->load->view('sablon/footer.php');
    }

    public function izlogujse() {
        $korisnik = new stdClass();
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

    public function upload($putanja, $imeSlike, $vrstaSlike) {
        if (!file_exists($putanja)) {
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
                return "$imeSlike" . "$ekstenzija";
            }
        } else {
            return null;
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
            $korisnik = $this->session->userdata('korisnik');
            $restoran = $this->M_Restoran->dohvatiRestoran($korisnik->id);

            if (isset($_FILES['slikarestoran']) && $_FILES['slikarestoran']['error'] != UPLOAD_ERR_NO_FILE) {

                if (file_exists("./uploads/restoran/" . $korisnik->id . "/profil.png")) {
                    unlink("./uploads/restoran/" . $korisnik->id . "/profil.png");
                    rmdir("./uploads/restoran/" . $korisnik->id);
                }
                if (file_exists("./uploads/restoran/" . $korisnik->id . "/profil.jpg")) {
                    unlink("./uploads/restoran/" . $korisnik->id . "/profil.jpg");
                    rmdir("./uploads/restoran/" . $korisnik->id);
                }
                if (file_exists("./uploads/restoran/" . $korisnik->id . "/profil.gif")) {
                    unlink("./uploads/restoran/" . $korisnik->id . "/profil.gif");
                    rmdir("./uploads/restoran/" . $korisnik->id);
                }

                $putanjaDoFoldera = "./uploads/restoran/" . $korisnik->id;
                if (($nazivSlike = $this->upload($putanjaDoFoldera, "profil", "slikarestoran")) == null) {
                    if ($restoran->IdSlika != 2) {
                        $prosliId = $restoran->IdSlika;
                        $this->M_Restoran->promeniSlikuRestoranu($korisnik->id, 2);
                        $this->M_Slika->obrisiSliku($prosliId);
                    }

                    $this->izmenaRestorana("Greška pri otpremanju slike. Slika mora da zadovoljava sledeće kriterijume: <br /> "
                            . "Podržani formati: gif, jpg, png. <br />"
                            . "Maksimalna veličina 1000 bajtova. <br />"
                            . "Maksimalna rezolucija 2048x1024px.");
                    return;
                } else {
                    if ($restoran->IdSlika == 2) {
                        //ako je do sada bila genericka slika
                        //treba da se napravi nova slika
                        $poslednjaSlika = $this->M_Slika->poslednjiId()->poslednjiId;
                        $slikaId = $poslednjaSlika + 1;

                        $slika = new stdClass();
                        $slika->IdSlika = $slikaId;
                        $slika->Putanja = "http://localhost/GurmanGuide/Implementacija/uploads/restoran/" . $korisnik->id . "/" . $nazivSlike;
                        $this->M_Slika->unesiSliku($slika);


                        $promenljive['idSlika'] = $slikaId;
                    } else {
                        //ako nije, samo menjamo putanju
                        //mada da li je potrebno ako je ista putanja??
                        $putanja = "http://localhost/GurmanGuide/Implementacija/uploads/restoran/" . $korisnik->id . "/" . $nazivSlike;
                        $this->M_Slika->promeniPutanjuSlike($restoran->IdSlika, $putanja);
                    }
                }
            }
            $promenljive['id'] = $korisnik->id;
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
        
        $info = parent::pregledProfilaGurmana($idGurman);
        
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
        $korisnik = $this->session->userdata('korisnik');

        $poruka = '';
        $uneto['naziv'] = $this->input->post('naziv');
        $uneto['opisjela'] = $this->input->post('opisjela');
        $uneto['idKorisnik'] = $korisnik->id;

        $this->form_validation->set_rules('naziv', 'Naziv', 'required|trim', array('required' => 'Niste uneli naziv jela.'));
        $this->form_validation->set_rules('opisjela', 'Opis', 'required|trim', array('required' => 'Niste uneli opis jela.'));

        $brojac = 0;
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'name') !== false) {
                $brojac++;
            }
        }

        if ($this->form_validation->run() == FALSE || $brojac == 0) {
            $this->unosJela($brojac == 0 ? 'Niste uneli sastojke' : null);
        } else {

            $postojiJelo = $this->M_Jelo->proveriNazivJela($uneto);
            if ($postojiJelo != null) {
                $poruka = 'Jelo sa datim imenom vec postoji!';
                $this->unosJela($poruka);
            } else {

                $poslednjiId = $this->M_Jelo->poslednjiId()->poslednjiId;
                $uneto['idJela'] = $poslednjiId + 1;


                if (!file_exists("./uploads/jelo/" . $uneto['idJela'])) {
                    mkdir("./uploads/jelo/" . $uneto['idJela'], 0777, true);
                }

                //ako je uploadovana slika
                if (isset($_FILES['slikajelo']) && $_FILES['slikajelo']['error'] != UPLOAD_ERR_NO_FILE) {

                    $putanjaDoFoldera = "./uploads/jelo/" . $uneto['idJela'];
                    if (($nazivSlike = $this->upload($putanjaDoFoldera, "profil", "slikajelo")) == null) {
                        $this->unosJela("Greška pri otpremanju slike. Slika mora da zadovoljava sledeće kriterijume: <br /> "
                                . "Podržani formati: gif, jpg, png. <br />"
                                . "Maksimalna veličina 1000 bajtova. <br />"
                                . "Maksimalna rezolucija 2048x1024px.");
                        return;
                    } else {

                        $poslednjaSlika = $this->M_Slika->poslednjiId()->poslednjiId;
                        $slikaId = $poslednjaSlika + 1;

                        $slika = new stdClass();
                        $slika->IdSlika = $slikaId;
                        $slika->Putanja = "http://localhost/GurmanGuide/Implementacija/uploads/jelo/" . $uneto['idJela'] . "/" . $nazivSlike;
                        $this->M_Slika->unesiSliku($slika);

                        $uneto['idSlika'] = $slikaId;
                    }
                }

                $this->M_Jelo->napraviJelo($uneto);
                foreach ($_POST as $key => $value) {
                    if (strpos($key, 'name') !== false) {
                        $imeSastojka = strtolower($value);
                        if ($imeSastojka != "") {
                            $postojiSastojak = $this->M_Sastojak->postojiSastojak($imeSastojka);

                            if ($postojiSastojak != null) {
                                $idSastojka = $postojiSastojak->IdSastojak;
                            } else {
                                $idSastojka = $this->M_Sastojak->dodajSastojak($imeSastojka);
                            }
                            $this->M_Jelo->poveziSastojakSaJelom($idSastojka, $uneto['idJela']);
                        }
                    }
                }
                $this->index('Uspesno uneto jelo.');
            }
        }
    }

    public function prikaziMeniRestorana($idRestorana) {
        $korisnik = $this->session->userdata('korisnik');

        $info = parent::prikaziMeniRestorana($idRestorana);
        
        if ($idRestorana == $korisnik->id) {
            redirect('C_Restoran/izmenaMenijaRestorana');
        }

        $this->load->view("sablon/headerRestoran.php", ['title' => 'Meni restorana']);
        $this->load->view("stranice/meniRestorana.php", $info);
        $this->load->view('sablon/footer.php');
    }

    public function izmenaMenijaRestorana() {
        $korisnik = $this->session->userdata('korisnik');

        $jela = $this->M_Restoran->dohvatiJelaRestoranaId($korisnik->id);

        $niz = [];

        foreach ($jela as $jelo) {
            $klasa = new stdClass();
            $klasa->IdJelo = $jelo->IdJelo;
            $klasa->IdRestoran = $jelo->IdKorisnik;
            if ($jelo->Opis != null) {
                $klasa->Opis = $jelo->Opis;
            } else {
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

            $klasa->Sastojci = $sastojciString;

            $niz [] = $klasa;
        }
        $this->load->view("sablon/headerRestoran.php", ['title' => 'Meni restorana']);
        $this->load->view("stranice/meniRestorana.php", ['jela' => $niz, 'dugmeIzmeni' => 1]);
        $this->load->view('sablon/footer.php');
    }

    public function izmeniJelo($idJela, $poruka = null) {
        $korisnik = $this->session->userdata('korisnik');
        $jelo = $this->M_Jelo->dohvatiJelo($idJela);

        $sastojci = $this->M_Sastojak->dohvatiSastojkeJela($idJela);
        $najveciId = $this->M_Sastojak->poslednjiId()->poslednjiId + 1;

        $info = array(
            'slika' => $this->M_Slika->dohvatiPutanju($jelo->IdSlika)->Putanja,
            'naziv' => $jelo->Naziv,
            'opisjela' => $jelo->Opis,
            'idJela' => $idJela,
            'poruka' => $poruka,
            'sastojci' => $sastojci,
            'najveciId' => $najveciId
        );

        $this->load->view("sablon/headerRestoran.php", ['title' => 'Izmena jela']);
        $this->load->view("stranice/izmenaJela.php", $info);
        $this->load->view("sablon/footer.php");
    }

    public function sacuvajIzmeneJela($idJela) {
        //var_dump($_POST);
        $promenljive['naziv'] = $this->input->post('naziv');
        $promenljive['opisjela'] = $this->input->post('opisjela');
        
        $this->form_validation->set_rules('naziv', 'Naziv', 'required|trim', array('required' => 'Niste uneli naziv jela.'));
        $this->form_validation->set_rules('opisjela', 'Opis', 'required|trim', array('required' => 'Niste uneli opis jela.'));
        
        $brojac = 0;
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'name') !== false) {
                $brojac++;
            }
        }
        if ($this->form_validation->run() == FALSE || $brojac == 0) {
            $this->izmeniJelo($idJela, $brojac == 0 ? 'Niste uneli sastojke' : null);
        } else {
            $korisnik = $this->session->userdata('korisnik');
            $jelo = $this->M_Jelo->dohvatiJelo($idJela);
            if (isset($_FILES['slikajelo']) && $_FILES['slikajelo']['error'] != UPLOAD_ERR_NO_FILE) {

                if (file_exists("./uploads/jelo/" . $jelo->IdJelo . "/profil.png")) {
                    unlink("./uploads/jelo/" . $jelo->IdJelo . "/profil.png");
                    rmdir("./uploads/jelo/" . $jelo->IdJelo);
                }
                if (file_exists("./uploads/jelo/" . $jelo->IdJelo . "/profil.jpg")) {
                    unlink("./uploads/jelo/" . $jelo->IdJelo . "/profil.jpg");
                    rmdir("./uploads/jelo/" . $jelo->IdJelo);
                }
                if (file_exists("./uploads/jelo/" . $jelo->IdJelo . "/profil.gif")) {
                    unlink("./uploads/jelo/" . $jelo->IdJelo . "/profil.gif");
                    rmdir("./uploads/jelo/" . $jelo->IdJelo);
                }

                $putanjaDoFoldera = "./uploads/jelo/" . $jelo->IdJelo;
                if (($nazivSlike = $this->upload($putanjaDoFoldera, "profil", "slikajelo")) == null) {
                    if ($jelo->IdSlika != 3) {
                        $prosliId = $jelo->IdSlika;
                        $this->M_Jelo->promeniSlikuJelu($jelo->IdJelo, 3);
                        $this->M_Slika->obrisiSliku($prosliId);
                    }

                    $this->izmeniJelo($idJela, "Greška pri otpremanju slike. Slika mora da zadovoljava sledeće kriterijume: <br /> "
                            . "Podržani formati: gif, jpg, png. <br />"
                            . "Maksimalna veličina 1000 bajtova. <br />"
                            . "Maksimalna rezolucija 2048x1024px.");
                    return;
                } else {
                    if ($jelo->IdSlika == 3) {
                        //ako je do sada bila genericka slika
                        //treba da se napravi nova slika
                        $poslednjaSlika = $this->M_Slika->poslednjiId()->poslednjiId;
                        $slikaId = $poslednjaSlika + 1;

                        $slika = new stdClass();
                        $slika->IdSlika = $slikaId;
                        $slika->Putanja = "http://localhost/GurmanGuide/Implementacija/uploads/jelo/" . $jelo->IdJelo . "/" . $nazivSlike;
                        $this->M_Slika->unesiSliku($slika);


                        $promenljive['idSlika'] = $slikaId;
                    } else {
                        //ako nije, samo menjamo putanju
                        //mada da li je potrebno ako je ista putanja??
                        $putanja = "http://localhost/GurmanGuide/Implementacija/uploads/jelo/" . $jelo->IdJelo . "/" . $nazivSlike;
                        $this->M_Slika->promeniPutanjuSlike($jelo->IdSlika, $putanja);
                    }
                }
            }
            
            $this->M_Jelo->obrisiSastojke($idJela);
            
            foreach ($_POST as $key => $value) {
               // var_dump($_POST);
               // return;
                if (strpos($key, 'name') !== false) {
                     $imeSastojka = strtolower($value);
                     if ($imeSastojka != "") {  
                         echo $imeSastojka;
                        $postojiSastojak = $this->M_Sastojak->postojiSastojak($imeSastojka);
                        
                            if ($postojiSastojak != null) {
                                $idSastojka = $postojiSastojak->IdSastojak;
                            } else {
                                $idSastojka = $this->M_Sastojak->dodajSastojak($imeSastojka);
                            }
                            $this->M_Jelo->poveziSastojakSaJelom($idSastojka, $idJela);
                        
                    }
                }
            }
            
            $promenljive['id'] = $idJela;
            $this->M_Jelo->azuriranjeJela($promenljive);
            $this->index('Uspesno napravljene izmene.');
        }
    }

    public function ukloniJelo($idJela) {
        $this->M_Jelo->obrisiJelo($idJela);
        $this->izmenaMenijaRestorana();
    }
    
    public function prikaziJelo($id) {
        $korisnik = $this->session->userdata('korisnik');
        $info = parent::prikaziJelo($id);
        
        $jelo = $this->M_Jelo->dohvatiJelo($id);
        
        if ($jelo->IdKorisnik == $korisnik->id) {
            redirect('C_Restoran/izmeniJelo/'.$id);
        }
        
        $this->load->view('sablon/headerGurman.php', ['title' => $info['jelo']->Naziv]);
        $this->load->view("stranice/prikazJela.php", $info);
        $this->load->view('sablon/footer.php');
    }
 
    public function pretragaJelaPoNazivu($val) {
        $info = parent::pretragaJelaPoNazivu($val);
        $info['naslov'] = 'Rezultat pretrage';
        
        $this->load->view('sablon/headerRestoran.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/rezultatPretrage.php", $info);
        $this->load->view('sablon/footer.php');
    }
    
    public function pretragaJelaPoSastojku($val) {
        $info = parent::pretragaJelaPoSastojku($val);
        $info['naslov'] = 'Rezultat pretrage';
        
        $this->load->view('sablon/headerRestoran.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/rezultatPretrage.php", $info);
        $this->load->view('sablon/footer.php');
    }
    
    public function pretragaJelaPoRestoranu($val) {
        $info = parent::pretragaJelaPoRestoranu($val);
        $info['naslov'] = 'Rezultat pretrage';
        
        $this->load->view('sablon/headerRestoran.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/rezultatPretrage.php", $info);
        $this->load->view('sablon/footer.php');
    }
    
    public function pretragaRestoranaPoNazivu($val) {
        $info = parent::pretragaRestoranaPoNazivu($val);
        $info['naslov'] = 'Rezultat pretrage';
        
        $this->load->view('sablon/headerRestoran.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/rezultatPretrageRestoran.php", $info);
        $this->load->view('sablon/footer.php');
    }
    
    public function pretragaRestoranaPoAdresi($val) {
        $info = parent::pretragaRestoranaPoAdresi($val);
        $info['naslov'] = 'Rezultat pretrage';
        
        $this->load->view('sablon/headerRestoran.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/rezultatPretrageRestoran.php", $info);
        $this->load->view('sablon/footer.php');
    }

}
