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
    
    public function dohvatiJelo($idJelo){
        $this->db->from('jelo');
        $this->db->where('IdJelo', $idJelo);
        
        return $this->db->get()->row();
    }
    
}
