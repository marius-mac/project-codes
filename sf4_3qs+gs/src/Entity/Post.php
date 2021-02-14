<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ORM\Entity(repositoryClass="App\Repository\PostRepository")
*/
class Post
{
    /**
    * @ORM\Id
    * @ORM\GeneratedValue
    * @ORM\Column(type="integer")
    */
    private $id;

    /**
    * @ORM\Column(type="string", length=100)
    * @Assert\NotBlank()
    */
    private $title;

    /**
    * @ORM\Column(type="text")
    * @Assert\NotBlank()
    */
    private $content;

    /**
    * @ORM\Column(type="text")
    * @Assert\NotBlank()
    */
    private $excerpt;
 





        // setters and getters

            public function getId()
        {
            return $this->id;
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

        public function getExcerpt()
        {
            return $this->excerpt;
        }

        public function setExcerpt($excerpt)
        {
            $this->excerpt = $excerpt;
        }

        // end

}



