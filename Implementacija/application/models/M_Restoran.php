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
 * @author Nenad Babin 0585/2016
 * @author Dunja Culafic 0236/2016
 */
class M_Restoran extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Funckija za proveru korisnickog imena restorana.
     * 
     * @param type $korime
     * @return stdClass Vraca objekat sa poljima IdKorisnik, KorisnickoIme, Lozinka, Email,
     * Telefon, Naziv, Adresa, IdGrad, IdSlika, RadnoVreme, Pregledano ukoliko korisnicko ime postoji, inace vraca null.
     */
    public function proveraKorImena($korime) {
        $this->db->select('*');
        $this->db->from('korisnik, restoran');
        $this->db->where('korisnik.IdKorisnik = restoran.IdKorisnik');
        $this->db->where('korisnik.KorisnickoIme', $korime);
        
        return $this->db->get()->row();
    }
    
    public function dohvatiIme($id) {
        return $this->db->select('Naziv')->from('restoran')->where('IdKorisnik', $id)->get()->row();
    }
    
    /**
     * Funckija za proveru sifre korisnika.
     * 
     * @param type $korime Korisnicko ime korisnika
     * @param type $sifra Sifra korisnika
     * @return stdClass Vraca objekat sa poljima IdKorisnik, KorisnickoIme, Lozinka, Email,
     * Telefon, Naziv, Adresa, IdGrad, IdSlika, RadnoVreme, Pregledano ukoliko korisnicko ime postoji, inace vraca null.
     */
    public function proveraSifre($korime, $sifra) {
        $this->db->select('*');
        $this->db->from('korisnik, restoran');
        $this->db->where('korisnik.IdKorisnik = restoran.IdKorisnik');
        $this->db->where('korisnik.KorisnickoIme', $korime);
        $this->db->where('korisnik.Lozinka', $sifra);
        
        return $this->db->get()->row();
    }
    
    /**
     * Funkcija koja sluzi za izmenu profila restorana, iz nje se dalje poziva funkcija iz modela M_Grad (kako bi se nastavilo sa izmenama profila)
     * 
     * @param type $promenljive Asocijativni niz sa poljima lozinkarestoran, id, imerestorana, adresarestorana, radnovreme,
     * telefon, idSlika, gradrestorana i drzavarestorana
     * 
     * @return void
     */
    
    public function azuriranjeRestorana($promenljive){
        
        $this->db->set('Lozinka', $promenljive['lozinkarestoran']);
        $this->db->where('IdKorisnik', $promenljive['id']);
        $this->db->update('Korisnik');
        
        $this->db->set('Naziv', $promenljive['imerestorana']);
        $this->db->set('Adresa', $promenljive['adresarestorana']);
        $this->db->set('RadnoVreme', $promenljive['radnovreme']);
        $this->db->set('Telefon', $promenljive['telefon']);
        $this->db->set('Pregledano', 'N');
        if (isset($promenljive['idSlika'])){
            $this->db->set('IdSlika', $promenljive['idSlika']);
        }
        $this->db->where('IdKorisnik', $promenljive['id']);
        $this->db->update('Restoran');
        
        $this->db->select('IdGrad');
        $this->db->from('restoran');
        $this->db->where('IdKorisnik', $promenljive['id']);
        $idGrad = $this->db->get()->row()->IdGrad;
        
        $this->M_Grad->azuriranjeGrada($promenljive, $idGrad);

    }
    
    /**
     * Funkcija sluzi da vrati sve neophodne informacije o restoranu za dati id
     * 
     * @param int $id
     * @return stdClass Objekti sa poljima imeRestorana, brTelefona, adresaRestorana, gradRestorana, 
     * drzavaRestorana, korime, lozinka, email, id, radnoVreme, IdSlika -ukoliko postoji takav restoran, inace vraca null.
     */
    
    public function dohvatiRestoran($id){
        
        $query = $this->db->query("SELECT restoran.Naziv as imeRestorana, restoran.Telefon as brTelefona, restoran.Adresa as adresaRestorana, grad.Naziv as gradRestorana, drzava.Naziv as drzavaRestorana, korisnik.KorisnickoIme as korime, korisnik.Lozinka as lozinka, korisnik.Email as email, restoran.IdKorisnik as id, restoran.RadnoVreme as radnoVreme, restoran.IdSlika as IdSlika  "
                . "FROM restoran, grad, drzava, korisnik "
                . "WHERE restoran.IdGrad = grad.IdGrad AND grad.IdDrzava = drzava.IdDrzava "
                . "AND restoran.IdKorisnik = korisnik.IdKorisnik AND restoran.IdKorisnik = ". $id." ");
        
        return $query->row();
    }
    
    /**
     * Funkcija koja sluzi da restoranu sa datim id-ijem promeni sliku
     * 
     * @param int $idRestoran
     * @param int $idSlika
     * 
     * @return null
     */
    
    public function promeniSlikuRestoranu($idRestoran, $idSlika){
        $this->db->set('IdSlika', $idSlika);
        $this->db->where('IdKorisnik', $idRestoran);
        $this->db->update('Restoran');
    }
    
    public function dohvatiNepregledaneRegistracije(){
        
        $query = $this->db->query("SELECT restoran.Naziv as imeRestorana, restoran.Telefon as brTelefona, restoran.Adresa as adresaRestorana, grad.Naziv as gradRestorana, drzava.Naziv as drzavaRestorana,  restoran.IdKorisnik as id, restoran.RadnoVreme as radnoVreme "
                . "FROM restoran, grad, drzava "
                . "WHERE restoran.IdGrad = grad.IdGrad AND grad.IdDrzava = drzava.IdDrzava AND restoran.Pregledano='N' ");
        
        return $query->result();
       
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
     * Funkcija za evidentiranje restorana u bazi.
     * 
     * @param type $restoran Asocijativni niz sa kljucevima IdKorisnik, KorisnickoIme, Lozinka, Email,
     * Telefon, Naziv, Adresa, IdGrad, IdSlika, RadnoVreme, Pregledano i odgovarajucim vrednostima.
     */
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
    
    /**
     * Dohvata sva pregledana jela svih pregledanih restorana cije ime odgovra ulaznom parametru. Funkcija ne uzima u obzir 
     * samo istoimene restorane, vec i restorane koja u svom nazivu imaju prosledjeni parametar.
     * 
     * @param type $pattern
     * @return stdClass Objekti sa poljima Naziv, Opis, IdJelo, IdKorisnik, IdSlika ukoliko postoji takav restoran i
     * jela u njemu, inace vraca null.
     */
    public function dohvatiJelaRestorana($pattern) {
        $this->db->select('j.Naziv as Naziv, j.Opis as Opis, j.IdJelo as IdJelo, j.IdKorisnik as IdKorisnik, j.IdSlika as IdSlika');
        $this->db->from('restoran r, jelo j');
        $this->db->like('r.Naziv', $pattern);
        $this->db->where('r.IdKorisnik = j.IdKorisnik');
        $this->db->where('j.Pregledano', 'P');
        $this->db->where('r.Pregledano', 'P');
        
        return $this->db->get()->result();
    }
    
    /**
     * Funkcija sluzi da sortira jela restorana ciji je id prosledjen, po oceni koju imaju, od najbolje ocenjenog do najgore ocenjenog
     * 
     * @param int $idRestorana
     * @return stdClass Objekti sa poljima Naziv, Opis, IdJelo, IdKorisnik, IdSlika, Ocena sortiranih po Ocena (opadajuce),
     * u slucaju da ne postoje podaci koji zadovoljavaju zahteve upita, vraca null
     * 
     */
    
    public function dohvatiTopTriJelaRestorana($idRestorana){
        $query = $this->db->query("SELECT j.Naziv as Naziv, j.Opis as Opis, j.IdJelo as IdJelo, j.IdKorisnik as IdKorisnik, j.IdSlika as IdSlika, sum(r.Ocena)/count(r.Ocena) as Ocena "
                                . "FROM jelo j, recenzija r "
                                . "WHERE j.IdKorisnik = ".$idRestorana." "
                                . "AND j.Pregledano = 'P' "
                                . "AND j.IdJelo = r.IdJelo "
                                . "GROUP BY Naziv, Opis, IdJelo, IdKorisnik, IdSlika "
                                . "ORDER BY Ocena DESC");
        return $query->result();
    
    }
    
    /**
     * Dohvata sva jela restorana koji ima prosledjeni ID
     * 
     * @param type $id
     * @return stdClass Objekti sa poljima Naziv, Opis, IdJelo, IdKorisnik, IdSlika ukoliko postoji restoran sa
     * prosledjenim ID-jem, inace vraca null.
     */
    public function dohvatiJelaRestoranaId($id) {
        $this->db->select('j.Naziv as Naziv, j.Opis as Opis, j.IdJelo as IdJelo, j.IdKorisnik as IdKorisnik, j.IdSlika as IdSlika');
        $this->db->from('restoran r, jelo j');
        $this->db->where('r.IdKorisnik', $id);
        $this->db->where('r.IdKorisnik = j.IdKorisnik');
        $this->db->where('j.Pregledano', 'P');
        $this->db->where('r.Pregledano', 'P');
        
        return $this->db->get()->result();
    }

    /**
     * Dohvata sve restorane cije ime odgovara ulaznom parametru. Funkcija ne dohvata 
     * samo istoimene restorane, vec i restorane koja u svom nazivu imaju prosledjeni parametar.
     * 
     * @param type $pattern
     * @return stdClass Vraca objekte sa poljima IdKorisnik,
     * Telefon, Naziv, Adresa, IdGrad, IdSlika, RadnoVreme, Pregledano ukoliko takvi restorani postoje, inace vraca null.
     */
    public function dohvatiRestoranePoNazivu($pattern) {
        $this->db->select('*');
        $this->db->from('restoran');
        $this->db->like('Naziv', $pattern);
        $this->db->where('Pregledano', 'P');
        
        return $this->db->get()->result();
    }
    
    /**
     * Dohvata sve restorane cija adresa odgovara ulaznom parametru. Funkcija ne dohvata 
     * samo istoimene adrese, vec i adrese koja u svom nazivu imaju prosledjeni parametar.
     * 
     * @param type $pattern
     * @return stdClass Vraca objekte sa poljima IdKorisnik,
     * Telefon, Naziv, Adresa, IdGrad, IdSlika, RadnoVreme, Pregledano ukoliko takvi restorani postoje, inace vraca null.
     */
    public function dohvatiRestoranePoAdresi($pattern) {
        $this->db->select('*');
        $this->db->from('restoran');
        $this->db->like('Adresa', $pattern);
        $this->db->where('Pregledano', 'P');
        
        return $this->db->get()->result();
    }
    
     public function postaviPregledano($id) {
        $this->db->set('Pregledano', 'P');
        $this->db->where('IdKorisnik', $id);
        $this->db->update('restoran');
    }
    public function obrisiRegistraciju($id){
        $this->db->where('IdKorisnik', $id);
        $this->db->delete('restoran');
    }
    
}
