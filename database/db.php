<?php 

$pdo = null;
$host= 'localhost';
$user = 'root';
$password = '';
$bd = 'apiprueba';

function conectar(){
    try {
        $GLOBALS['pdo'] = new PDO('mysql:host='.$GLOBALS['host'].';dbname='.$GLOBALS['bd'], $GLOBALS['user'], $GLOBALS['password']);
        $GLOBALS['pdo']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Falló la conexión: ' . $e->getMessage();
        die();
    }
};

function desconectar(){
    $GLOBALS['pdo'] = null;
};

function metodoGet($query){
    try {
        conectar();
        $sentencia= $GLOBALS['pdo']->prepare($query); 
        $sentencia->setFetchMode(PDO::FETCH_ASSOC);
        $sentencia->execute();
        desconectar();
        return $sentencia;

    } catch (Exception $e) {
        die("error: ".$e);
    }
};

function metodoPost($query, $queryAutoIncremental){
    try {
        conectar();
        $sentencia= $GLOBALS['pdo']->prepare($query);
        $sentencia->execute();
        $idAutoIncremental = metodoGet($queryAutoIncremental)->fetch(PDO::FETCH_ASSOC);
        $resultado = array_merge($idAutoIncremental, $_POST);
        $sentencia->closeCursor();
        desconectar();
        return $resultado;

    } catch (Exception $e) {
        die("error: ".$e);
    }
};


function metodoPut($query){
    try {
        conectar();
        $sentencia= $GLOBALS['pdo']->prepare($query);
        $sentencia->execute();
        $resultado = array_merge($_GET, $_POST);
        $sentencia->closeCursor();
        desconectar();
        return $resultado;

    } catch (Exception $e) {
        die("error: ".$e);
    }
};

function metodoDelete($query){
    try {
        conectar();
        $sentencia= $GLOBALS['pdo']->prepare($query);
        $sentencia->execute();
        $sentencia->closeCursor();
        desconectar();
        return $_GET['id'];

    } catch (Exception $e) {
        die("error: ".$e);
    }
};
?>