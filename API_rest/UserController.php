<?php


class UserController
{


    private $queries;

    public function __construct(array $queries)
    {
        $this->queries = $queries;
    }

    /*public function userByAllData($allData){

        $result = Modele::recupUser($allData);
        if($result){
            foreach ($result as $test){
                if ($test['role'] == 'admin'){
                    $admin = true;
                }
            }
            if ($admin){
                MyError::error401();
            }
            else{
                echo json_encode($result);
            }
        }
        else{
            MyError::error404();
        }
    }*/

    public function userByQuery(){

        if (isset($this->queries['id']) && filter_var($this->queries['id'], FILTER_VALIDATE_INT)){
            $result = Modele::recupUserById($this->queries['id']);
        }
        else if (isset($this->queries['email']) && filter_var($this->queries['email'], FILTER_VALIDATE_EMAIL)){
            $result = Modele::recupUserByEmail($this->queries['email']);
        }
        else if (isset($this->queries['lastname']) && filter_var($this->queries['lastname'],FILTER_VALIDATE_REGEXP,  array("options" => array("regexp"=>'/^[a-zA-Z]+$/')))){
            $result = Modele::recupUserByLastname($this->queries['lastname']);
        }
        else if (isset($this->queries['firstname']) && filter_var($this->queries['firstname'],FILTER_VALIDATE_REGEXP,  array("options" => array("regexp"=>'/^[a-zA-Z]+$/')))){
            $result = Modele::recupUserByFirstname($this->queries['firstname']);
        }
        else if (isset($this->queries['role']) && filter_var($this->queries['role'],FILTER_VALIDATE_REGEXP,  array("options" => array("regexp"=>'/^[a-z]+$/')))){
            $result = Modele::recupUserByRole($this->queries['role']);
        }

        if($result){
            foreach ($result as $test){
                if ($test['role'] == 'admin'){
                    $admin = true;
                }
            }
            if ($admin){
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

    public function test(){
        print_r($this->queries);
        if (isset($this->queries['role']) && filter_var($this->queries['role'],FILTER_VALIDATE_REGEXP,  array("options" => array("regexp"=>'/^[a-z]+$/')))){
            echo "qqqqq";
        }
        else{
            echo "OFF";
        }
    }
}