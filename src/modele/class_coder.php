<?php

class Coder {

    private $db;
    private $select;
    private $insert;
    private $selectByEmail;
    private $delete;
    private $rechercher;

    public function __construct($db) {
        $this->db = $db;
        $this->insert = $db->prepare("insert into coder (idLanguage, emailcoder, hpj) values (:idLanguage, :emailcoder, :hpj)");
        $this->select = $db->prepare("select idLangage from coder");
        $this->selectByEmail = $db->prepare("select c.idLanguage, l.nom as nom from coder c, language l where emailcoder=:emailcoder and c.idLanguage = l.id order by nom");
        $this->delete = $db->prepare("delete from coder where coder.idLanguage = :id and coder.emailcoder = :emailcoder");
        $this->rechercher = $db->prepare("select language.nom as nomdulanguage, utilisateurppe1.nom, utilisateurppe1.prenom, utilisateurppe1.email from coder, language, utilisateurppe1 where coder.idLanguage = language.id and utilisateurppe1.email=coder.emailcoder and language.nom like :recherche");
    }

    public function insert($idLanguage, $emailcoder, $hpj) {
        $r = true;
        $this->insert->execute(array(':idLanguage' => $idLanguage, ':emailcoder' => $emailcoder, ':hpj' => $hpj));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function select() {
        $liste = $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function selectByEmail($inputEmailCoder) {
        $listeml = $this->selectByEmail->execute(array(':emailcoder' => $inputEmailCoder));
        if ($this->selectByEmail->errorCode() != 0) {
            print_r($this->selectByEmail->errorInfo());
        }
        return $this->selectByEmail->fetchAll();
    }

    public function delete($id, $emailcoder) {
        $r = true;
        $this->delete->execute(array(':id' => $id, ':emailcoder' => $emailcoder));
        if ($this->delete->errorCode() != 0) {
            print_r($this->delete->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function rechercher($recherche) {
        $listerecherche = $this->rechercher->execute(array(':recherche' => '%' . $recherche . '%'));
        if ($this->rechercher->errorCode() != 0) {
            print_r($this->rechercher->errorInfo());
        }
        return $this->rechercher->fetchAll();
    }

}

?>