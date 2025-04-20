<?php
require_once 'config/db.php';

class Element
{
    private $db;

    // koneksi ke database
    public function __construct()
    {
        $this->db = (new Database())->conn;
    }

    // get all elements
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM elements");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get element by id
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM elements WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // add element
    public function add($name, $strength, $weakness) {
        $stmt = $this->db->prepare("INSERT INTO elements (name, strength, weakness) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $strength, $weakness]);
    }

    // update element
    public function update($id, $name, $strength, $weakness) {
        $stmt = $this->db->prepare("UPDATE elements SET name = ?, strength = ?, weakness = ? WHERE id = ?");
        return $stmt->execute([$name, $strength, $weakness, $id]);
    }

    // delete element
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM elements WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
