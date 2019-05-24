<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Recenzija
 *
 * @author Lazar
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
            $this->db->where('Ocena', $topOcena);

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

    public function dohvatiRecenziju($idKorisnik, $idJelo){
        $this->db->from('recenzija');
        $this->db->where('IdKorisnik', $idKorisnik);
        $this->db->where('IdJelo', $idJelo);

        return $this->db->get()->row();
    }

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

    //dohvata samo pregledane recenzije
    //dohvata i jela i slike jela koje je gurman ocenio
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

    public function dohvatiNepregledaneRecenzije() {
            return   $this->db->select("*")->from('recenzija')->where('Pregledano', 'N')->result();
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

    //input: jelo ciju recenziju zelimo
    //output: bilo koja recenzija unetog jela koja ima ocenu vecu ili jednaku sa 4
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
