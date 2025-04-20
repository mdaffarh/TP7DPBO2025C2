<?php
require_once 'config/db.php';

class Character
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conn;
    }


    // get all characters
    public function getAll($search = null)
    {
        $query = "SELECT characters.*, weapons.name AS weapon, elements.name AS element
                  FROM characters
                  LEFT JOIN weapons ON characters.weapon_id = weapons.id
                  LEFT JOIN elements ON characters.element_id = elements.id";

        if ($search) {
            $search = "%$search%";
            $query .= " WHERE characters.name LIKE :search OR elements.name LIKE :search OR weapons.name LIKE :search OR characters.hp LIKE :search OR characters.level LIKE :search";
        }

        $stmt = $this->db->prepare($query);

        if ($search) {
            $stmt->bindParam(':search', $search);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get character by id
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM characters WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // add character
    public function add($name, $hp, $level, $element_id, $weapon_id)
    {
        $stmt = $this->db->prepare("INSERT INTO characters (name, hp, level, element_id, weapon_id) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $hp, $level, $element_id, $weapon_id]);
    }

    // update character
    public function update($id, $name, $hp, $level, $element_id, $weapon_id)
    {
        $stmt = $this->db->prepare("UPDATE characters SET name = ?, hp = ?, level = ?, element_id = ?, weapon_id = ? WHERE id = ?");
        return $stmt->execute([$name, $hp, $level, $element_id, $weapon_id, $id]);
    }

    // delete character
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM characters WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
