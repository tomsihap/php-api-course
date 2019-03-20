<?php

function curlHelper(
        string $method,
        string $host,
        array $params = null) {

    $curl = curl_init();

    if ($params && 'GET' === $method) {
        $paramsString = http_build_query($params);
        $url = $host . '?' . $paramsString;
    }
    else {
        $url = $host;
    }

    $array = [
        CURLOPT_URL             => $url,
        CURLOPT_SSL_VERIFYPEER  => false,
        CURLOPT_RETURNTRANSFER  => true,

        CURLOPT_CUSTOMREQUEST   => $method,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/x-www-form-urlencoded",
            "cache-control: no-cache",
            "Accept: application/json",
        ],
    ];

    curl_setopt_array($curl, $array);

    if ('POST' === $method) {
        curl_setopt($curl, CURLOPT_POST, 1);

        if ($params) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        }
    }

    $result = curl_exec($curl);

    if (curl_error($curl)) {
        $error_msg = curl_error($curl);
    }

    var_dump( curl_getinfo($curl)  );

    curl_close($curl);

    if (isset($error_msg)) {
        return $error_msg;
    }

    $data = json_decode($result);

    return $data;
}


// $people = curlGet('https://swapi.co/api/people/');

// foreach($people->results as $r) {

//     $planet = curlGet($r->homeworld);
//     //var_dump($planet);

//     echo "<h3>" . $r->name . "</h3>";
//     echo "<small>Taille: " . $r->height . "cm, poids : " . $r->mass . "kg</small>";
//     echo "<br>";
//     echo "<a href='" . $r->homeworld . "'>Planète d'origine : " . $planet->name. "</a>";
//     echo "<hr>";
// }


// $host = "https://omdbapi.com";
// $params = [
//     "apikey"=> "VOTRE_API_KEY",
//     "s"     => "batman",
//     "y"     => "2000"
// ];

// $data = curlHelper("GET", $host, $params);
// var_dump($data);

$host = "https://jsonplaceholder.typicode.com/users";
$data = [
    "name" => "Hello User",
];
$result = curlHelper("POST", $host, $data);

var_dump($result);
