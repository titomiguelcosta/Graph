<?php

namespace Uniregistry\Model;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @package Uniregistry\Model
 * @JMS\ExclusionPolicy("all")
 * @JMS\XmlRoot("queries")
 */
class Query
{
    /**
     * @var ArrayCollection
     * @JMS\Expose()
     * @JMS\Type("ArrayCollection<Uniregistry\Model\Path>")
     */
    protected $paths;

    /**
     * @var ArrayCollection
     * @JMS\Expose()
     * @JMS\Type("ArrayCollection<Uniregistry\Model\Path>")
     */
    protected $cheapest;

    public function __construct()
    {
        $this->paths = new ArrayCollection();
        $this->cheapest = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getPaths()
    {
        if (false === $this->paths instanceof ArrayCollection) {
            $this->paths = new ArrayCollection();
        }

        return $this->paths;
    }

    /**
     * @param ArrayCollection $paths
     * @return Query
     */
    public function setPaths(ArrayCollection $paths)
    {
        $this->paths = $paths;

        return $this;
    }

    /**
     * @param Path $path
     * @return Query
     */
    public function addPath(Path $path)
    {
        $this->getPaths()->add($path);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCheapest()
    {
        if (false === $this->cheapest instanceof ArrayCollection) {
            $this->cheapest = new ArrayCollection();
        }

        return $this->cheapest;
    }

    /**
     * @param ArrayCollection $cheapest
     * @return Query
     */
    public function setCheapest(ArrayCollection $cheapest)
    {
        $this->cheapest = $cheapest;

        return $this;
    }

    /**
     * @param Path $path
     * @return Query
     */
    public function addCheapest(Path $path)
    {
        $this->getCheapest()->add($path);

        return $this;
    }

    /**
     * @Assert\IsTrue(message="At least on path must be defined")
     * @return boolean
     */
    public function hasAtLeastOnePath()
    {
        return $this->getPaths()->count() + $this->getCheapest()->count() > 0;
    }
}