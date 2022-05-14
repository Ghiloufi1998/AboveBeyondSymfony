<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 
use Symfony\Component\Serializer\Annotation\Groups;



class Weather
{
  
    /**
     * @var string
     *
     * 
     * @Groups("post:read")
     */     
public $speed ;
/**
     * @var string
     *
     * 
     * @Groups("post:read")
     */
public $temp;
/**
     * @var string
     *
     * 
     * @Groups("post:read")
     */
public  $disc;
/**
     * @var string
     *
     * 
     * @Groups("post:read")
     */
public  $weather;
/**
     * @var string
     *
     * 
     * @Groups("post:read")
     */
public $fl;
}