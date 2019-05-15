<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Gurman
 *
 * @author Lazar
 */
class M_Gurman extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    public function dohvatiGurmana($id){
        $this->db->from('gurman');
        $this->db->where('IdKorisnik', $id);
        
        $gurman = $this->db->get()->row();
        if ($gurman != null){
            $this->db->from('korisnik');
            $this->db->where('IdKorisnik', $id);

            $korisnik = $this->db->get()->row();

            $gurman->KorisnickoIme = $korisnik->KorisnickoIme;
            $gurman->Lozinka = $korisnik->Lozinka;
            $gurman->Email = $korisnik->Email;

            return $gurman;
        } else {
            //ako postoji korisnik sa tim ID-jem ali nije gurman, vraca null
            return null;
        }
    }
}
