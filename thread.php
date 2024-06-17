<?php
class Thread{
    public $id;
    public $title;
    public $content;
    public $image;
    public $publishDate;
    public $commentList;


    function __construct($id, $title, $content, $image, $publishDate, $commentList) {
    $this->id = $id;
    $this->title = $title;
    $this->content = $content;
    $this->image = $image;
    $this->publishDate = $publishDate;
    $this->commentList = $commentList;
  }
}