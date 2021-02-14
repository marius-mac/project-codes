<?php 
namespace AppBundle\Entity; 
use Doctrine\ORM\Mapping as ORM;  

/** 
   * @ORM\Entity 
   * @ORM\Table(name = "Books") 
*/  
class Book { 
   /** 
      * @ORM\Column(type = "integer") 
      * @ORM\Id 
      * @ORM\GeneratedValue(strategy = "AUTO") 
   */ 
   private $id;  
   
   /** 
      * @ORM\Column(type = "string", length = 50) 
   */ 
   private $name;  
    
   /** 
      * @ORM\Column(type = "string", length = 50) 
   */ 
      
   private $author;
   /** 
      * @ORM\Column(type = "decimal", scale = 2) 
   */ 
   private $price; 

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Book
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Book
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Book
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }
}
