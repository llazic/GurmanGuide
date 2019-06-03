<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Jelo
 *
 * @author Nenad Babin 0585/2016
 * @author Dunja Culafic 0236/2016
 * @version 1.0
 */
class M_Jelo extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Dohvata pregledana jela cije ime odgovara prosledjenom parametru. Funkcija ne dohvata samo istoimena jela,
     * vec jela koja u svom nazivu imaju prosledjeni parametar.
     * 
     * @param type $pattern Ime po kom se traze jela.
     * @return stdClass Objekat sa poljima Naziv, Opis, IdJelo, IdKorisnik, IdSlika, Pregledano
     */
    public function dohvatiJelaPoNazivu($pattern) {
        $this->db->select('*');
        $this->db->from('jelo');
        $this->db->like('Naziv', $pattern);
        $this->db->where('Pregledano', 'P');

        return $this->db->get()->result();
    }

    /**
     * Dohvata poslednji ID u bazi iz tabele jelo.
     * 
     * @return stdClass Objekat sa poljem poslednjiId
     */
    public function poslednjiId() {
        $this->db->select('max(jelo.IdJelo) as poslednjiId');
        $this->db->from('jelo');

        return $this->db->get()->row();
    }
    
    /**
     *Funkcija koja sluzi za proveru naziva jela, odnosno da li jelo sa datim imenom vec postoji kod datog restorana
     * 
     * @param type $uneto Asocijativni niz sa poljima naziv, idKorisnik, opisjela
     * 
     * @return stdClass Objekat sa poljem IdJelo - u slucaju da postoji to jelo, u suprotnom vraca null
     * 
     * @return void
     */

    public function proveriNazivJela($uneto) {
        $this->db->select('jelo.IdJelo as IdJelo');
        $this->db->from('jelo');
        $this->db->where('Naziv', $uneto['naziv']);
        $this->db->where('IdKorisnik', $uneto['idKorisnik']);

        return $this->db->get()->row();
    }

    /**
     *Funkcija koja sluzi za pravljenje novog jela ulogovanog restorana
     * 
     * @param type $uneto Asocijativni niz sa poljima naziv, idKorisnik, opisjela, idSlika, idJela
     * 
     * @return void
     */
    
    public function napraviJelo($uneto) {
        $this->db->set('IdJelo', $uneto['idJela']);
        $this->db->set('IdKorisnik', $uneto['idKorisnik']);
        $this->db->set('Naziv', $uneto['naziv']);
        $this->db->set('Opis', $uneto['opisjela']);
        $this->db->set('Pregledano', 'N');
        if (isset($uneto['idSlika'])) {
            $this->db->set('IdSlika', $uneto['idSlika']);
        } else {
            $this->db->set('IdSlika', 3);
        }
        $this->db->insert('jelo');
    }
    
    /**
     *Funkcija koja sluzi za popunjavanje tabele ima_sastojak, odnosno pravi vezu izmedju sastojka i jela
     * 
     * @param int $idSastojka
     * @param int $idJela
     * 
     * @return void
     */

    public function poveziSastojakSaJelom($idSastojka, $idJela) {
        $this->db->set('IdJelo', $idJela);
        $this->db->set('IdSastojak', $idSastojka);
        $this->db->insert('ima_sastojak');
    }
    
    /**
     *Funkcija koja sluzi za dohvatanje jela sa datim id-ijem
     * 
     * @param int $idJelo
     * 
     * @return stdClass Objekat sa poljem IdJelo, Naziv, Opis, IdKorisnik, IdSlika, Pregledano - u slucaju da postoji to jelo, u suprotnom vraca null
     */

    public function dohvatiJelo($idJelo) {
        $this->db->from('jelo');
        $this->db->where('IdJelo', $idJelo);

        return $this->db->get()->row();
    }
    
    /**
     *Funkcija koja sluzi za brisanje jela sa datim id-ijem
     * 
     * @param int $idJela
     * 
     * @return void
     */

    public function obrisiJelo($idJela) {
        $this->db->where('IdJelo', $idJela);
        $this->db->delete('jelo');
    }
	
	/**
     * Dohvata sva nepregledana jela  
     * 
     * @return stdClass Objekat sa poljima Naziv, Opis, IdJelo, IdKorisnik, IdSlika, Pregledano
     */
	 
    public function dohvatiNepregledanaJela() {
        return $this->db->select("*")->from('jelo')->where('Pregledano', 'N')->get()->result();
    }
	
	/**
     * Postavlja flag da je jelo pregledano
     * 
	 * @param type $id
	 * @return void
     */

    public function postaviPregledano($id) {
        $this->db->set('Pregledano', 'P');
        $this->db->where('IdJelo', $id);
        $this->db->update('jelo');
    }
    
    /**
     * Funkcija koja sluzi da jelu sa datim id-ijem promeni sliku
     * 
     * @param int $idJelo
     * @param int $idSlika
     * 
     * @return void
     */
    
    public function promeniSlikuJelu($idJelo, $idSlika){
        $this->db->set('IdSlika', $idSlika);
        $this->db->where('IdJelo', $idJelo);
        $this->db->update('jelo');
    }
    
    /**
     * Funkcija koja sluzi da izbrise povezanost datog jela sa sastojcima, iz tabele ima_sastojak
     * 
     * @param int $idJelo
     * 
     * @return void
     */
    
    public function obrisiSastojke($idJelo){
        $this->db->where('IdJelo', $idJelo);
        $this->db->delete('ima_sastojak');
    }
    
    /**
     * Funkcija koja sluzi za izmenu jela ulogovanog restorana
     * 
     * @param type $promenljive Asocijativni niz sa poljima naziv, idSlika, opisjela, id
     * 
     * @return void
     */
    
    public function azuriranjeJela($promenljive){
        $this->db->set('Naziv', $promenljive['naziv']);
        $this->db->set('Opis', $promenljive['opisjela']);
        $this->db->set('Pregledano', 'N');
        if (isset($promenljive['idSlika'])){
            $this->db->set('IdSlika', $promenljive['idSlika']);
        }
        $this->db->where('IdJelo', $promenljive['id']);
        $this->db->update('jelo');
    }

}
