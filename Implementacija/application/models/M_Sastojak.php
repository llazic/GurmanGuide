<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Sastojak
 *
 * @author Lazar
 */
class M_Sastojak extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    //paramertar funkcije je id jela
    public function dohvatiSastojkeJela($id) {
        $this->db->select('s.IdSastojak as Id, s.Naziv as Naziv');
        $this->db->from('ima_sastojak is, sastojak s');
        $this->db->where('is.IdSastojak = s.IdSastojak');
        $this->db->where('is.IdJelo', $id);
        
        return $this->db->get()->result();
    }
    
    public function poslednjiId() {
        $this->db->select('max(sastojak.IdSastojak) as poslednjiId');
        $this->db->from('sastojak');
        
        return $this->db->get()->row();
    }
    
    //input: naziv sastojka
    //outpul: jela
    public function dohvatiJelaZaSastojak($sastojak) {
        $this->db->select('j.Naziv as Naziv, j.Opis as Opis, j.IdJelo as IdJelo, j.IdKorisnik as IdKorisnik, j.IdSlika as IdSlika');
        $this->db->from('sastojak s, ima_sastojak is, jelo j');
        $this->db->like('s.Naziv', $sastojak);
        $this->db->where('s.IdSastojak = is.IdSastojak');
        $this->db->where('is.IdJelo = j.IdJelo');
        $this->db->where('j.Pregledano', 'P');
        $this->db->group_by('j.Naziv, j.Opis, j.IdJelo, j.IdKorisnik,, j.IdSlika');
        
        return $this->db->get()->result();
    }
    
    public function postojiSastojak($imeSastojka){
        
        $this->db->select('IdSastojak');
        $this->db->from('sastojak');
        $this->db->where('Naziv', $imeSastojka);
        
        return $this->db->get()->row();
    }
    
    public function dodajSastojak($imeSastojka){
        $poslednjiId = $this->M_Sastojak->poslednjiId()->poslednjiId;
        $idSastojka = $poslednjiId + 1;
                
        $this->db->set('IdSastojak', $idSastojka);
        $this->db->set('Naziv', $imeSastojka);
        $this->db->insert('sastojak');
        
        return $idSastojka;
    }
    
}
