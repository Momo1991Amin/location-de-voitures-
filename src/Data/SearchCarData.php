<?php
namespace App\Data;

use App\Entity\Category;

class SearchCarData 
{
    /**
     * @var string
     *
     */
    public $car = '';

    /**
     * @var Category[]
     *
     */
    public $category= [];

    /**
     * @var null|integer
     *
     */
    public $min;

    /**
     * @var null|integer
     *
     */
    public $max;

    /**
     *
     * @var integer
     */
    public $page = 1;
}