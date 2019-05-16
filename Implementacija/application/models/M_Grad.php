<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Grad
 *
 * @author Lazar
 */
class M_Grad extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    public function gohvatiSveGradove() {
        $this->db->select('*');
        $this->db->from('grad');
        
        return $this->db->get()->result();
    }
}
