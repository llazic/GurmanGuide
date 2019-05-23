<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Restoran
 *
 * @author Lazar
 */
class M_Restoran extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    public function proveraKorImena($korime) {
        $this->db->select('*');
        $this->db->from('korisnik, restoran');
        $this->db->where('korisnik.IdKorisnik = restoran.IdKorisnik');
        $this->db->where('korisnik.KorisnickoIme', $korime);
        
        return $this->db->get()->row();
    }
    
    public function proveraSifre($korime, $sifra) {
        $this->db->select('*');
        $this->db->from('korisnik, restoran');
        $this->db->where('korisnik.IdKorisnik = restoran.IdKorisnik');
        $this->db->where('korisnik.KorisnickoIme', $korime);
        $this->db->where('korisnik.Lozinka', $sifra);
        
        return $this->db->get()->row();
    }
    
    
    public function azuriranjeRestorana($promenljive){
        
        $this->db->set('Lozinka', $promenljive['lozinkarestoran']);
        $this->db->where('IdKorisnik', $promenljive['id']);
        $this->db->update('Korisnik');
        
        $this->db->set('Naziv', $promenljive['imerestorana']);
        $this->db->set('Adresa', $promenljive['adresarestorana']);
        $this->db->set('RadnoVreme', $promenljive['radnovreme']);
        $this->db->set('Telefon', $promenljive['telefon']);
        $this->db->where('IdKorisnik', $promenljive['id']);
        $this->db->update('Restoran');
        
        $this->db->select('IdGrad');
        $this->db->from('restoran');
        $this->db->where('IdKorisnik', $promenljive['id']);
        $idGrad = $this->db->get()->row()->IdGrad;
        
        $this->M_Grad->azuriranjeGrada($promenljive, $idGrad);

    }
    
    public function dohvatiRestoran($id){
        
        $query = $this->db->query("SELECT restoran.Naziv as imeRestorana, restoran.Telefon as brTelefona, restoran.Adresa as adresaRestorana, grad.Naziv as gradRestorana, drzava.Naziv as drzavaRestorana, korisnik.KorisnickoIme as korime, korisnik.Lozinka as lozinka, korisnik.Email as email, restoran.IdKorisnik as id, restoran.RadnoVreme as radnoVreme  "
                . "FROM restoran, grad, drzava, korisnik "
                . "WHERE restoran.IdGrad = grad.IdGrad AND grad.IdDrzava = drzava.IdDrzava "
                . "AND restoran.IdKorisnik = korisnik.IdKorisnik AND restoran.IdKorisnik = ". $id." ");
        
        return $query->row();
        //$this->db->from('restoran');
        
        
        
        
        
//        $this->db->select('IdKorisnik as id, Telefon as brTelefona, Naziv as imeRestorana, Adresa as adresaRestorana, RadnoVreme as radnoVreme, IdGrad as IdGrad');
//        $this->db->from('restoran');
//        $this->db->where('IdKorisnik', $id);
//        
//        $restoran = $this->db->get()->row();
//
//        if ($restoran != null){
//            $this->db->from('grad');
//            $this->db->where('IdGrad', $restoran->IdGrad);
//            
//            $korisnik = $this->db->get()->row();
//            $restoran->gradRestorana = $korisnik->Naziv;
//            $restoran->IdDrzava = $korisnik->IdDrzava;
//            
//            if ($korisnik != null){
//                $this->db->from('drzava');
//                $this->db->where('IdDrzava', $restoran->IdDrzava);
//            
//                $korisnik2 = $this->db->get()->row();
//                $restoran->drzavaRestorana = $korisnik2->Naziv;
//                    
//                if ($korisnik2 != null){
//                    $this->db->select('KorisnickoIme as korime, Lozinka as lozinka, Email as email');
//                    $this->db->from('korisnik');
//                    $this->db->where('IdKorisnik', $restoran->id);
//                    
//                    $korisnik3 = $this->db->get()->row();
//                    
//                    $restoran->korime = $korisnik3->korime;
//                    $restoran->lozinka = $korisnik3->lozinka;
//                    $restoran->email = $korisnik3->email;
//                    
//                    return $restoran;
//                } else {
//                    return null;
//                }
//            } else {
//                return null;
//            }
//        } else {
//            //ako postoji korisnik sa tim ID-jem ali nije gurman, vraca null
//            return null;
//        }
    }
    
    public function poslednjiId() {
        $this->db->select('max(korisnik.IdKorisnik) as poslednjiId');
        $this->db->from('korisnik');
        
        return $this->db->get()->row();
    }
    
    public function unesiRestoran($restoran) {
        $podaciKorisnik = array(
            'IdKorisnik' => $restoran->IdKorisnik,
            'KorisnickoIme' => $restoran->KorisnickoIme,
            'Lozinka' => $restoran->Lozinka,
            'Email' => $restoran->Email
        );

        $this->db->insert('korisnik', $podaciKorisnik);
        
        $podaciRestoran = array(
            'IdKorisnik' => $restoran->IdKorisnik,
            'Telefon' => $restoran->Telefon,
            'Naziv' => $restoran->Naziv,
            'Adresa' => $restoran->Adresa,
            'IdGrad' => $restoran->IdGrad,
            'RadnoVreme' => $restoran->RadnoVreme,
            'IdSlika' => $restoran->IdSlika,
            'Pregledano' => $restoran->Pregledano
        );

        $this->db->insert('restoran', $podaciRestoran);
    }
    
    //input: naziv restorana
    //output: jela tog restorana
    public function dohvatiJelaRestorana($pattern) {
        $this->db->select('j.Naziv as Naziv, j.Opis as Opis, j.IdJelo as IdJelo, j.IdKorisnik as IdKorisnik, j.IdSlika as IdSlika');
        $this->db->from('restoran r, jelo j');
        $this->db->like('r.Naziv', $pattern);
        $this->db->where('r.IdKorisnik = j.IdKorisnik');
        $this->db->where('j.Pregledano', 'P');
        $this->db->where('r.Pregledano', 'P');
        
        return $this->db->get()->result();
    }
    
}
