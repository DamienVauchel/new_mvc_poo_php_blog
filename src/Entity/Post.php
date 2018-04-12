<?php

namespace Entity;


/**
 * Class Post
 * @package Entity
 */
class Post
{
    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $title;
    /**
     * @var
     */
    private $content;
    /**
     * @var
     */
    private $chapo;
    /**
     * @var
     */
    private $slug;
    /**
     * @var
     */
    private $author;
    /**
     * @var
     */
    private $creationDate;
    /**
     * @var
     */
    private $lastUpdateDate;

    /**
     * Post constructor.
     * @param $datas
     */
    public function __construct($datas)
    {
        $this->hydrate($datas);
    }

    /**
     * @param $datas
     */
    public function hydrate($datas)
    {
        $this->setId($datas["id"]);
        $this->setTitle($datas['title']);
        $this->setContent($datas['content']);
        $this->setSlug($datas['title']);
        $this->setAuthor($datas['author']);
        $this->setCreationDate($datas['creation_date']);
        $this->setLastUpdateDate($datas['last_update_date']);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getChapo()
    {
        return substr($this->content, 0, 200)."...";
    }

    /**
     * @param $chapo
     */
    public function setChapo($chapo)
    {
        $this->chapo = $chapo;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param $title
     */
    public function setSlug($title)
    {
        $str = strtolower(trim($title));
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = preg_replace('/-+/', "-", $str);
        $slug = rtrim($str, '-');
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param $creationDate
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return mixed
     */
    public function getLastUpdateDate()
    {
        return $this->lastUpdateDate;
    }

    /**
     * @param $lastUpdateDate
     */
    public function setLastUpdateDate($lastUpdateDate)
    {
        $this->lastUpdateDate = $lastUpdateDate;
    }
}