<?php

namespace App\Model;

use App\Model\User;
use App\Core\QueryBuilder;
use App\Core\Sql;
use App\Model\Learner as LearnerModel;
use App\Model\CourseCategory;
use App\Model\CourseChapter;





class Learner extends User 
{

    protected $id = null;
    protected  $category = null;
    protected  $user;

    public function __construct()
    {
        //echo "constructeur du Model User";
        parent::__construct();
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
    public function getCategory(): int
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
    // public function getPreferences() : array
    // {
    //     $preferences = [];
    //     $categories = $this->getCategories();
    //     foreach ($categories as $category) {
    //         $preferences[$category->getId()] = $this->getPreference($category->getId());
    //     }
    //     return $preferences;
    // }


}