<?php 

// ? Clé API perso utilisée pour le TP
$apiKey = 'AIzaSyAY1N3MiifNN02kmk2X6j64tk6WVP57kqQ';

// ? requête type utilisée pour communiquer avec l'google-books-API.php
$req = 'https://www.googleapis.com/books/v1/volumes?q='.$terms.'+inauthor:'.$author.'&key='.$apiKey;



?>