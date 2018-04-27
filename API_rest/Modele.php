<?php

class Modele {

    /**
     * Exécute une requête SQL avec PDO
     *
     * @param string $query La requête SQL
     * @return PDOStatement Retourne l'objet PDOStatement
     */
    public static function recupUser(int $id)
    {
        $a = SPDO::getInstance();
        $sql = 'SELECT id, lastname, firstname, email, role FROM user WHERE id=:id';
        $sth = $a->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':id' => $id));

        return $sth->FETCH(PDO::FETCH_ASSOC);
    }
}