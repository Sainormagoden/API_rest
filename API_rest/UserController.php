<?php


class UserController
{

    public function userById($id){

        echo json_encode((false == $result = Modele::recupUser($id))? "Erreur : L'id ne correspond a aucun user!" : $result);
    }

}