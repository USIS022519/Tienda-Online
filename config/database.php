<?php

class Database 
{

    private $hostname = "localhost";
    private $database = "el_ingeniero";
    private $username = "root";
    private $password = "";
    private $charset = "utf8";

    function conectar()
    {
        try {
            $conexion = "mysql:host=" . $this->hostname . "; dbname=" . $this->database . "; charset=" . $this->charset;

        /* Es una configuracion para evitar que las preparaciones que se realizen en las consultas 
            no sean emuladas, sean reales y tengan seguridad */
        $option = [ 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        $pdo = new PDO($conexion, $this->username, $this->password, $option); 

        return $pdo;
        } catch (PDOException $th) {
            echo 'Error de conexcion: ' . $th->getMessage();
            exit;
        }
        
    }

}
