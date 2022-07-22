<?php

namespace App\Model;

use App\Model\User;
use App\Core\QueryBuilder;
use App\Core\Sql;
use App\Model\CourseCategory;

class Learner extends sql 
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
    public function save(): void
    {
        parent::save();
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
        $res = $query->select('category')
            ->from('learner')
            ->where('user = :user')
            
            ->setParams([
                'user' => $user,
                
            ])
            ->fetchAll("category");
            
    
        return $res;
    
}
/* //SELECT * FROM `esgi_learner` INNER JOIN `esgi_course_category` ON `esgi_learner`.category = `esgi_course_category`.id WHERE `category` = 3;
public function getAllCategoriesP()
    {
        $category = 3;
        $query = new QueryBuilder();
        return  $query->select('*')
            ->from('learner')
            ->innerJoin('course_category', DBPREFIXE.'learner.category ='.DBPREFIXE.'course_category.id')
            ->where('category = :category')
            ->setParams([
                'category' => $category,
            ])
            ->fetch("name");
    
} */

public function checkPrefUser($user_id)
{
    $query = "SELECT EXISTS ( SELECT * FROM ". $this->table ." WHERE user=".$user_id.") AS pref_exists";
        $req = $this->pdo->prepare($query);
        $req->execute();
        $res = $req->fetch();
        if ($res['pref_exists'] == false) { 
        return 0;
            } else{
                return 1;
            }
    
}
public function catVerif($user,$course){

    $query = "SELECT EXISTS ( SELECT * FROM `esgi_learner` WHERE user=".$user." AND category=".$course.") AS pref_exists";
    $req = $this->pdo->prepare($query);
    $req->execute();
    $res = $req->fetch();
    return $res['pref_exists'];
    
    
}


public function getAllUserPrefByCategory($category)
{
    $query = new QueryBuilder();
    $res = $query->select('*')
        ->from('learner')
        ->innerJoin('user', 'learner.user = user.id')
        ->where('category = :category')
        ->fetchAllByClass(User::class);
    return $res;
}


public function deleteCatPref($user,$course){

    $query = "DELETE FROM ".$this->table." WHERE user=".$user." AND category=".$course;
    $req = $this->pdo->prepare($query);
    $req->execute();
    $res = $req->fetch();
    return $res;
    
    
}


    public function getCategoryPrefForm(): array
    {
        $categories = new CourseCategory();
        
    return ["config" => ["method" => "POST", "action" => "/save/catpref", "class" => "form" ,"submit" => "Ajouter une catégorie préférée"],
            "inputs" => [ 
                "category" => [
                    "type" => "select",
                    "id" => "categorySelect",
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