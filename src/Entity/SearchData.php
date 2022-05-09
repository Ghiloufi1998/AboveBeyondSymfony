<?php

namespace App\Entity;

use App\Entity\Sondage;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


class SearchData
{
    /**
     * @var string|Null
     *
     *
     */
    public $SearchBar="";

    /**
     * @var App\Entity\Sondage 
     *
     * 
     */
    public $sondage=[];

   /* public function __construct()
    {
        $this->sondage = new ArrayCollection();
    }*/


 /*   public function getSearchBar(): ?string
    {
        return $this->SearchBar;
    }

    public function setSearchBar(string $SearchBar): self
    {
        $this->SearchBar = $SearchBar;

        return $this;
    }*/

    
/**
 *  @return Collection|null
 */

   /* public function getSondage(): ?Collection
    {
        return $this->sondage;
    }

    public function setSondage(?Sondage $sondage): self
    {
        $this->sondage = $sondage;

        return $this;
    }*/



    
}