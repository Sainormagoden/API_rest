<?php


class UserController
{

    public function userById($id){

        $result = Modele::recupUser($id);

        if($result){
            echo json_encode($result);
        }
        else{
            echo json_encode("Erreur : L'id ne correspond a aucun user!");
        }
    }

}