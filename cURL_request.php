<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentation</title>
    <style>
        *,
        ::before,
        ::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            gap: 1em;
            justify-content: center;
            align-items: center;
        }

        table {
            border: 1px solid #b3adad;
            border-collapse: collapse;
            padding: 5px;
        }

        table th {
            border: 1px solid #b3adad;
            padding: 5px;
            background: #f0f0f0;
            color: #313030;
        }

        table td {
            border: 1px solid #b3adad;
            text-align: center;
            padding: 10px 5px;
            background: #ffffff;
            color: #313030;
        }
    </style>
</head>

<body>
    <div id="input">
        <form action="" method="get">
            <input type="text" name="title" id="title">
            <input type="submit" value="Chercher">
        </form>
    </div>
    <div class="cURL">
        <?php
            if (!empty($_GET['title'])) : ?>
                <?php
                $key = '$AIzaSyAY1N3MiifNN02kmk2X6j64tk6WVP57kqQ';
                $title = $_GET['title'];
                $title = str_replace(' ', '+', $title);

                $url = "https://www.googleapis.com/books/v1/volumes?q=$title&   langRestrict=fr&maxResults=1";
                $curl = curl_init($url);
                $options = array(
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => array('Content-type: application/ json'),
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_URL => $url,
                    CURLOPT_CAINFO => __DIR__ . '/assets/Certificat/GTS Root R1.    crt'
                );

                curl_setopt_array($curl, $options);
                $resp = curl_exec($curl);
                if ($e = curl_error($curl)) {
                    var_dump($e);
                } else {
                    $data = json_decode($resp, true);
                    $results = $data["items"];
                    // var_dump($data);
                }
            ?>
            <table>
                <thead>
                    <tr id="titre-table">
                        <th colspan="2">$results[$i]['volumeInfo']</th>
                    </tr>
                </thead>
                <tbody id="global-items">
                    <tr id="book-id">
                        <td>["id"]</td>
                        <td><?= $results[0]["id"] ?></td>
                    </tr>
                    <tr id="book-title">
                        <td>["title"]</td>
                        <td><?php
                            if (isset($results[0]["volumeInfo"]["title"])) {
                                echo $results[0]["volumeInfo"]["title"];
                            }
                            ?>
                        </td>
                    </tr>
                    <tr id="book-subtitle">
                        <td>["subtitle"]</td>
                        <td><?php
                            if (isset($results[0]["volumeInfo"]["subtitle"])) {
                                echo $results[0]["volumeInfo"]["subtitle"];
                            }
                            ?>
                        </td>
                    </tr>
                    <tr id="book-authors">
                        <td>["authors"]</td>
                        <td>
                            <?php
                            if (isset($results[0]["volumeInfo"]["authors"])) {
                                foreach ($results[0]["volumeInfo"]["authors"] as $author) {
                                    echo $author . ", ";
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr id="book-publisher">
                        <td>["publisher"]</td>
                        <td><?php
                            if (isset($results[0]["volumeInfo"]["publisher"])) {
                                echo $results[0]["volumeInfo"]["publisher"];
                            }
                            ?>
                        </td>
                    </tr>
                    <tr id="book-publishedDate">
                        <td>["publishedDate"]</td>
                        <td><?php
                            if (isset($results[0]["volumeInfo"]["publishedDate"])) {
                                echo $results[0]["volumeInfo"]["publishedDate"];
                            }
                            ?>
                        </td>
                    </tr>
                    <tr id="book-description">
                        <td>["description"]</td>
                        <td>Description du livre</td>
                    </tr>
                    <tr id="book-pageCount">
                        <td>["pageCount"]</td>
                        <td><?php
                            if (isset($results[0]["volumeInfo"]["pageCount"])) {
                                echo $results[0]["volumeInfo"]["pageCount"];
                            }
                            ?>
                        </td>
                    </tr>
                    <tr id="book-printType">
                        <td>["printType"]</td>
                        <td><?php
                            if (isset($results[0]["volumeInfo"]["printType"])) {
                                echo $results[0]["volumeInfo"]["printType"];
                            }
                            ?>
                        </td>
                    </tr>
                    <tr id="book-previewLink">
                        <td>["previewLink"]</td>
                        <td><?php
                            if (isset($results[0]["volumeInfo"]["previewLink"])) {
                                echo $results[0]["volumeInfo"]["previewLink"];
                            }
                            ?>
                        </td>
                    </tr>
                    <tr id="book-infoLink">
                        <td>["infoLink"]</td>
                        <td><?php
                            if (isset($results[0]["volumeInfo"]["infoLink"])) {
                                echo $results[0]["volumeInfo"]["infoLink"];
                            }
                            ?>
                        </td>
                    </tr>
                    <tr id="book-imageLinks">
                        <td>["imageLinks"]["smallThumbnail"]</td>
                        <td>
                            <?php
                            if (isset($results[0]["volumeInfo"]['imageLinks']['smallThumbnail'])) {
                                echo $results[0]["volumeInfo"]['imageLinks']['smallThumbnail'];
                            } ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php
            endif
            ?>
    </div>
    <a href="index.php"><button type="button" class="btn btn-success">Retour</button></a>
    <?php
        if (isset($curl)) {
        curl_close($curl);
        } 
        ?>
</body>

</html>