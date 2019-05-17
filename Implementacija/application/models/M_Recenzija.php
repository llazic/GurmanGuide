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
}
