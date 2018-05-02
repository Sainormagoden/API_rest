<?php

class Modele {

    /**
     * Exécute une requête SQL avec PDO
     *
     * @param string $query La requête SQL
     * @return PDOStatement Retourne l'objet PDOStatement
     */
    /*public static function recupUser($allData)
    {
        $a = SPDO::getInstance();
        if(preg_match('/^[0-9]+$/',$allData)){
            $sql = 'SELECT id, lastname, firstname, email, role FROM user WHERE id=:allData';
        }
        else if(preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$/',$allData)){
            $sql = 'SELECT id, lastname, firstname, email, role FROM user WHERE email=:allData';
        }
        else if(preg_match('/^[a-z]+$/',$allData)){
            $sql = 'SELECT id, lastname, firstname, email, role FROM user WHERE role=:allData';
        }
        else if(preg_match('/^[a-zA-Z]+$/',$allData)){
            $sql = 'SELECT id, lastname, firstname, email, role FROM user WHERE lastname=:allData || firstname=:allData';
        }
        else{
            $sql = '';
        }
        $sth = $a->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':allData' => $allData));

        return $sth->FETCHALL(PDO::FETCH_ASSOC);
    }*/
    public static function recupUserById($id)
    {
        $a = SPDO::getInstance();
        $sql = 'SELECT id, lastname, firstname, email, role FROM user WHERE id=:id';
        $sth = $a->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':id' => $id));

        return $sth->FETCH(PDO::FETCH_ASSOC);
    }

    public static function recupUserByLastname($name)
    {
        $a = SPDO::getInstance();
        $sql = 'SELECT id, lastname, firstname, email, role FROM user WHERE lastname=:name';
        $sth = $a->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':name' => $name));

        return $sth->FETCHALL(PDO::FETCH_ASSOC);
    }

    public static function recupUserByfirstname($name)
    {
        $a = SPDO::getInstance();
        $sql = 'SELECT id, lastname, firstname, email, role FROM user WHERE firstname=:name';
        $sth = $a->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':name' => $name));

        return $sth->FETCHALL(PDO::FETCH_ASSOC);
    }

    public static function recupUserByEmail($email)
    {
        $a = SPDO::getInstance();
        //'/^[0-9]+$/'
        $sql = 'SELECT id, lastname, firstname, email, role FROM user WHERE email=:email';
        $sth = $a->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':email' => $email));

        return $sth->FETCHALL(PDO::FETCH_ASSOC);
    }

    public static function recupUserByRole($role)
    {
        $a = SPDO::getInstance();
        //'/^[0-9]+$/'
        $sql = 'SELECT id, lastname, firstname, email, role FROM user WHERE role=:role';
        $sth = $a->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':role' => $role));

        return $sth->FETCHALL(PDO::FETCH_ASSOC);
    }
}