<?php
class Book
{
    private ?string $title;
    private ?string $subtitle;
    private ?string $description;
    private ?string $author;
    private ?string $page_count;
    private ?string $img_link;

    public function __construct(?string $title, ?string $subtitle, ?string $img_link)
    {
    }

    // * ACTIONS
    public function search_book_name($keyword)
    {
    }
    public function search_book_id($bookId)
    {
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
