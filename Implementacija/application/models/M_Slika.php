<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Slika
 *
 * @author Nenad Babin 0585/2016
 * @author Lazar Lazic 0245/2016
 * @vesrion 1.0
 */
class M_Slika extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Dohvata poslednji ID iz table slika.
     * 
     * @return stdClass Povratna vrednost je objekat koji ima polje poslednjiId.
     */
    public function poslednjiId() {
        $this->db->select('max(slika.IdSlika) as poslednjiId');
        $this->db->from('slika');
        
        return $this->db->get()->row();
    }
    
    /**
     * Upsuje jedan red u tabelu slika. Jedan red se sastoji od ID-ja slike i putanje na serveru do slike.
     * 
     * @param type $slika Objekat koji sadrzi polja IdSlika i Putanja.
     */
    public function unesiSliku($slika) {
        $podaciSlika = array(
            'IdSlika' => $slika->IdSlika,
            'Putanja' => $slika->Putanja
        );

        $this->db->insert('slika', $podaciSlika);
    }
    
    /**
     * Dohvata putanju do slike, na osnovu prosledjenog ID-ja.
     * 
     * @param type $id ID slike ciju putanju trazimo
     * @return stdClass Objekat sa poljem Putanja
     */
    public function dohvatiPutanju($id) {
        $this->db->select('Putanja');
        $this->db->from('slika');
        $this->db->where('IdSlika', $id);
        
        return $this->db->get()->row();
    }
    
    /**
     * Menja putanju slike sa datim ID, datom putanjom
     * 
     * @param int $idSlika
     * @param string $putanja
     * @return void
     */
    public function promeniPutanjuSlike($idSlika, $putanja){
        $this->db->set('Putanja', $putanja);
        $this->db->where('IdSlika', $idSlika);
        $this->db->update('slika');
    }
    
    /**
     * Brise sliku sa zadatim ID
     * @param int $idSlike
     * return void
     */
    public function obrisiSliku($idSlike){
        $this->db->where('IdSlika', $idSlike);
        $this->db->delete('slika');
    }
}
