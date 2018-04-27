<?php


class UserController
{

    public function userById($id){

        $result = Modele::recupUser($id);
        if($result){
            if ($result['role'] == "admin"){
                MyError::error401();
            }
            else{
                echo json_encode($result);
            }
        }
        else{
            MyError::error404();
        }
    }

}