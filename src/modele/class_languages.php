<?php

class Language {

    private $db;
    private $select;
    private $insert;
    private $selectByIdLang;
    private $update;
    private $delete;

    public function __construct($db) {
        $this->db = $db;
        $this->insert = $db->prepare("insert into language (nom)values(:nom)");
        $this->select = $db->prepare("select id, nom from language order by nom");
        $this->selectByIdLang = $db->prepare("select nom, id from language where id=:id order by nom");
        $this->update = $db->prepare("update language set nom=:nom where id=:id");
        $this->delete = $db->prepare("delete from language where id=:id");
    }

    public function insert($inputLang) {
        $r = true;
        $this->insert->execute(array(':nom' => $inputLang));
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

    public function selectByIdLang($id) {
        $this->selectByIdLang->execute(array(':id' => $id));
        if ($this->selectByIdLang->errorCode() != 0) {
            print_r($this->selectByIdLang->errorInfo());
        }
        return $this->selectByIdLang->fetch();
    }

    public function update($nom, $id) {
        $r = true;
        $this->update->execute(array(':nom' => $nom, ':id' => $id));
        if ($this->update->errorCode() != 0) {
            print_r($this->update->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function delete($id) {
        $r = true;
        $this->delete->execute(array(':id' => $id));
        if ($this->delete->errorCode() != 0) {
            print_r($this->delete->errorInfo());
            $r = false;
        }
        return $r;
    }

}

?>