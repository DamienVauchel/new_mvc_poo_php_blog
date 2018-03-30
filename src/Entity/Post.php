<?php

namespace Entity;


class Post
{
    private $id;
    private $title;
    private $content;
    private $chapo;
    private $slug;
    private $author;
    private $creationDate;
    private $lastUpdateDate;

    public function __construct($datas)
    {
        $this->hydrate($datas);
    }

    public function hydrate($datas)
    {
        $this->setId($datas["id"]);
        $this->setTitle($datas['title']);
        $this->setContent($datas['content']);
        $this->setSlug($datas['title']);
        $this->setCreationDate(new \DateTime());
        $this->setLastUpdateDate(null);
//        $this->setAuthor(null);
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

    public function getChapo()
    {
        return substr($this->content, 0, 200)."...";
    }

    public function setChapo($chapo)
    {
        $this->chapo = $chapo;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($title)
    {
        $str = strtolower(trim($title));
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = preg_replace('/-+/', "-", $str);
        $slug = rtrim($str, '-');
        $this->slug = $slug;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function getLastUpdateDate()
    {
        return $this->lastUpdateDate;
    }

    public function setLastUpdateDate($lastUpdateDate)
    {
        $this->lastUpdateDate = $lastUpdateDate;
    }
}