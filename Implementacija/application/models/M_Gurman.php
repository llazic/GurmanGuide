<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Gurman
 *
 * @author Lazar Lazic
 * @author Nenad Babin 0585/2016
 * @vesrion 1.0
 */
class M_Gurman extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Dohvata informacije o Gurmanu sa zadatim ID iz baze
     * 
     * @param int $id -> idGurman
     * 
     * @return stdClass 
     */
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
    
    /**
     * Azurira Gurmana sa zadatim ID zadatim informacijama
     * 
     * @param associative array $info
     * 
     * @return void 
     */
    public function azuriranjeGurmana($info){
        $this->db->set('Lozinka', $info['sifra']);
        $this->db->where('IdKorisnik', $info['id']);
        $this->db->update('Korisnik');
        
        $this->db->set('Ime', $info['ime']);
        $this->db->set('Prezime', $info['prezime']);
        $this->db->set('Pol', $info['pol']);
        if (isset($info['idSlika'])){
            $this->db->set('IdSlika', $info['idSlika']);
        }
        $this->db->where('IdKorisnik', $info['id']);
        $this->db->update('Gurman');
    }
    
    /**
     * Azurira ID slike Gurmanu sa zadatim ID
     * 
     * @param int $idGurman
     * @param int $idSlika
     * 
     * @return void
     */
    public function promeniSlikuGurmanu($idGurman, $idSlika){
        $this->db->set('IdSlika', $idSlika);
        $this->db->where('IdKorisnik', $idGurman);
        $this->db->update('Gurman');
    }
    /**
     * Funckija za proveru korisnickog imena gurmana.
     * 
     * @param string $korime
     * @return stdClass Vraca objekat sa poljima IdKorisnik, KorisnickoIme, Lozinka, Email
     * Ime, Prezime, Pol, IdSlika ukoliko korisnicko ime postoji, inace vraca null.
     */
    public function proveraKorImena($korime) {
        $this->db->select('*');
        $this->db->from('korisnik, gurman');
        $this->db->where('korisnik.IdKorisnik = gurman.IdKorisnik');
        $this->db->where('korisnik.KorisnickoIme', $korime);
        
        return $this->db->get()->result();
    }
    
    /**
     * Funckija za proveru sifre korisnika.
     * 
     * @param string $korime Korisnicko ime korisnika
     * @param string $sifra Sifra korisnika
     * @return stdClass Vraca objekat sa poljima IdKorisnik, KorisnickoIme, Lozinka, Email
     * Ime, Prezime, Pol, IdSlika ukoliko sifra odgovara korisnickom imenu, inace vraca null.
     */
    public function proveraSifre($korime, $sifra) {
        $this->db->select('*');
        $this->db->from('korisnik, gurman');
        $this->db->where('korisnik.IdKorisnik = gurman.IdKorisnik');
        $this->db->where('korisnik.KorisnickoIme', $korime);
        $this->db->where('korisnik.Lozinka', $sifra);
        
        return $this->db->get()->row();
    }
    
    /**
     * Dohvata poslednji ID u tabeli korisnik
     * 
     * @return stdClass Objekat sa poljem poslednjiId
     */
    public function poslednjiId() {
        $this->db->select('max(korisnik.IdKorisnik) as poslednjiId');
        $this->db->from('korisnik');
        
        return $this->db->get()->row();
    }
    
    /**
     * Funkcija za evidentiranje gurmana u bazi.
     * 
     * @param stdClass $gurman Asocijativni niz sa kljucevima IdKorisnik, KorisnickoIme, Lozinka, Email
     * Ime, Prezime, Pol, IdSlika i odgovarajucim vrednostima.
     */
    public function unesiGurmana($gurman) {
        $podaciKorisnik = array(
            'IdKorisnik' => $gurman->IdKorisnik,
            'KorisnickoIme' => $gurman->KorisnickoIme,
            'Lozinka' => $gurman->Lozinka,
            'Email' => $gurman->Email
        );

        $this->db->insert('korisnik', $podaciKorisnik);
        
        $podaciGurman = array(
            'IdKorisnik' => $gurman->IdKorisnik,
            'Ime' => $gurman->Ime,
            'Prezime' => $gurman->Prezime,
            'Pol' => $gurman->Pol,
            'IdSlika' => $gurman->IdSlika
        );

        $this->db->insert('gurman', $podaciGurman);
    }
    
}
