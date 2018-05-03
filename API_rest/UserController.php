<?php


class UserController
{


    private $queries;

    public function __construct(array $queries)
    {
        $this->queries = $queries;
    }

    public function getUserByQuery(){

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

    public function postUserByQuery(){
        if (isset($_POST['lastname'], $_POST['firstname'], $_POST['email'], $_POST['password'], $_POST['role']) &&
            filter_var($_POST['password'], FILTER_VALIDATE_REGEXP,  array("options" => array("regexp"=>'/^[a-zA-Z0-9]+$/'))) &&
            filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
            filter_var($_POST['lastname'],FILTER_VALIDATE_REGEXP,  array("options" => array("regexp"=>'/^[a-zA-Z]+$/'))) &&
            filter_var($_POST['firstname'],FILTER_VALIDATE_REGEXP,  array("options" => array("regexp"=>'/^[a-zA-Z]+$/'))) &&
            filter_var($_POST['role'],FILTER_VALIDATE_REGEXP,  array("options" => array("regexp"=>'/^[a-z]+$/')))
        ){
            echo json_encode(Modele::postUser($_POST['lastname'], $_POST['firstname'], $_POST['email'], $_POST['password'], $_POST['role']));
        }
        else{
            MyError::error500("données incorectes!");
        }
    }

    public function putUserByQuery(int $id){
        parse_str(file_get_contents("php://input"),$put_var);
        $error = false;
        if ((isset($put_var['lastname']) && !filter_var($put_var['lastname'],FILTER_VALIDATE_REGEXP,  array("options" => array("regexp"=>'/^[a-zA-Z]+$/')))) ||
            (isset($put_var['firstname']) && !filter_var($put_var['firstname'],FILTER_VALIDATE_REGEXP,  array("options" => array("regexp"=>'/^[a-zA-Z]+$/')))) ||
            (isset($put_var['email']) && !filter_var($put_var['email'], FILTER_VALIDATE_EMAIL)) ||
            (isset($put_var['password']) && !filter_var($put_var['password'], FILTER_VALIDATE_REGEXP,  array("options" => array("regexp"=>'/^[a-zA-Z0-9]+$/')))) ||
            (isset($put_var['role']) && !filter_var($put_var['role'],FILTER_VALIDATE_REGEXP,  array("options" => array("regexp"=>'/^[a-z]+$/'))))
        ){
            $error = true;
        }
        if ($error){
            MyError::error500('données incorrectes!');
        }
        else{
            echo json_encode(Modele::test($id, $put_var));
        }
    }

    public function deleteUserByQuery(int $id){
        if (is_numeric($id)){
            echo json_encode(Modele::deleteUser($id));
        }
        else{
            MyError::error500("données incorectes!");
        }
    }

}