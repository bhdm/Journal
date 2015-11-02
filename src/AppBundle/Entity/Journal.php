<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 02.11.15
 * Time: 13:41
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Journal extends BaseEntity
{
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Название журнала - обязательное поле")
     */
    protected $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $photo;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Post", mappedBy="journal")
     */
    protected $posts;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Год выпуска - обязательное поле")
     */
    protected $year;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Месяц выпуска - обязательное поле")
     */
    protected $month;

    public function __construct(){
        $this->posts = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return mixed
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param mixed $posts
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param mixed $month
     */
    public function setMonth($month)
    {
        $this->month = $month;
    }
}