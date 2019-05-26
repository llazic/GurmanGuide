<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of C_Zajednicki
 *
 * @author Lazar
 */
class C_Zajednicki extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
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
        
        return ['jelo' => $klasa, 'recenzije' => $niz];
    }
}
