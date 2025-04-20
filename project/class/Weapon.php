<?php
require_once 'config/db.php';

class Weapon
{
    private $db;

    // koneksi ke database
    public function __construct()
    {
        $this->db = (new Database())->conn;
    }

    // get all weapons
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM weapons");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get weapon by id
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM weapons WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // add weapon
    public function add($name, $type, $power) {
        $stmt = $this->db->prepare("INSERT INTO weapons (name, type, power) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $type, $power]);
    }

    // update weapon
    public function update($id, $name, $type, $power) {
        $stmt = $this->db->prepare("UPDATE weapons SET name = ?, type = ?, power = ? WHERE id = ?");
        return $stmt->execute([$name, $type, $power, $id]);
    }

    // delete weapon
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM weapons WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
