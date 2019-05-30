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
    
    /**
     * Dohvata sve sastojke jela ciji ID se prosledi kao parametar funkcije.
     * 
     * @param type $id ID jela
     * @return stdClass Povratna vrednost su objekti koji imaju polja Id i Naziv. Ukoliko jelo nema sastojke, vraca se null.
     */
    public function dohvatiSastojkeJela($id) {
        $this->db->select('s.IdSastojak as Id, s.Naziv as Naziv');
        $this->db->from('ima_sastojak is, sastojak s');
        $this->db->where('is.IdSastojak = s.IdSastojak');
        $this->db->where('is.IdJelo', $id);
        
        return $this->db->get()->result();
    }
    
    /**
     * Dohvata poslednji ID iz table sastojak.
     * 
     * @return stdClass Povratna vrednost je objekat koji ima polje poslednjiId.
     */
    public function poslednjiId() {
        $this->db->select('max(sastojak.IdSastojak) as poslednjiId');
        $this->db->from('sastojak');
        
        return $this->db->get()->row();
    }
    
   /**
    * Dohvata sva pregledana jela koja imaju sastojak cije ime se prosjedjuje kao parametar funckije. 
    * 
    * @param type $sastojak Ime sastojka
    * @return stdClass Objekti sa poljima Naziv, Opis, IdJelo, IdKorisnik, IdSlika. Ukoliko za zadati sastojak ne postoji jelo,
    * vraca se null.
    */
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
    
    /**
     * Funkcija sluzi kako bi se proverilo da li u bazi vec postoji sacuvan sastojak sa datim imenom ili ne
     * 
     * @param string $imeSastojka
     * 
     * @return stdClass Objekti sa poljem IdSastojak - ukoliko sastojak sa datim imenom postoji, u suprotnom vraca null
     */
    
    public function postojiSastojak($imeSastojka){
        
        $this->db->select('IdSastojak');
        $this->db->from('sastojak');
        $this->db->where('Naziv', $imeSastojka);
        
        return $this->db->get()->row();
    }
    
    /**
     * Funkcija sluzi kako bi se dodao u bazu sastojak sa datim imenom
     * 
     * @param string $imeSastojka
     * 
     * @return int $idSastojka
     */
    
    public function dodajSastojak($imeSastojka){
        $poslednjiId = $this->M_Sastojak->poslednjiId()->poslednjiId;
        $idSastojka = $poslednjiId + 1;
                
        $this->db->set('IdSastojak', $idSastojka);
        $this->db->set('Naziv', $imeSastojka);
        $this->db->insert('sastojak');
        
        return $idSastojka;
    }
    
    public function proveraPovezani($imeSastojka, $idJela){
        $this->db->from('ima_sastojak i, sastojak s');
        $this->db->where('s.Naziv', $imeSastojka);
        $this->db->where('s.IdSastojak = i.IdSastojak');
        $this->db->where('i.IdJelo', $idJela);
        
        return $this->db->get->row();
    }
    
}
