<?php
class Conexion
{
    static public function conectar()
    {
        $link = new PDO(
            "mysql:host=localhost;port=3306;dbname=u760520066_petfood",
            "u760520066_petfoodAdmin",
            "petAdmin69"
        );
        $link->exec("set names utf8");
        return $link;
    }
}
