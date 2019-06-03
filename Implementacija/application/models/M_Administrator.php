<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Administrator
 * 
 * @author Nenad Babin 0585/2016
 * @version 1.0
 */
class M_Administrator extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
	 /**
     * Funckija za proveru korisnickog imena administratora.
     * 
     * @param string $korime
     * @return stdClass Vraca objekat sa poljima IdKorisnik, KorisnickoIme, Lozinka, Email
     * Ime, Prezime, Pol, IdSlika ukoliko korisnicko ime postoji, inace vraca null.
     */
    public function proveraKorImena($korime) {
        $this->db->select('*');
        $this->db->from('korisnik, administrator');
        $this->db->where('korisnik.IdKorisnik = administrator.IdKorisnik');
        $this->db->where('korisnik.KorisnickoIme', $korime);
        
        return $this->db->get()->row();
    }
	
	/**
     * Funckija za proveru sifre administratora.
     * 
     * @param string $korime Korisnicko ime administratora
     * @param string $sifra Sifra administratora
     * @return stdClass Vraca objekat sa poljima IdKorisnik, KorisnickoIme, Lozinka, Email
     * Ime, Prezime, Pol, IdSlika ukoliko sifra odgovara korisnickom imenu, inace vraca null.
     */
    
    public function proveraSifre($korime, $sifra) {
        $this->db->select('*');
        $this->db->from('korisnik, administrator');
        $this->db->where('korisnik.IdKorisnik = administrator.IdKorisnik');
        $this->db->where('korisnik.KorisnickoIme', $korime);
        $this->db->where('korisnik.Lozinka', $sifra);
        
        return $this->db->get()->row();
    }
    
}
