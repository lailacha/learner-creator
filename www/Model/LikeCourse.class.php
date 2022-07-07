<?php

namespace App\Model;

use App\Model\User;
use App\Core\QueryBuilder;
use App\Core\Sql;
use App\Model\Learner as LearnerModel;
use App\Model\CourseCategory;
use App\Model\CourseChapter;
use PDO;





class LikeCourse extends User 
{

    protected $id = null;
    protected  $course;
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
    public function getCourse(): ?int
    {
       
        return $this->course;
        
    }

    /**
     * @param int $course
     */
    public function setCourse(int $course): void
    {
        $this->course = $course;
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
     * This function get all the like by user
     */
    public function getCategoryLikeForm(): array
    {
        return ["config" => ["method" => "POST", "action" => "", "submit" => "like"],
        "inputs" => [ 
            
]]
;
    }

    public function getAllLike($user)
    {
        $query = new QueryBuilder();
        $course=  $query->from('likeCourse')
            ->where('user = :user')
            ->setParam('user', $user)
            ->fetch("course");
            return $course;
     
    }
  


    
}