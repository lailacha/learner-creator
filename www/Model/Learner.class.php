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
    public function getCategory(): ?int
    {
       
        return $this->category;
        
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
     
    }

    public function getCategoryPrefForm(): array
    {
        $categories = new CourseCategory();
        
    return ["config" => ["method" => "POST", "action" => "/save/categoriepref", "submit" => "Ajouter une préfére"],
            "inputs" => [ 
                "role" => [
                    "type" => "select",
                    "id" => "jjj",
                    "class" => "formRegister",
                    "options" => [
                        "data" =>
                            $categories->getCategories(),
                        "property" => "name",
                        "value" => "id",
                        "selected" => 1

                    ]]
    ]]
    ;
    }
}