<?php 

include 'database/db.php';

header('Access-Control-Allow-Origin: *');



//peticion de tipo get


if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['id'])){
        $query = "SELECT * from nombres where id = ".$_GET['id'];
        $resultado = metodoGet($query);
        echo json_encode($resultado->fetch(PDO::FETCH_ASSOC));
    }else{
        $query = "SELECT * from nombres";
        $resultado = metodoGet($query);
        echo json_encode($resultado->fetchAll());
    };
    header("HTTP/1.1 200 OK");
    exit();
};


//peticion de tipo post
//php no reconoce bien los put y delete, solo get y post

if( $_POST['METHOD'] == 'POST'){
    unset($_POST['METHOD']);
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $query = "INSERT INTO nombres (nombre, apellido, telefono) VALUES ('$nombre', '$apellido', '$telefono')";
    $queryAutoIncremental ="SELECT MAX(id) as id from nombres";
    $resultado = metodoPost($query, $queryAutoIncremental);
    echo json_encode($resultado);
    header("HTTP/1.1 200 OK");
    exit();
};

//peticion put, se envia como post pero con el metodo put

if($_POST['METHOD'] == 'PUT'){
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $query = "UPDATE nombres SET nombre='$nombre', apellido='$apellido', telefono='$telefono' WHERE id=$id";
    $resultado = metodoPut($query);
    echo json_encode($resultado);
    header("HTTP/1.1 200 OK");
    exit();
};


//peticion delete, aca si uso la variable $_server

if($_POST['METHOD'] == 'DELETE'){
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $query = "DELETE FROM nombres WHERE id=$id";
    $resultado = metodoDelete($query);
    echo json_encode($resultado);
    header("HTTP/1.1 200 OK");
    exit();
};

header("HTTP/1.1 400 Bad Request");



?>