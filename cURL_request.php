<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $key = '$AIzaSyAY1N3MiifNN02kmk2X6j64tk6WVP57kqQ';
    $title = "Javascript";

    /*
*   "https://www.googleapis.com/books/v1/volumes?q=Harry+Potter" -H "Content-Type: application/json" -G -d "printType=books"
*/

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
        // var_dump($results);
        // var_dump($results['imageLinks']);
    }

    for ($i = 0; $i < count($results); $i++) {
        // https://books.google.fr/books?id=pCJWX7ETkBwC&printsec=frontcover&hl=fr&source=gbs_ge_summary_r&cad=0#v=onepage&q&f=false
        $booksId = $results[$i]['id'];
        // echo '<img src="https://books.google.fr/books/content?id='.$booksId.'&hl=fr&pg=PP1&img=1&zoom=3&sig=ACfU3U26P-JNVJpPXUqcOMz2gFyFIwOFzg&w=1280"';
        if (isset($results[$i]["volumeInfo"]["title"])) {
            echo "Titre : " . $results[$i]["volumeInfo"]["title"] . "<br>";
        }
        if (isset($results[$i]["volumeInfo"]["subtitle"])) {
            echo "Sous-titre : " . $results[$i]["volumeInfo"]["subtitle"] . "<br>";
        }
        if (isset($results[$i]["volumeInfo"]["description"])) {
            echo "Description : " . $results[$i]["volumeInfo"]["description"] . "<br>";
        }
        if (isset($results[$i]["volumeInfo"]["authors"])) {
            echo "Auteur(s) : ";
            foreach ($results[$i]["volumeInfo"]["authors"] as $author) {
                echo $author . ", ";
            }
        }
        if(isset($results[$i]["volumeInfo"]['imageLinks'])):?>
            <?php 
            // var_dump($results[$i]["volumeInfo"]['imageLinks']);
            $imgLink = $results[$i]["volumeInfo"]['imageLinks']['smallThumbnail']; ?>
            <img src="<?= $imgLink ?>" alt="">
        <?php endif ?>
        <?php echo "<br><br>";
    }



    curl_close($curl);
    ?>
</body>

</html>