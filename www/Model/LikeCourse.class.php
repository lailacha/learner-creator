<?php

namespace App\Model;

use App\Model\User;
use App\Core\QueryBuilder;
use App\Core\Sql;
use App\Model\Learner as LearnerModel;
use App\Model\CourseCategory;
use App\Model\CourseChapter;
use App\Model\Course;
use PDO;





class LikeCourse extends sql 
{

    protected $id = null;
    protected  $course;
    protected  $user;

    public function __construct()
    {
        //echo "constructeur du Model User";
        parent::__construct();
        $this->table  = DBPREFIXE."likeCourse";
    }
    public function save(): void
    {
        parent::save();
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
    
    public function getAllLike($user)
    {
        
            $query = new QueryBuilder();
            return $query->select('course')
                 ->from('likeCourse')
                 ->where('user = :user')
                 
                 ->setParams([
                     'user' => $user,
                     
                 ])
                 ->fetch("course");    
     
    }
    public function getSaveLike($course_id, $user_id)
    {
        $query = "SELECT EXISTS ( SELECT * FROM ". $this->table ." WHERE course = " . $course_id." && user=".$user_id.") AS like_exists";
        $req = $this->pdo->prepare($query);
        $req->execute();
        $res = $req->fetch();
        if ($res['like_exists'] == false) { 
            return 0;
        } else{
            return 1;
        }
    }

    public function getSaveLikes($user_id)
    {
        $query = "SELECT EXISTS ( SELECT * FROM ". $this->table ." WHERE user=".$user_id.") AS like_exists";
        $req = $this->pdo->prepare($query);
        $req->execute();
        $res = $req->fetch();
        if ($res['like_exists'] == false) { 
        return 0;
            } else{
                return 1;
            }
     
    }
     public function deleteLike($course_id, $user_id)
    {
        $query = "DELETE FROM ".$this->table ." WHERE course = ".$course_id." AND user=".$user_id;
        $req = $this->pdo->prepare($query);
        $req->execute();
    }
   /*  public function getCourseFav($course)
    {
        $query = new QueryBuilder();
        $course = $query->from('course')
            ->where('id = :course')
            ->setParam('course', $course)
            ->fetch("");
            return $course;
     
    } */
    


    
}