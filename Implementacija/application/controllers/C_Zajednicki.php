<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of C_Zajednicki
 *
 * @author Lazar Lazic 0245/2016
 * @version 1.0
 */
class C_Zajednicki extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Dohvata informacije o Gurmanu iz modela
     * 
     * @param int $idGurman
     * 
     * @return associative array
     */
    public function pregledProfilaGurmana($idGurman) {
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
        
        return $info;
    }
    
    /**
     * Vrsi upload slike
     * 
     * @param string $putanja
     * @param string $imeSlike
     * @param string $vrstaSlike
     * 
     * @return string
     */
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
    
    /**
     * Dohvata informacije o Jelu iz modela
     * 
     * @param int $id -> idJelo
     * 
     * @return associative array
     */
    public function prikaziJelo($id) {
        $jelo = $this->M_Jelo->dohvatiJelo($id);
        
        $klasa = new stdClass();
        $klasa->Naziv = $jelo->Naziv;
        $klasa->Putanja = $this->M_Slika->dohvatiPutanju($jelo->IdSlika)->Putanja;
        $klasa->IdJela = $id;
        
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
        
        return ['jelo' => $klasa, 'recenzije' => $niz];
    }
    
    /**
     * Dohvata informacije o jelima sa zadatim nazivom iz modela
     * 
     * @param string $val
     * 
     * @return associative array
     */
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
        
        return ['jela' => $niz];
    }
    
    /**
     * Dohvata informacije o jelima restorana sa zadatim nazivom iz modela
     * 
     * @param string $val
     * 
     * @return associative array
     */
    public function pretragaJelaPoRestoranu($val) {
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
        
        return ['jela' => $niz];
    }
    
    /**
     * Dohvata informacije o restoranima sa zadatim nazivom iz modela
     * 
     * @param string $val
     * 
     * @return associative array
     */
    public function pretragaRestoranaPoNazivu($val) {
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
        
        return ['restorani' => $niz];
    }
    
    /**
     * Dohvata informacije o restoranima sa zadatom adresom iz modela
     * 
     * @param string $val
     * 
     * @return associative array
     */
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
        
        return ['restorani' => $niz];
    }
    
    /**
     * Dohvata informacije o jelima sa zadatim sastojkom iz modela
     * 
     * @param string $val
     * 
     * @return associative array
     */
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
        
        return ['jela' => $niz];
    }
    
    /**
     * Dohvata informacije o restoranu iz modela
     * 
     * @param int $idRestorana
     * 
     * @return associative array
     */
    public function pregledRestorana($idRestorana){
        $restoran = $this->M_Restoran->dohvatiRestoran($idRestorana);

        $info['korime'] = $restoran->korime;
        $info['lozinka'] = $restoran->lozinka;
        $info['email'] = $restoran->email;
        $info['brTelefona'] = $restoran->brTelefona;
        $info['imeRestorana'] = $restoran->imeRestorana;
        $info['radnoVreme'] = $restoran->radnoVreme;
        $info['adresaRestorana'] = $restoran->adresaRestorana;
        $info['gradRestorana'] = $restoran->gradRestorana;
        $info['drzavaRestorana'] = $restoran->drzavaRestorana;
        $info['slikaRestorana'] = $this->M_Slika->dohvatiPutanju($restoran->IdSlika)->Putanja;

        $input = str_replace('%20', ' ', $info['imeRestorana']);
        $input = trim($input);

        $jela = $this->M_Restoran->dohvatiTopTriJelaRestorana($idRestorana); //$this->M_Restoran->dohvatiJelaRestorana($input);

        $niz = [];

        $brojacJela = 0;
        foreach ($jela as $jelo) {
            $brojacJela++;
            if ($brojacJela == 4)
                break;
            $klasa = new stdClass();
            $klasa->IdJelo = $jelo->IdJelo;
            $klasa->IdRestoran = $jelo->IdKorisnik;
            $klasa->Naziv = $jelo->Naziv;
            if ($jelo->Opis != null) {
                $klasa->Opis = $jelo->Opis;
            } else {
                $klasa->Opis = "Trenutno ne postoji opis.";
            }
            $klasa->Ocena = round($jelo->Ocena);
            $klasa->Putanja = $this->M_Slika->dohvatiPutanju($jelo->IdSlika)->Putanja;


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
        
        return ['jela' => $niz, 'slikaRestorana' => $info['slikaRestorana'], 'korime' => $info['korime'], 'lozinka' => $info['lozinka'], 'email' => $info['email'],
            'brTelefona' => $info['brTelefona'], 'radnoVreme' => $info['radnoVreme'], 'adresaRestorana' => $info['adresaRestorana'], 'gradRestorana' => $info['gradRestorana'],
            'drzavaRestorana' => $info['drzavaRestorana'], 'imeRestorana' => $info['imeRestorana'], 'idRestoran' => $idRestorana];
    }
    
    /**
     * Dohvata informacije o jelima za zadati restoran
     * 
     * @param int $idRestorana
     * 
     * @return associative array
     */
    public function prikaziMeniRestorana($idRestorana) {
        $jela = $this->M_Restoran->dohvatiJelaRestoranaId($idRestorana);


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
        return ['jela' => $niz];
    }
    
}
