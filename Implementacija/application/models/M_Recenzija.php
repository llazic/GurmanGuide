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
    
    //input parametar: idJela
    public function dohvatiJednuRecenziju($id) {
        $this->db->select("*");
        $this->db->from('recenzija');
        $this->db->where('IdJelo', $id);
        
        return $this->db->get()->row();
    }
    
    //dohvata samo pregledane recenzije
    //dohvata i jela i slike jela koje je gurman ocenio
    public function dohvatiRecenzijeGurmana($idGurman){
//        $this->db->from('recenzija');
//        $this->db->where('IdKorisnik', $idGurman);
//        $this->db->where('Pregledano', 'P');
//        
//        $recenzije = $this->db->get()->result();
        
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
}
