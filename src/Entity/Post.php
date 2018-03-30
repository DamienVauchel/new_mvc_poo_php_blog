<?php

namespace Entity;


class Post
{
    private $id;
    private $title;
    private $content;

    public function __construct($datas)
    {
        $this->hydrate($datas);
    }

    public function hydrate($datas)
    {
        $this->setId($datas["id"]);
        $this->setTitle($datas['title']);
        $this->setContent($datas['content']);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }
}