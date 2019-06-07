<?php

include_once('C_Zajednicki.php');
/**
 * Kontroler koji odgovara korisniku koji trenutno nije ulogovan.
 *
 * @author Nenad Babin 0585/2016
 * @author Lazar Lazic 0245/2016
 * @version 1.1
 */
class C_Gost extends C_Zajednicki {

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
    }

    /**
     * Indeks stranica kontrolera Gost. Metoda ucitava index stranicu zajedno sa podacima o top jelu.
     * Sastavni deo index stranice su headerGost i footer.
     */
    public function index() {
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

    /**
     * Metoda za ucitavanje stranice za registraciju Gurmana
     * @param type $poruka Poruka koja se ispisuje ispod header-a, a iznad forme za registraciju u slucaju neuspeha.
     * Ukoliko se paametar ne prosledi, stranica se ucitava bez poruke.
     */
    public function registrujGurmana($poruka = null) {
        $this->load->view("sablon/headerGost.php", ['title' => 'Registracija']);
        $this->load->view('stranice/registracijaGurmana.php', ['poruka' => $poruka]);
        $this->load->view('sablon/footer.php');
    }

    /**
     * Metoda za ucitavanje stranice za registraciju Restorana
     * @param type $poruka Poruka koja se ispisuje ispod header-a, a iznad forme za registraciju u slucaju neuspeha.
     * Ukoliko se paametar ne prosledi, stranica se ucitava bez poruke.
     */
    public function registrujRestoran($poruka = null) {
        $gradovi = $this->M_Grad->gohvatiSveGradove();
        $this->load->view("sablon/headerGost.php", ['title' => 'Registracija']);
        $this->load->view('stranice/registracijaRestorana.php', ['gradovi' => $gradovi, 'poruka' => $poruka]);
        $this->load->view('sablon/footer.php');
    }

    /**
     * Metoda za ucitavanje stranice za logovanje
     * @param type $poruka Poruka koja se ispisuje ispod header-a, a iznad forme za logovanje u slucaju neuspeha.
     * Ukoliko se paametar ne prosledi, stranica se ucitava bez poruke.
     */
    public function prijaviSe($poruka = null) {
        $this->load->view("sablon/headerGost.php", ['title' => 'Login']);
        $this->load->view('stranice/login.php', ['poruka' => $poruka]);
        $this->load->view('sablon/footer.php');
    }

    /**
     * Metoda za proveru prijave korisnika. Uspesno ulogovan korisnik se redirektuje na odgovarajuci kontroler
     * i zapocinje se sesija. U suprotnom se korisniku ispisuje razlog neuspeha logovanja.
     */
    public function proveraPrijave() {
        $korime = $this->input->post("korimegurman");
        $sifra = $this->input->post("lozinkagurman");

        $this->form_validation->set_rules('korimegurman', 'Korisnicno ime', 'required');
        $this->form_validation->set_rules('lozinkagurman', 'Sifra', 'required');

        if ($this->form_validation->run() == FALSE) {
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
                        } else {
                            $this->prijaviSe("Šifra ne odgovara korisničkom imenu!");
                        }
                    } else {
                        $this->prijaviSe("Ne postoji korisnik sa korisničnim imenom " . $korime . "!");
                    }
                }
            }
        }
    }

    /**
     * Metoda za proveru registracije Gurmana. Metoda proverava da li su podaci uspesno uneti i
     * da li u sistemu vec ne postoji takav korisnik. Ukoliko se korisnik odlucio za upload slike,
     * radi se upload slike u folder na serveru koji odgovara korisniku. U suportonom se ispisuje poruka
     * o gresci. Uspesno registrovan korisnik se preusmerava na stranicu za logovanje.
     */
    public function proveraRegistracijeGurman() {
        $korime = $this->input->post("korimegurman");
        $sifra = $this->input->post("lozinkagurman");
        $sifraPotvrda = $this->input->post("potvrdalozinkegurman");
        $email = $this->input->post("email");
        $ime = $this->input->post("imegurman");
        $prezime = $this->input->post("prezimegurman");
        $pol = $this->input->post("pol");

        $this->form_validation->set_rules('korimegurman', 'Korisnicno ime', 'required|trim|is_unique[korisnik.KorisnickoIme]|min_length[4]|max_length[20]', array('required' => 'Niste uneli korisničko ime', 'is_unique' => 'Korisničko ime već postoji', 'min_length' => 'Korisničko ime mora imati bar 4 znaka.', 'max_length' => 'Korisničko ime ne sme biti duže od 20 znakova.'));
        $this->form_validation->set_rules('lozinkagurman', 'Sifra', 'required|min_length[4]|max_length[20]', array('required' => 'Niste uneli šifru', 'min_length' => 'Šifra mora imati bar 4 znaka.', 'max_length' => 'Šifra ne sme biti duža od 20 znakova.'));
        $this->form_validation->set_rules('potvrdalozinkegurman', 'Potvrda sifre', 'required|matches[lozinkagurman]', array('required' => 'Niste uneli potvrdu šifre', 'matches' => 'Šifre koje ste uneli se ne poklapaju'));
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
            if (!file_exists("./uploads/gurman/" . "$id")) {
                mkdir("./uploads/gurman/" . "$id", 0777, true);
            }

            //ako je uploadovana slika
            if (isset($_FILES['slikagurman']) && $_FILES['slikagurman']['error'] != UPLOAD_ERR_NO_FILE) {

                $putanjaDoFoldera = "./uploads/gurman/" . "$id";
                if (($nazivSlike = $this->upload($putanjaDoFoldera, "profil", "slikagurman")) == null) {
                    $this->registrujGurmana("Greška pri otpremanju slike. Slika mora da zadovoljava sledeće kriterijume: <br /> "
                            . "Podržani formati: gif, jpg, png. <br />"
                            . "Maksimalna veličina 1000 KB. <br />"
                            . "Maksimalna rezolucija 2048x1024px.");
                    return;
                } else {

                    $poslednjaSlika = $this->M_Slika->poslednjiId()->poslednjiId;
                    $slikaId = $poslednjaSlika + 1;

                    $slika = new stdClass();
                    $slika->IdSlika = $slikaId;
                    $slika->Putanja = "http://localhost/GurmanGuide/Implementacija/uploads/gurman/" . $id . "/" . $nazivSlike;
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

    /**
     * Metod za proveru ispravnosti e-mail adrese.
     * 
     * @param type $str E-mail adresa cija se provera vrsi.
     * @return boolean Vraca TRUE ako je E-Mail adresa odgovara sablonu, u suprotnom vraca FALSE.
     */
    public function regex_check($str) {
        if (preg_match("/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})/i", $str)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('regex_check', 'Mejl nije u očekivanom formatu');
            return FALSE;
        }
    }

    //vrsta slike moze biti:
    //      slikagurman
    //      slikarestoran
    /**
     * Metod za upload slike na server.
     * 
     * @param type $putanja Putanja na kojoj se cuva slika. Ukoliko putanja jos uvek ne posotji, pravi se nova.
     * @param type $imeSlike Naziv slike na serveru.
     * @param type $vrstaSlike Naziv elementra forme koji sluzi za odabir slike.
     * @return name.extension/null Ukoliko je upload bio uspesan vraca se imeSlike.ekstenzija, dok se u
     * suprotnom vraca NULL.
     */
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

    /**
     * Metoda za proveru registracije Restorana. Metoda proverava da li su podaci uspesno uneti i
     * da li u sistemu vec ne postoji takav korisnik. Ukoliko se korisnik odlucio za upload slike,
     * radi se upload slike u folder na serveru koji odgovara korisniku. U suportonom se ispisuje poruka
     * o gresci. Uspesno registrovan korisnik se preusmerava na stranicu za logovanje.
     */
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

        $this->form_validation->set_rules('korimerestoran', 'Korisnicno ime', 'required|trim|is_unique[korisnik.KorisnickoIme]|min_length[4]|max_length[20]', array('required' => 'Niste uneli korisničko ime', 'is_unique' => 'Korisničko ime već postoji', 'min_length' => 'Korisničko ime mora imati bar 4 znaka.', 'max_length' => 'Korisničko ime ne sme biti duže od 20 znakova.'));
        $this->form_validation->set_rules('lozinkarestoran', 'Sifra', 'required|min_length[4]|max_length[20]', array('required' => 'Niste uneli šifru', 'min_length' => 'Šifra mora imati bar 4 znaka.', 'max_length' => 'Šifra ne sme biti duža od 20 znakova.'));
        $this->form_validation->set_rules('potvrdalozinkerestoran', 'Potvrda sifre', 'required|matches[lozinkarestoran]', array('required' => 'Niste uneli potvrdu šifre', 'matches' => 'Šifre koje ste uneli se ne poklapaju'));
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
            if (!file_exists("./uploads/restoran/" . "$id")) {
                mkdir("./uploads/restoran/" . "$id", 0777, true);
            }

            //ako je uploadovana slika
            if (isset($_FILES['slikarestoran']) && $_FILES['slikarestoran']['error'] != UPLOAD_ERR_NO_FILE) {

                $putanjaDoFoldera = "./uploads/restoran/" . "$id";
                if (($nazivSlike = $this->upload($putanjaDoFoldera, "profil", "slikarestoran")) == null) {
                    $this->registrujRestoran("Greška pri otpremanju slike. Slika mora da zadovoljava sledeće kriterijume: <br /> "
                            . "Podržani formati: gif, jpg, png. <br />"
                            . "Maksimalna veličina 1000 KB. <br />"
                            . "Maksimalna rezolucija 2048x1024px.");
                    return;
                } else {

                    $poslednjaSlika = $this->M_Slika->poslednjiId()->poslednjiId;
                    $slikaId = $poslednjaSlika + 1;

                    $slika = new stdClass();
                    $slika->IdSlika = $slikaId;
                    $slika->Putanja = "http://localhost/GurmanGuide/Implementacija/uploads/restoran/" . $id . "/" . $nazivSlike;
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

    /**
     * Metod za ucitavanje stranice koja predstavlja rezultat pretrage jela po nazivu.
     * 
     * @param type $val Naziv jela koje se pretrazuje. Umesto naziva se moze proslediti samo deo naziva ili
     * string koji je podstring naziva jela. Ukoliko nema rezultata, ispisuje se poruka o gresci.
     */
    public function pretragaJelaPoNazivu($val) {
        $jela = parent::pretragaJelaPoNazivu($val);
        $this->load->view('sablon/headerGost.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/rezultatPretrage.php", ['jela' => $jela['jela'], 'naslov' => 'Rezultat pretrage']);
        $this->load->view('sablon/footer.php');
    }

     /**
     * Metod za ucitavanje stranice koja predstavlja rezultat pretrage jela po sastojku.
     * 
     * @param type $val Naziv sastojka koji se sadrzi u jelima. Umesto naziva se moze proslediti samo deo naziva ili
     * string koji je podstring naziva sastojka. Ukoliko nema rezultata, ispisuje se poruka o gresci.
     */
    function pretragaJelaPoSastojku($val) {
        $jela = parent::pretragaJelaPoSastojku($val);
        $this->load->view('sablon/headerGost.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/rezultatPretrage.php", ['jela' => $jela['jela'], 'naslov' => 'Rezultat pretrage']);
        $this->load->view('sablon/footer.php');
    }

    /**
     * Metod za ucitavanje stranice koja predstavlja rezultat pretrage jela po restoranu.
     * 
     * @param type $val Naziv restorana cija jela pretrazujemo. Umesto naziva se moze proslediti samo deo naziva ili
     * string koji je podstring naziva restorana. Ukoliko nema rezultata, ispisuje se poruka o gresci.
     */
    function pretragaJelaPoRestoranu($val) {
        $jela = parent::pretragaJelaPoRestoranu($val);
        $this->load->view('sablon/headerGost.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/rezultatPretrage.php", ['jela' => $jela['jela'], 'naslov' => 'Rezultat pretrage']);
        $this->load->view('sablon/footer.php');
    }

    /**
     * Metod za ucitavanje stranice koja predstavlja rezultat pretrage restorana po nazivu.
     * 
     * @param type $val Naziv restorana koje zelimo da pretrazimo. Umesto naziva se moze proslediti samo deo naziva ili
     * string koji je podstring naziva restorana. Ukoliko nema rezultata, ispisuje se poruka o gresci.
     */
    function pretragaRestoranaPoNazivu($val) {
        $restorani = parent::pretragaRestoranaPoNazivu($val);
        $this->load->view('sablon/headerGost.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/rezultatPretrageRestoran.php", ['restorani' => $restorani['restorani'], 'naslov' => 'Rezultat pretrage']);
        $this->load->view('sablon/footer.php');
    }

    /**
     * Metod za ucitavanje stranice koja predstavlja rezultat pretrage restorana po adresi.
     * 
     * @param type $val Adresa restorana koje zelimo da pretrazimo. Umesto naziva se moze proslediti samo deo naziva ili
     * string koji je podstring adrese restorana. Ukoliko nema rezultata, ispisuje se poruka o gresci.
     */
    public function pretragaRestoranaPoAdresi($val) {
        $restorani = parent::pretragaRestoranaPoAdresi($val);
        $this->load->view('sablon/headerGost.php', ['title' => 'Rezultat pretrage']);
        $this->load->view("stranice/rezultatPretrageRestoran.php", ['restorani' => $restorani['restorani'], 'naslov' => 'Rezultat pretrage']);
        $this->load->view('sablon/footer.php');
    }

    /**
     * Metod za ucitavanje stranice koja prikazuje jelo.
     * 
     * @param type $id Id jela koje zelimo da prikazemo.
     */
    public function prikaziJelo($id) {
        $rezultat = parent::prikaziJelo($id);
        $this->load->view('sablon/headerGost.php', ['title' => 'Prikaz jela']);
        $this->load->view("stranice/prikazJela.php", ['jelo' => $rezultat['jelo'], 'recenzije' => $rezultat['recenzije']]);
        $this->load->view('sablon/footer.php');
    }

    /**
     * Metod za ucitavanje stranice koja prikazuje profil Gurmana.
     * 
     * @param type $id Id Gurmana kojeg zelimo da prikazemo.
     */
    public function pregledProfilaGurmana($idGurman) {
        $info = parent::pregledProfilaGurmana($idGurman);
        $korime = $info['korime'];
        $this->load->view('sablon/headerGost.php', ['title' => "Pregled profila " . $korime]);
        $this->load->view('stranice/pregledGurmana.php', $info);
        $this->load->view('sablon/footer.php');
    }

    /**
     * Metod za ucitavanje stranice Kontakt.
     */
    public function kontakt() {
        $this->load->view('sablon/headerGost.php', ['title' => 'Kontakt']);
        $this->load->view('stranice/kontakt.php');
        $this->load->view('sablon/footer.php');
    }

    /**
     * Metod za ucitavanje stranice O nama.
     */
    public function onama() {
        $this->load->view('sablon/headerGost.php', ['title' => 'O nama']);
        $this->load->view('stranice/onama.php');
        $this->load->view('sablon/footer.php');
    }

    /**
     * Metod za ucitavanje stranice koja prikazuje profil Restorana.
     * 
     * @param type $idRestorana Id Restorana koji zelimo da prikazemo.
     */
    public function pregledRestorana($idRestorana) {
        $info = parent::pregledRestorana($idRestorana);
        $this->load->view('sablon/headerGost.php', ['title' => 'Restoran']);
        $this->load->view('stranice/pregledRestorana.php', $info);
        $this->load->view('sablon/footer.php');
    }

    /**
     * Metod za ucitavanje stranice koja prikazuje meni Restorana.
     * 
     * @param type $idRestorana Id Restorana ciji meni zelimo da prikazemo.
     */
    public function prikaziMeniRestorana($idRestorana) {
        $info = parent::prikaziMeniRestorana($idRestorana);
        $this->load->view("sablon/headerGost.php", ['title' => 'Meni restorana']);
        $this->load->view("stranice/meniRestorana.php", $info);
        $this->load->view('sablon/footer.php');
    }
    
    /**
     * Funckija za proveru korisnickog imena koriscenjem AJAX.
     * 
     * @param string $korime
     * @return void
     */
    public function proveraKorisnickogImena($korime) {
        $this->db->from('korisnik');
        $this->db->where('KorisnickoIme', urldecode($korime));
        
        $korisnik = $this->db->get()->result();
        
        if ($korisnik != null) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

}
