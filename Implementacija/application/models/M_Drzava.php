<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Drzava
 *
 * @author Dunja
 */
class M_Drzava extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    /**
     *Funkcija koja sluzi za izmenu profila restorana (menja se drzava restorana), poziva se iz modela M_Grad
     * 
     * @param type $promenljive Asocijativni niz sa poljima lozinkarestoran, id, imerestorana, adresarestorana, radnovreme,
     * telefon, idSlika, gradrestorana i drzavarestorana
     * @param int $idDrzava
     * 
     * @return void
     */
    
    public function azuriranjeDrzave($promenljive, $idDrzava){
        $this->db->set('Naziv', $promenljive['drzavarestorana']);
        $this->db->where('IdDrzava', $idDrzava);
        $this->db->update('Drzava');
        
    }
    
}
