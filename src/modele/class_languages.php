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
        $this->insert = $db->prepare("insert into language (nom, watt)values(:nom, :watt)");
        $this->select = $db->prepare("select id, nom, watt from language order by watt DESC");
        $this->selectByIdLang = $db->prepare("select nom, id, watt from language where id=:id order by watt");
        $this->update = $db->prepare("update language set nom=:nom, watt=:watt where id=:id");
        $this->delete = $db->prepare("delete from language where id=:id");
    }

    public function insert($inputLang, $inputWatt) {
        $r = true;
        $this->insert->execute(array(':nom' => $inputLang, ':watt' => $inputWatt));
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

    public function update($nom, $id, $watt) {
        $r = true;
        $this->update->execute(array(':nom' => $nom, ':id' => $id, ':watt' => $watt));
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