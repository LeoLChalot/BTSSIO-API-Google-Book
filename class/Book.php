<?php
class Book
{
    private ?string $title;
    private ?string $subtitle;
    private ?string $description;
    private ?string $authors;
    private ?string $pages_count;
    private ?string $img_link;

    public function __construct(){}
    
    // * ACTIONS
    public function PDO_connexion()
    {
        try {
            $connexion = new PDO("mysql:host=" . SERVERNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connexion->beginTransaction();
        } catch (PDOException $e) {
            $connexion->rollBack();
            echo "Erreur : " . $e->getMessage();
        }
        return $connexion;
    }
    static function search_book_name(?string $title): array
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
    static function search_book_id(?string $bookId): array
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
    public function add_book(?int $user_id): void
    {
        $connexion = $this->PDO_connexion();

    }

    // * GETTERS
    public function get_title(): string
    {
        return $this->title;
    }
    public function get_sub_title(): string
    {
        return $this->subtitle;
    }
    public function get_description(): string
    {
        return $this->description;
    }
    public function get_authors(): string
    {
        return $this->authors;
    }
    public function get_page_count(): string
    {
        return $this->pages_count;
    }
    public function get_img_link(): string
    {
        return $this->img_link;
    }

    // * SETTERS
    public function set_title(?string $title): void
    {
        $this->title = $title;
    }
    public function set_subtitle(?string $subtitle): void
    {
        $this->subtitle = $subtitle;
    }
    public function set_description(?string $description): void
    {
        $this->description = $description;
    }
    public function set_authors(?string $authors): void
    {
        $this->authors = $authors;
    }
    public function set_page_count(?string $pages_count): void
    {
        $this->pages_count = $pages_count;
    }
    public function set_img_link(?string $img_link): void
    {
        $this->img_link = $img_link;
    }
}
