<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Drzava
 *
 * @author Lazar
 */
class M_Drzava extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    public function azuriranjeDrzave($promenljive, $idDrzava){
        $this->db->set('Naziv', $promenljive['drzavarestorana']);
        $this->db->where('IdDrzava', $idDrzava);
        $this->db->update('Drzava');
        
    }
    
}
