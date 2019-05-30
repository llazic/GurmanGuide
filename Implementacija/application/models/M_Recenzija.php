<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Recenzija
 *
 * @author Lazar Lazic 0245/2016
 * @version 1.0
 */
class M_Recenzija
extends CI_Model{
    public function __construct() {
        parent::__construct();
    }

    /**
     * Funckija za dohvatanje jedne recenzije jela, ciji ID se prosledjuje.
     * 
     * @param type $id ID jela cija recenzija se dohvata.
     * @return stdClass Vraca objekat sa poljima IdKorisnik, Ocena, Komentar, IdJelo, Pregledano. 
     * Ukoliko ne postoji ni jedna recenzija vraca se null.
     */
    public function dohvatiJednuRecenziju($id) {
       
        $topOcena = $this->dohvatiTopOcenu($id);
        
        if ($topOcena != null) {
            $this->db->select("*");
            $this->db->from('recenzija');
            $this->db->where('IdJelo', $id);
            $this->db->where('Ocena', $topOcena->topOcena);

            return $this->db->get()->row();
        } else {
            return null;
        }
    }

    /**
     * Funckija za dohvatanje svih pregledanih recenzija jela, ciji ID se prosledjuje.
     * 
     * @param type $id ID jela cija recenzija se dohvata.
     * @return stdClass Vraca objekat sa poljima IdKorisnik, Ocena, Komentar, IdJelo, Pregledano. 
     * Ukoliko ne postoji ni jedna recenzija vraca se null.
     */
    public function dohvatiRecenzijeJela($id) {
        $this->db->select("*");
        $this->db->from('recenzija');
        $this->db->where('IdJelo', $id);
        $this->db->where('Pregledano', 'P');

        return $this->db->get()->result();
    }
    
    /**
     * Dohvata recenziju zadatog Gurmana za zadato jelo
     * 
     * @param int $idKorisnik -> idGurman
     * @param int $idJelo
     * 
     * @return stdClass 
     */
    public function dohvatiRecenziju($idKorisnik, $idJelo){
        $this->db->from('recenzija');
        $this->db->where('IdKorisnik', $idKorisnik);
        $this->db->where('IdJelo', $idJelo);

        return $this->db->get()->row();
    }
    
    /**
     * Ukoliko postoji recenzija datog Gurmana za dato jelo, azurira je; u suprotnom pravi novu
     * 
     * @param int $idKorisnik
     * @param int $idJelo
     * @param int $ocena
     * @param string $komentar
     * 
     * @return void 
     */
    public function napraviIzmeniRecenziju($idKorisnik, $idJelo, $ocena, $komentar){
        $recenzija = $this->dohvatiRecenziju($idKorisnik, $idJelo);

        if ($recenzija == null){
            $podaci = array(
                'IdKorisnik' => $idKorisnik,
                'IdJelo' => $idJelo,
                'Ocena' => $ocena,
                'Komentar' => $komentar,
                'Pregledano' => 'N'
            );

            $this->db->insert('recenzija', $podaci);
        } else {
            $this->db->set('Ocena', $ocena);
            $this->db->set('Komentar', $komentar);
            $this->db->set('Pregledano', 'N');
            $this->db->where('IdKorisnik', $idKorisnik);
            $this->db->where('IdJelo', $idJelo);
            $this->db->update('recenzija');
        }
    }
    
    /**
     * Dohvata pregledane recenzije zadatog Gurmana zajedno jelima i slikama tih jela iz baze
     * 
     * @param int $id -> idGurman
     * 
     * @return stdClass 
     */
    public function dohvatiRecenzijeGurmana($idGurman){
        $query = $this->db->query("select r.IdKorisnik, r.Ocena, "
                . "r.Komentar, r.IdJelo, r.Pregledano, j.Naziv as NazivJela, "
                . "j.Opis, j.IdKorisnik as IdRestoran, j.IdSlika, "
                . "j.Pregledano, s.Putanja as PutanjaSlike "
                . "from recenzija r, jelo j, slika s "
                . "where r.IdKorisnik = ".$idGurman." "
                . "and r.Pregledano = 'P' "
                . "and r.IdJelo = j.IdJelo "
                . "and j.IdSlika = s.IdSlika");

        return $query->result();
    }
    
    /**
     * Dohvata nepregledane recenzije iz baze
     * 
     * @return stdClass 
     */
    public function dohvatiNepregledaneRecenzije() {
        $query = $this->db->query("select kor.KorisnickoIme as NazKor, "
                . "res.Naziv as NazRes, jel.Naziv as NazJel, "
                . "rec.Komentar as Opis, rec.Ocena as Ocena, rec.IdKorisnik as IdKor, rec.IdJelo as IdJel "
                . "from recenzija rec, jelo jel, restoran res, korisnik kor "
                . "where kor.IdKorisnik = rec.IdKorisnik "
                . "and rec.Pregledano = 'N' "
                . "and rec.IdJelo = jel.IdJelo "
                . "and jel.IdKorisnik = res.IdKorisnik");

        return $query->result();
    }
    
    /**
     * Oznacava recenziju zadatog Gurmana za zadato jelo da je pregledana
     * 
     * @param int $idk -> idGurman
     * @param int $idj -> idJelo
     * 
     * @return void 
     */
    public function postaviPregledano($idk,$idj) {
        $this->db->set('Pregledano', 'P');
        $this->db->where('IdKorisnik', $idk);
        $this->db->where('IdJelo', $idj);
        $this->db->update('recenzija');
    }
    
    /**
     * Brise recenziju zadatog Gurmana za zadato jelo
     * 
     * @param int $idk -> idGurman
     * @param int $idj -> idJelo
     * 
     * @return void 
     */
    public function obrisiRecenziju($idk,$idj){
        $this->db->where('IdKorisnik', $idk);
        $this->db->where('IdJelo', $idj);
        $this->db->delete('recenzija');
    }
    
    
    /**
     * Funckija za dohvatanje prosecne ocene jela, ciji ID se prosledjuje.
     * 
     * @param type $idJelo
     * @return stdClass Vraca objekat sa poljem ocena. 
     * Ukoliko ne postoji ni jedna recenzija vraca se null.
     */
    public function ocenaJela($idJelo) {
        $this->db->select('avg(Ocena) as ocena');
        $this->db->from('recenzija');
        $this->db->where('IdJelo', $idJelo);
        $this->db->where('Pregledano', 'P');

        return $this->db->get()->row();
    }

    //Ovaj upit mora da se lepse uradi -> MAX(AVG)
    //Moze da se promeni da vrati sve prosecne ocene, a onda se programski nadje maks avg vrednosti
    //output: IdJela sa najvecom prosecnom ocenom
    //ovo se korisiti za main
    /**
     * Funkcija za dohvatanje jela na pocetnoj stranici. Funckija vraca bilo koje jelo cija je prosecna ocena veca od 4.
     * 
     * @return stdClass Vraca objekat sa poljem IdJelo
     * Ukoliko takvo jelo ne postoji, vraca se null (ni jedno jelo se ne ispisuje na pocetnoj stranici).
     */
    public function dohvatiTopJelo() {
        $this->db->select('IdJelo');
        $this->db->from('recenzija');
        $this->db->where('Pregledano', 'P');
        $this->db->group_by('IdJelo');
        $this->db->having('avg(Ocena) >= 4');
        $this->db->order_by('rand()');
        
        return $this->db->get()->row();
    }
    
    /**
     * Dohvata random recenziju koja ima ocenu >= 4 za zadato jelo iz baze
     * 
     * @param int $idJelo
     * 
     * @return void 
     */
    public function dohvatiTopRecenziju($idJelo) {
        $this->db->select('*');
        $this->db->from('recenzija');
        $this->db->where('IdJelo', $idJelo);
        $this->db->where('Ocena >= 4');
        $this->db->where('Pregledano', 'P');
        $this->db->order_by('rand()');

        return $this->db->get()->row();
    }
    
    /**
     * Funkcija za dohvatanje najbolje ocene nekog jela
     * 
     * @param type $idJelo ID jela ciju najbolju ocenu trazimo.
     * @return stdClass Vraca objekat sa poljem topOcena
     * Ukoliko ne postoji ni jedna pregledana recenzija, vraca se null
     */
    public function dohvatiTopOcenu($idJelo) {
        $this->db->select('max(Ocena) as topOcena');
        $this->db->from('recenzija');
        $this->db->where('IdJelo', $idJelo);
        $this->db->where('Pregledano', 'P');
        
        return $this->db->get()->row();
    }
}
