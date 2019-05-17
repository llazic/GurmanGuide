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
    
}
