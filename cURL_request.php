<?php
$key = '$AIzaSyAY1N3MiifNN02kmk2X6j64tk6WVP57kqQ';
$title = "Javascript";

/*
*   "https://www.googleapis.com/books/v1/volumes?q=Harry+Potter" -H "Content-Type: application/json" -G -d "printType=books"
*/

// $url = "http://books.google.com/books/feeds/volumes?q=$title";
// &key=$key

// $curl = curl_init($url);
// Options
// $options = array(
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_HTTPHEADER => array('Content-type: application/json'),
//     CURLOPT_TIMEOUT => 0,
//     CURLOPT_URL => $url,
//     CURLOPT_SSL_VERIFYPEER => false
// );

// curl_setopt_array($curl, $options);
// $data = curl_exec($curl);

// if ($e = curl_error($curl)) {
//     var_dump($e);
// } else {
//     $decoded = json_decode($data, true);

//     var_dump($decoded);
// }


$url = "https://www.googleapis.com/books/v1/volumes?q=$title&langRestrict=fr";
$curl = curl_init($url);
$options = array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => array('Content-type: application/json'),
    CURLOPT_TIMEOUT => 0,
    CURLOPT_URL => $url,
    CURLOPT_SSL_VERIFYPEER => false
);

curl_setopt_array($curl, $options);



$resp = curl_exec($curl);

if ($e = curl_error($curl)) {
    var_dump($e);
} else {
    $data = json_decode($resp, true);
    $results = $data["items"];
}

for ($i = 0; $i < count($results); $i++) {
    echo $results[$i]["volumeInfo"]["title"] . "<br>";
}

curl_close($curl);
