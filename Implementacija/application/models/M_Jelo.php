<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Jelo
 *
 * @author Lazar
 */
class M_Jelo extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Dohvata pregledana jela cije ime odgovara prosledjenom parametru. Funkcija ne dohvata samo istoimena jela,
     * vec jela koja u svom nazivu imaju prosledjeni parametar.
     * 
     * @param type $pattern Ime po kom se traze jela.
     * @return stdClass Objekat sa poljima Naziv, Opis, IdJelo, IdKorisnik, IdSlika, Pregledano
     */
    public function dohvatiJelaPoNazivu($pattern) {
        $this->db->select('*');
        $this->db->from('jelo');
        $this->db->like('Naziv', $pattern);
        $this->db->where('Pregledano', 'P');

        return $this->db->get()->result();
    }

    /**
     * Dohvata poslednji ID u bazi iz tabele jelo.
     * 
     * @return stdClass Objekat sa poljem poslednjiId
     */
    public function poslednjiId() {
        $this->db->select('max(jelo.IdJelo) as poslednjiId');
        $this->db->from('jelo');

        return $this->db->get()->row();
    }

    public function proveriNazivJela($uneto) {
        $this->db->select('jelo.IdJelo as IdJelo');
        $this->db->from('jelo');
        $this->db->where('Naziv', $uneto['naziv']);
        $this->db->where('IdKorisnik', $uneto['idKorisnik']);

        return $this->db->get()->row();
    }

    public function napraviJelo($uneto) {
        $this->db->set('IdJelo', $uneto['idJela']);
        $this->db->set('IdKorisnik', $uneto['idKorisnik']);
        $this->db->set('Naziv', $uneto['naziv']);
        $this->db->set('Opis', $uneto['opisjela']);
        $this->db->set('Pregledano', 'N');
        if (isset($uneto['idSlika'])) {
            $this->db->set('IdSlika', $uneto['idSlika']);
        }
        $this->db->insert('jelo');
    }

    public function poveziSastojakSaJelom($idSastojka, $idJela) {
        $this->db->set('IdJelo', $idJela);
        $this->db->set('IdSastojak', $idSastojka);
        $this->db->insert('ima_sastojak');
    }

    public function dohvatiJelo($idJelo) {
        $this->db->from('jelo');
        $this->db->where('IdJelo', $idJelo);

        return $this->db->get()->row();
    }

    public function obrisiJelo($idJela) {
        $this->db->where('IdJelo', $idJela);
        $this->db->delete('jelo');
    }

    public function dohvatiNepregledanaJela() {
        return $this->db->select("*")->from('jelo')->where('Pregledano', 'N')->get()->result();
    }

    public function postaviPregledano($id) {
        $this->db->set('Pregledano', 'P');
        $this->db->where('IdJelo', $id);
        $this->db->update('jelo');
    }

}
