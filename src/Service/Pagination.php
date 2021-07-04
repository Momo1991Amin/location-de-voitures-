<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;


class Pagination {
    /**
     * Le nombre d'enregistrement à récupérer
     *
     * @var integer
     */
    private $limit = 6;

    /**
     * Le nom de l'entité sur laquelle on veut effectuer la pagination
     *
     * @var [type]
     */
    private $entityClass;

    /**
     * La page sur laquelle on se trouve actuellement
     *
     * @var integer
     */
    private $currentPage = 1;

    /**
     * Le
     *
     * @var [type]
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Récupère les donner dans la bdd avec une limite donnée     
     * @return void
     */
    public function getData() {
  
        $offset = $this->currentPage * $this->limit - $this->limit;

        $data = $this->manager->getRepository($this->entityClass)->findBy([],[],$this->limit,$offset);
 
        return $data;
    }

    /**
     * Permet de récupérer le nombre de pages qui existent sur une entité particulière
     *
     * @return void
     */
    public function getPages() {

        $total = ceil(count($this->manager->getRepository($this->entityClass)->findAll()));

        $pages = ceil($total / $this->limit);

        return $pages;
    }


    /**
     * Get le nombre d'enregistrement à récupérer
     *
     * @return  integer
     */ 
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Set le nombre d'enregistrement à récupérer
     *
     * @param  integer  $limit  Le nombre d'enregistrement à récupérer
     *
     * @return  self
     */ 
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Get le nom de l'entité sur laquelle on veut effectuer la pagination
     *
     * @return  [type]
     */ 
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * Set le nom de l'entité sur laquelle on veut effectuer la pagination
     *
     * @param  [type]  $entityClass  Le nom de l'entité sur laquelle on veut effectuer la pagination
     *
     * @return  self
     */ 
    public function setEntityClass( $entityClass)
    {
        $this->entityClass = $entityClass;

        return $this;
    }

    /**
     * Get la page sur laquelle on se trouve actuellement
     *
     * @return  integer
     */ 
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * Set la page sur laquelle on se trouve actuellement
     *
     * @param  integer  $currentPage  La page sur laquelle on se trouve actuellement
     *
     * @return  self
     */ 
    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;

        return $this;
    }

   
}