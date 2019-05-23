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
}
