<?php

namespace App\Model;

use App\Model\User;
use App\Core\QueryBuilder;
use App\Core\Sql;
use App\Model\Learner as LearnerModel;
use App\Model\CourseCategory;
use App\Model\CourseChapter;
use PDO;





class Learner extends User 
{

    protected $id = null;
    protected  $category = null;
    protected  $user;

    public function __construct()
    {
        //echo "constructeur du Model User";
        parent::__construct();
        $this->table  = DBPREFIXE."learner";
    }
    

    /**
     * @return null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return void
     */
    public function getCategory(): void
    {
       
       echo "yes";
        
    }

    /**
     * @param int $category
     */
    public function setCategory(int $category): void
    {
        $this->category = $category;
    }
    /**
     * @return int
     */
    public function getUser(): int
    {
        return $this->user;
    }

    /**
     * @param int $user
     */
    public function setUser(int $user): void
    {
        $this->user = $user;
    }
    
    /*
     * This function get all the categories preferences by User
     */
    //  public function getPreferences() : array
    //  {
    //         $sql = "SELECT * FROM ".$this->table." WHERE user=:user";
    //         $queryPrepared = $this->pdo->prepare($sql);
    //         $queryPrepared->execute( ["user"=>$this->user] );
    //         return $queryPrepared->fetchAll(PDO::FETCH_CLASS, get_called_class());
    //  }

    public function getAllCategories($user)
    {
        $query = new QueryBuilder();
       return $query->select('category')
            ->from('learner')
            ->where('user = :user')
            
            ->setParams([
                'user' => $user,
                
            ])
            ->fetch("category");
                
           // return $this->getCourse($query);
       
        
    }
    public function getAllCourses($category)
    {
        $query = new QueryBuilder();
        return  $query->select('*')
            ->from('learner')
            ->innerJoin('course',DBPREFIXE.'course.category',DBPREFIXE.'learner.category')
            ->where('learner.category = :category')
            ->setParams([
                'category' => $category,
            ])
            ->fetchAllByClass(__CLASS__);
    }
   
}