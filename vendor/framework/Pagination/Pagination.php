<?php

namespace Framework\Pagination;


class Pagination
{
    private $actualPage = 0;
    private $totalPage;
    private $nbPerPage;

    public function __construct(array $datas, $nbPerPage = 10)
    {
        if (isset($_GET['page']) && ($_GET['page'] > 0)) {
            $this->actualPage = (int) $_GET['page'];
        }

        $this->totalPage = floor(count($datas)/$nbPerPage);
        $this->nbPerPage = $nbPerPage;
    }

    public function pagine(array $datas)
    {
        $paginatedData = [];

        $offset = $this->getActualPage()*$this->getNbPerPage();

        if ($this->getActualPage() > $this->getTotalPage()) {
            return header("Location: http://".ROOT."/posts?page=".$this->getTotalPage());
        }

        if($this->getActualPage() < 0) {
            return header("Location: http://".ROOT."/posts?page=1");
        }

        $paginatedData["datas"] = array_slice($datas, $offset, $this->getNbPerPage());
        $paginatedData["navigation"] = $this->createNavigation();
        return $paginatedData;
    }

    public function createNavigation()
    {
        $navigation = range(0, $this->getTotalPage());
        $actualPage = $this->getActualPage();

        $start = 3;
        $offset = $actualPage - $start;
        $length = $start * 2;

        if ($offset < 0) {
            return array_slice($navigation, 0, $length);
        }

        return array_slice($navigation, $offset, $length);
    }

    public function previous()
    {
        if($this->getActualPage() < 1) {
            return false;
        }

        return (int) $this->getActualPage() - 1;
    }

    public function next()
    {
        if(($this->getActualPage() + 1) > $this->getTotalPage()) {
            return false;
        }

        return (int) $this->getActualPage() + 1;
    }

    public function getActualPage()
    {
        return $this->actualPage;
    }

    public function setActualPage($actualPage)
    {
        $this->actualPage = $actualPage;
    }

    public function getTotalPage()
    {
        return $this->totalPage;
    }

    public function setTotalPage($totalPage)
    {
        $this->totalPage = $totalPage;
    }

    public function getNbPerPage()
    {
        return $this->nbPerPage;
    }

    public function setNbPerPage($nbPerPage)
    {
        $this->nbPerPage = $nbPerPage;
    }
}