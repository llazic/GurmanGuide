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
    
    
    public function proveriIzmene($restoran){
        $lozinka = $this->input->post('lozinkarestoran');
        $potvrdalozinke = $this->input->post('potvrdalozinke');
        $telefon = $this->input->post('telefon');
        $ime = $this->input->post('imerestorana');
        $adresa = $this->input->post('adresarestorana');
        $grad = $this->input->post('gradrestorana');
        $drzava = $this->input->post('drzavarestorana');
        
        /*
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "psibaza";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
             die("Connection failed: " . $conn->connect_error);
        } 

        if ($telefon != $restoran->brTelefona){
            $sql = "UPDATE restoran SET Telefon=".$telefon." WHERE id=2".$restoran->id." ";
        }
       // $sql = "UPDATE restoran SET lastname='Doe' WHERE id=".$restoran->id." ";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }

        $conn->close();
        if ($telefon != $restoran->brTelefona){
            
        }*/
    }
    
    public function dohvatiRestoran($id){
        
        $query = $this->db->query("SELECT restoran.Naziv as imeRestorana, restoran.Telefon as brTelefona, restoran.Adresa as adresaRestorana, grad.Naziv as gradRestorana, drzava.Naziv as drzavaRestorana, korisnik.KorisnickoIme as korime, korisnik.Lozinka as lozinka, korisnik.Email as email, restoran.IdKorisnik as id "
                . "FROM restoran, grad, drzava, korisnik "
                . "WHERE restoran.IdGrad = grad.IdGrad AND grad.IdDrzava = drzava.IdDrzava "
                . "AND restoran.IdKorisnik = korisnik.IdKorisnik AND restoran.IdKorisnik = ". $id." ");
        
        return $query->row();
       /* $this->db->from('restoran');
        $this->db->where('IdKorisnik', $id);
        
        $restoran = $this->db->get()->row();
        if ($restoran != null){
            $this->db->from('grad');
            $this->db->where($restoran->IdGrad, 'IdGrad');
            
            $korisnik = $this->db->get()->row();
            $restoran->Grad = $korisnik->Naziv;
            
            if ($korisnik != null){
                $this->db->from('drzava');
                $this->db->where($restoran->IdGrad, 'IdGrad');
            
                $korisnik2 = $this->db->get()->row();
                $restoran->Drzava = $korisnik2->Naziv;
                
                return $restoran;
            } else {
                return null;
            }
        } else {
            //ako postoji korisnik sa tim ID-jem ali nije gurman, vraca null
            return null;
        }*/
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
}
