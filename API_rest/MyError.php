<?php


class MyError
{

    public static function error401(){
        self::messageError(401, "unauthorized");
    }

    public static function error404() {
       self::messageError(404, "not found");
    }

    private static function messageError(int $nbError, string $message){
        echo json_encode (array('status' => $nbError, "message" => $message));
    }
}