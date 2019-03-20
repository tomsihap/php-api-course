<?php


function dbConnect()
{
    try {
        $bdd = new PDO('mysql:host=localhost:8889;dbname=php_api;charset=utf8;', 'root', 'root', null);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $bdd;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function read(string $table, int $id = null)
{

    $db = dbConnect();

    $sql = "SELECT * FROM $table";
    $whereStatement = " WHERE id = :id";
    $prepare = null;

    if (null !== $id) {
        $sql = $sql . $whereStatement;
        $prepare = ["id"  => $id];
    }

    $req = $db->prepare($sql);
    $req->execute($prepare);

    $data = $req->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

function create($table, $data)
{

    $keys = array_keys($data);
    $fieldsList = implode(', ', $keys);

    //$prepareList = ':' . implode(', :', $keys);
    $preparedKeys = array_map(function ($v) {
        return ':' . $v;
    }, $keys);

    $prepareList = implode(', ', $preparedKeys);

    $db = dbConnect();

    $sql = "
    INSERT INTO $table ($fieldsList)
    VALUES($prepareList)
  ";

    $req = $db->prepare($sql);
    $req->execute($data);

    return;
}

function update($table, $data, $id)
{
    $keys = array_keys($data);

    //$prepareList = ':' . implode(', :', $keys);
    $preparedKeys = array_map(function ($v) {
        return '`' .  $v . '` = :' . $v;
    }, $keys);

    $prepareList = implode(', ', $preparedKeys);

    $db = dbConnect();

    $sql = "
    UPDATE $table
    SET $prepareList
    WHERE id = :id";

    // On rajoute ID au tableau $data :
    $data['id'] = $id;

    $req = $db->prepare($sql);
    $req->execute($data);

    return;
}

function delete($table, $id)
{
    $db = dbConnect();

    $sql = "
    DELETE FROM $table
    WHERE id = :id";

    $req = $db->prepare($sql);
    $req->execute(['id' => $id]);

    return;
}
