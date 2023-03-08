<?php
/**
 * Classe qui utilise l'API de Google Book pour aller chercher des informations sur un livre en particulier ou faire des recherches par mot clé.
 *  
 * @author Olivier Arteau
 * 
 * Les deux principales méthodes sont :
 * 
 * getBooksByKeyword
 *     - retourne un tableau de livre
 *     
 * getBookByISBN
 *     - retourne le livre ou null si le livre n'existe pas
 * 
 * La structure d'un livres est la suivante :
 *
 * array(
 *     'auteur' => '', // Auteur(s) du livre 
 *     'date' => 0, // Date de publication au format timestamp
 *     'identifier' => array(
 *         'ISBN' => '', // ISBN de 10 chiffres
 *         'ISBN2' => '', // ISBN de 13 chiffres
 *         'googleid' => '' // Id Google du livre
 *     ),
 *     'titre' => '', // Titre du livre
 *     'editeur' => '', // Éditeur du livre
 *     'image' => '' // Lien vers une image miniature du livre
 * );
 * 
 * Note: Les index sont absent pour les données qui ne sont pas disponible
 */
define('APIKEY', '$AIzaSyAY1N3MiifNN02kmk2X6j64tk6WVP57kqQ');
class BookSearcher
{
    private $xpp;
    public function __construct()
    {
    }
    /**
     * Recherche de livre(s) par mot(s) clé(s). Retourne la liste des livres trouvés 
     * avec leur information.
     * 
     * @param (string) keyword(s)
     **/
    public function getBooksByKeyword($keyword)
    {
        $this->xpp = new XMLReader();
        $books = array();
        if ($this->xpp->open('http://books.google.com/books/feeds/volumes?q=' . urlencode($keyword) .'&key=' . APIKEY)) {
            $this->moveToEntry();
            $books = array();
            while ($this->xpp->name == "entry") {
                $books[] = $this->parseBook();
            }
        }
        return $books;
    }
    /**
     * Cherche un livre par son ISBN et retourne un tableau contenant 
     * les informations relatives au livre
     * 
     * @param (string) ISBN
     **/
    public function getBookByISBN($isbn)
    {
        $this->xpp = new XMLReader();
        if ($this->xpp->open('http://books.google.com/books/feeds/volumes?q=' . urlencode($isbn) .'&key=' . APIKEY)) {
            $this->moveToEntry();
            $found = false;
            while ($this->xpp->name == "entry") {
                $book = $this->parseBook();
                // Si le livre est trouvé //
                if (
                    isset($book['identifier']) &&
                    (strlen($isbn) == 10 && isset($book['identifier']['ISBN']) &&  $book['identifier']['ISBN'] == $isbn) || // ISBN
                    (strlen($isbn) == 13 && isset($book['identifier']['ISBN2']) &&  $book['identifier']['ISBN2'] == $isbn)
                ) // ISBN2
                {
                    $found = true;
                    break;
                }
            }
        }
        return (!isset($book) || !$found) ? null : $book;
    }
    private function parseBook()
    {
        $book = array();
        while ($this->xpp->read() && $this->xpp->name != "entry") {
            if ($this->xpp->name[0] == "#")
                continue;
            switch ($this->xpp->name) {
                case 'dc:creator':
                    if (!isset($book['auteur']))
                        $book['auteur'] = '';
                    else
                        $book['auteur'] .= ', ';
                    $book['auteur'] .= $this->parseAuthor();
                    break;
                case 'dc:date':
                    $dt = explode('-', $this->parseDate());
                    $book['date'] = mktime(0, 0, 0, (isset($dt[2]) ? $dt[2] : 1), (isset($dt[1]) ? $dt[1] : 1), $dt[0]);
                    break;
                case 'dc:identifier':
                    if (!isset($book['identifier'])) {
                        $book['identifier'] = array();
                    }
                    $dt = $this->parseIdentifier();
                    $book['identifier'][$dt['type']] = $dt['data'];
                    break;
                case 'dc:title':
                    if (!isset($book['titre']))
                        $book['titre'] = '';
                    else
                        $book['titre'] .= ', ';
                    $book['titre'] .= $this->parseTitle();
                    break;
                case 'dc:publisher':
                    $book['editeur'] = $this->parsePublisher();
                    break;
                case 'link':
                    $dt = $this->parseLink();
                    if ($dt['name'] == 'thumbnail') {
                        $book['image'] = $dt['href'];
                    }
                    break;
            }
        }
        $this->xpp->read();
        return $book;
    }
    private function parsePublisher()
    {
        $this->xpp->read();
        $val = $this->xpp->value;
        $this->xpp->read();
        return $val;
    }
    private function parseAuthor()
    {
        $this->xpp->read();
        $val = $this->xpp->value;
        $this->xpp->read();
        return $val;
    }
    private function parseDate()
    {
        $this->xpp->read();
        $val = $this->xpp->value;
        $this->xpp->read();
        return $val;
    }
    private function parseTitle()
    {
        $this->xpp->read();
        $val = $this->xpp->value;
        $this->xpp->read();
        return $val;
    }
    private function parseLink()
    {
        $dt = array();
        $dt['type'] = $this->xpp->getAttribute('type');
        $dt['name'] = substr($this->xpp->getAttribute('rel'), strrpos($this->xpp->getAttribute('rel'), '/') + 1);
        $dt['href'] = html_entity_decode($this->xpp->getAttribute('href'));
        return $dt;
    }
    private function parseIdentifier()
    {
        $this->xpp->read();
        $val = $this->xpp->value;
        $this->xpp->read();
        $dt = array();
        if (substr($val, 0, 5) == 'ISBN:') {
            $dt['type'] = 'ISBN';
            $dt['data'] = trim(substr($val, 5));
            if (strlen($dt['data']) == 13)
                $dt['type'] .= '2';
        } else {
            $dt['type'] = 'googleid';
            $dt['data'] = $val;
        }
        return $dt;
    }
    private function moveToEntry()
    {
        // Positionne au début des entrées //
        while ($this->xpp->name != "entry") {
            if (!$this->xpp->read())
                break;
        }
    }
}

// $googleBook = new BookSearcher();


// $livres = $googleBook->getBooksByKeyword('programmation php');

// echo '<h1>Example de recherche</h1>';
// for ($i=0; $i<count($livres); $i++) {
//     echo 'Livre ' . ($i+1) . '<br />';
//     echo '<pre>';
//         print_r($livres[$i]);
//     echo '</pre><br />';
// }


// echo '<h1>Example de recherche par ISBN</h1>';
// $livre = $googleBook->getBookByISBN('2844272592');

// echo 'Livre (2844272592)<br />';
// echo '<pre>';
//     print_r($livre);
// echo '</pre><br />';
?>
