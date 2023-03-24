<?php
class Book
{
    private ?string $title;
    private ?string $subtitle;
    private ?string $description;
    private ?string $author;
    private ?string $page_count;
    private ?string $img_link;

    public function __construct()
    {
    }

    // * ACTIONS
    public function search_book_name($title)
    {
        $title = str_replace(' ', '+', $title);
        $url = "https://www.googleapis.com/books/v1/volumes?q=$title&langRestrict=fr&maxResults=18";
        $curl = curl_init($url);
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-type: application/json'),
            CURLOPT_TIMEOUT => 0,
            CURLOPT_URL => $url,
            CURLOPT_CAINFO => __DIR__ . './../assets/Certificat/GTS Root R1.crt'
        );
        curl_setopt_array($curl, $options);
        $resp = curl_exec($curl);
        if ($e = curl_error($curl)) {
            var_dump($e);
        } else {
            $data = json_decode($resp, true);
            $results = $data["items"];
        }
        return $results;
    }
    public function search_book_id($bookId)
    {
        $url = "https://www.googleapis.com/books/v1/volumes/$bookId";
        $curl = curl_init($url);
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-type: application/json'),
            CURLOPT_TIMEOUT => 0,
            CURLOPT_URL => $url,
            CURLOPT_CAINFO => __DIR__ . './../assets/Certificat/GTS Root R1.crt'
        );
        curl_setopt_array($curl, $options);
        $resp = curl_exec($curl);
        if ($e = curl_error($curl)) {
            var_dump($e);
        } else {
            $data = json_decode($resp, true);
            $result = $data;
        }
        return $result;
    }
    public function add_to_collection()
    {
    }
    public function delete_from_collection()
    {
    }

    // * GETTERS
    public function get_title()
    {
    }
    public function get_sub_title()
    {
    }
    public function get_description()
    {
    }
    public function get_author()
    {
    }
    public function get_page_count()
    {
    }
    public function get_img_link()
    {
    }

    // * SETTERS
    public function set_title()
    {
    }
    public function set_sub_title()
    {
    }
    public function set_description()
    {
    }
    public function set_author()
    {
    }
    public function set_page_count()
    {
    }
    public function set_img_link()
    {
    }
}
