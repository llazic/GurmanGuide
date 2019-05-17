<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Slika
 *
 * @author Lazar
 */
class M_Slika extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    public function poslednjiId() {
        $this->db->select('max(slika.IdSlika) as poslednjiId');
        $this->db->from('slika');
        
        return $this->db->get()->row();
    }
    
    public function unesiSliku($slika) {
        $podaciSlika = array(
            'IdSlika' => $slika->IdSlika,
            'Putanja' => $slika->Putanja
        );

        $this->db->insert('slika', $podaciSlika);
    }
    
    public function dohvatiPutanju($id) {
        $this->db->select('Putanja');
        $this->db->from('slika');
        $this->db->where('IdSlika', $id);
        
        return $this->db->get()->row();
    }
    
}
