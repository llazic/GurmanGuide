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
    
    public function azuriranjeGurmana($info){
        $this->db->set('Lozinka', $info['sifra']);
        $this->db->where('IdKorisnik', $info['id']);
        $this->db->update('Korisnik');
        
        $this->db->set('Ime', $info['ime']);
        $this->db->set('Prezime', $info['prezime']);
        $this->db->set('Pol', $info['pol']);
        $this->db->where('IdKorisnik', $info['id']);
        $this->db->update('Gurman');
        
//        za slike
//        $gurman = $this->dohvatiGurmana($info['id']);
//        
//        $this->db->set('Putanja', $info['slika']);        
//        $this->db->where('IdSlika', $gurman->IdSlika);
//        $this->db->update('Slika');
    }
    
    public function proveraKorImena($korime) {
        $this->db->select('*');
        $this->db->from('korisnik, gurman');
        $this->db->where('korisnik.IdKorisnik = gurman.IdKorisnik');
        $this->db->where('korisnik.KorisnickoIme', $korime);
        
        return $this->db->get()->result();
    }
    
    public function proveraSifre($korime, $sifra) {
        $this->db->select('*');
        $this->db->from('korisnik, gurman');
        $this->db->where('korisnik.IdKorisnik = gurman.IdKorisnik');
        $this->db->where('korisnik.KorisnickoIme', $korime);
        $this->db->where('korisnik.Lozinka', $sifra);
        
        return $this->db->get()->row();
    }
    
    public function poslednjiId() {
        $this->db->select('max(korisnik.IdKorisnik) as poslednjiId');
        $this->db->from('korisnik');
        
        return $this->db->get()->row();
    }
    
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
