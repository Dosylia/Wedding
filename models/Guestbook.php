<?php

namespace models;

use config\DataBase;

class Guestbook extends DataBase
{
    private \PDO $bdd;
    
    public function __construct() {
        $this->bdd = $this->getBdd();
    }

    public function getAllEntries()
    {
        $query = $this->bdd->prepare("
                                        SELECT
                                            *
                                        FROM
                                            entries
                                        ORDER BY
                                            created_at DESC
        ");

        $query->execute();
        $entries = $query->fetchAll();

        if ($entries) {
        return $entries;
        } else {
        return false;
        }
    }

    public function addEntry($name, $message, $imagePath)
    {
        $query = $this->bdd->prepare("
                                        INSERT INTO entries (name, message, image_path)
                                        VALUES (?, ?, ?)
        ");

        $insertEntry =  $query->execute([$name, $message, $imagePath]);

        if ($insertEntry) {
            return true;
        } else {
            return false;
        }

        
    }
}