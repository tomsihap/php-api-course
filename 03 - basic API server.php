<?php

require_once 'helpers.php';

$method = $_SERVER['REQUEST_METHOD'];
$method = (isset($_POST['_method'])
              AND ($_POST['_method'] == 'PATCH' XOR $_POST['_method'] == 'PUT'))
            ? 'PATCH' : $method;

if (! isset($_SERVER['PATH_INFO']) ) {
  throw new Exception('Il manque la requête après api.php.');
}
$path = explode("/", trim($_SERVER['PATH_INFO'], '/') );

$table = $path[0];
$id    = isset( $path[1]) ? $path[1] : null;

switch ($method) {
  case 'GET':
    $data = read($table, $id);

    $json = json_encode($data);
    header("HTTP/1.1 200");

    Header('Content-Type: application/json');
    echo $json;
    break;

  case 'POST':
    create($table,$_POST);
    header("HTTP/1.1 201");

    break;

  case 'PATCH':
    unset($_POST['_method']);
    update($table, $_POST, $id);
    $data = read($table, $id);

    header('HTTP/1.1 202');
    header('Content-Type: application/json');
    echo json_encode($data);
    break;

  case 'DELETE':
    unset($_POST['_method']);
    header("HTTP/1.1 204");
    header('Content-Type: application/json');
    $array = [
      'message' => 'La ressource a bien été supprimée.',
    ];
    echo $array;

    delete($table, $id);
    break;

  default:
    header("HTTP/1.1 401");
    header('Content-Type: application/json');
    $array = [
      'message' => 'La méthode HTTP n\'est pas prise en charge.',
    ];

    echo json_encode($array);
    break;
}
