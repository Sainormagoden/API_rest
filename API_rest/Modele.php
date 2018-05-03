<?php

class Modele {

    /**
     * Exécute une requête SQL avec PDO
     *
     * @param string $query La requête SQL
     * @return PDOStatement Retourne l'objet PDOStatement
     */
    public static function recupUserById(int $id)
    {
        $a = SPDO::getInstance();
        $sql = 'SELECT id, lastname, firstname, email, role FROM user WHERE id=:id';
        $sth = $a->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':id' => $id));

        return $sth->FETCH(PDO::FETCH_ASSOC);
    }

    public static function recupUserByLastname(string $name)
    {
        $a = SPDO::getInstance();
        $sql = 'SELECT id, lastname, firstname, email, role FROM user WHERE lastname=:name';
        $sth = $a->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':name' => $name));

        return $sth->FETCHALL(PDO::FETCH_ASSOC);
    }

    public static function recupUserByfirstname(string $name)
    {
        $a = SPDO::getInstance();
        $sql = 'SELECT id, lastname, firstname, email, role FROM user WHERE firstname=:name';
        $sth = $a->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':name' => $name));

        return $sth->FETCHALL(PDO::FETCH_ASSOC);
    }

    public static function recupUserByEmail(string $email)
    {
        $a = SPDO::getInstance();
        $sql = 'SELECT id, lastname, firstname, email, role FROM user WHERE email=:email';
        $sth = $a->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':email' => $email));

        return $sth->FETCHALL(PDO::FETCH_ASSOC);
    }

    public static function recupUserByRole(string $role)
    {
        $a = SPDO::getInstance();
        $sql = 'SELECT id, lastname, firstname, email, role FROM user WHERE role=:role';
        $sth = $a->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':role' => $role));

        return $sth->FETCHALL(PDO::FETCH_ASSOC);
    }

    public static function postUser(string $lastname, string $firstname, string $email, string $password, string $role){
        $a = SPDO::getInstance();
        $verif = self::recupUserByEmail($email);
        if (!$verif){
            $sql = 'INSERT INTO user (lastname, firstname, email, password, role) VALUES (:lastname, :firstname, :email, :password, :role)';
            $sth = $a->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

            if ($sth->execute(array(':role' => $role, ':lastname' => $lastname, ':firstname' => $firstname, ':email' => $email, ':password' => $password))=== TRUE) {
                return array('id' => $a->lastInsertId());
            }
            else {
                return MyError::error500('Echec de la mise en ligne');
            }
        }
        else{
            return MyError::error500('le mail utilisé est deja prit');
        }
    }

    public static function putUser(int $id, array $elements){
        $a = SPDO::getInstance();
        $verif = self::recupUserById($id);
        if ($verif){
            if($verif['role'] == 'admin'){
                MyError::error401();
            }
            else{
                $sql = "UPDATE user SET";
                $varSql[':id'] = $id;
                $i = 1;
                foreach ($elements as $one => $value) {
                    $sql .= " $one = :$one".(($i < count($elements))? ", ": "");
                    $varSql[":$one"] = $value;
                    $i++;
                }
                $sql .= " WHERE id = :id";
                $sth = $a->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                if ($sth->execute($varSql) === TRUE){
                    return "modification reussite";
                }
                else{
                    return MyError::error500("echec update");
                }
            }
        }
        else{
            return MyError::error500("l'id ne correspond à personne");
        }
    }

    public static function deleteUser($id){
        $a = SPDO::getInstance();
        $verif = self::recupUserById($id);
        if ($verif){
            if($verif['role'] == 'admin'){
                MyError::error401();
            }
            else{
                $sql = 'DELETE FROM user WHERE id=:id';
                $sth = $a->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

                if ($sth->execute(array(':id' => $id))=== TRUE) {
                    return "suppression reussi!";
                }
                else {
                    return MyError::error500('Echec de suppression');
                }
            }
        }
        else{
            return MyError::error500("l'id ne correspond à personne");
        }
    }
}