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
    
    public function azuriranjeGrada($promenljive, $idGrad){
        $this->db->set('Naziv', $promenljive['gradrestorana']);
        $this->db->where('IdGrad', $idGrad);
        $this->db->update('Grad');
        
        $this->db->select('IdDrzava');
        $this->db->from('grad');
        $this->db->where('IdGrad', $idGrad);
        $idDrzava = $this->db->get()->row()->IdDrzava;
        
        $this->M_Drzava->azuriranjeDrzave($promenljive, $idDrzava);
    }
    
    //input: idGrada ciji naziv zelimo
    //output: Naziv grada ciji smo idGrada prosledili
    public function dohvatiNazivGrada($idGrad) {
        $this->db->select('Naziv');
        $this->db->from('Grad');
        $this->db->where('IdGrad', $idGrad);
        
        return $this->db->get()->row();
    }
}
