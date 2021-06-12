<?php
class Conexion
{
    static public function conectar()
    {
        $link = new PDO(
<<<<<<< HEAD
            "mysql:host=localhost;port=3306;dbname=u760520066_petfood",
            "u760520066_petfoodAdmin",
            "petAdmin69"
=======
            "mysql:host=localhost;port=3306;dbname=pos",
            "root",
            ""
>>>>>>> dev
        );
        $link->exec("set names utf8");
        return $link;
    }
}
