<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Jelo
 *
 * @author Lazar
 */
class M_Jelo extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    public function dohvatiJelaPoNazivu($pattern) {
        $this->db->select('*');
        $this->db->from('jelo');
        $this->db->like('Naziv', $pattern);
        $this->db->where('Pregledano', 'P');
        
        return $this->db->get()->result();
    }

    
    public function poslednjiId() {
        $this->db->select('max(jelo.IdJelo) as poslednjiId');
        $this->db->from('jelo');
        
        return $this->db->get()->row();
    }
    

    public function dodajNemaSastojka($uneto, $ime){
                    $poslednjiId = $this->M_Sastojak->poslednjiId()->poslednjiId;
                    $uneto['idSastojka'] = $poslednjiId + 1;    
                
                    $this->db->set('IdSastojak', $uneto['idSastojka']);
                    $this->db->set('Naziv', $ime);
                    $this->db->insert('sastojak');
                    
                    $this->db->set('IdJelo', $uneto['idJela']);
                    $this->db->set('IdKorisnik', $uneto['idKorisnik']);
                    $this->db->set('Naziv', $uneto['naziv']);
                    $this->db->set('Opis', $uneto['opisjela']);
                    $this->db->set('Pregledano', 'N');
                    $this->db->set('IdSlika', 3);
                    $this->db->insert('jelo');
                    
                    
                    $this->db->set('IdJelo', $uneto['idJela']);
                    $this->db->set('IdSastojak', $uneto['idSastojka']);
                    $this->db->insert('ima_sastojak');
    }

    public function dohvatiJelo($idJelo){
        $this->db->from('jelo');
        $this->db->where('IdJelo', $idJelo);
        
        return $this->db->get()->row();
    }
    

}
