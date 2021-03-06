<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Grad
 *
 * @author Nenad Babin 0585/2016
 * @author Dunja Culafic 0236/2016
 * @version 1.0
 */
class M_Grad extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Funkcija za dohvatanje svih gradova iz baze
     * 
     * @return stdClass
     * Vraca objekte sa poljima idDrzava, IdGrad, Naziv
     */
    public function gohvatiSveGradove() {
        $this->db->select('*');
        $this->db->from('grad');
        
        return $this->db->get()->result();
    }
    
    /**
     *Funkcija koja sluzi za izmenu profila restorana (menja se grad restorana), poziva se iz modela M_Restoran, a iz nje se dalje poziva funkcija iz modela M_Drzava (kako bi se nastavilo sa izmenama profila)
     * 
     * @param type $promenljive Asocijativni niz sa poljima lozinkarestoran, id, imerestorana, adresarestorana, radnovreme,
     * telefon, idSlika, gradrestorana i drzavarestorana
     * @param int $idGrad
     * 
     * @return void
     */
    
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
    
    /**
     * Funkcija za dohvatanje naziva grada
     * 
     * @param type $idGrad ID grada ciji naziv zelimo.
     * @return stdClass objekat sa poljem Naziv
     */
    public function dohvatiNazivGrada($idGrad) {
        $this->db->select('Naziv');
        $this->db->from('Grad');
        $this->db->where('IdGrad', $idGrad);
        
        return $this->db->get()->row();
    }
}
