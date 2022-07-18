<?php


namespace App\Controller;

use App\Controller\BaseController;
use App\Core\FormBuilder;
use App\Core\View;
use App\Core\Verificator;
use App\Model\CourseCategory as CourseCategoryModel;
use App\Model\Course;



class CourseCategory extends BaseController
{



    public function getOneCategory(): void
    {
        $categorie = new CourseCategoryModel();
      
      
        $categorie = $categorie->getBy('id', $this->request->get('category_id'));
    
        if(!$categorie){
            $this->route->goBack();
            $this->session->addFlashMessage("error", "Cette catégorie n'existe pas");
        }

        $courseManager = new Course();
        $courses = $courseManager->getAllBy("category", $this->request->get('category_id'));

        $view = new View("courses/showByCategorie",);
        $view->assign("categorie", $categorie);
        $view->assign("courses", $courses);
    }

    public function allCategories(): void
    {
        $courseCategoryManger = new CourseCategoryModel();
        $categories = $courseCategoryManger->getAll();
        $view = new View("courses/allCategories");
        $view->assign("categories", $categories);
    }

    public function create(): void
    {   
        $courseCategoryManger = new CourseCategoryModel();
        $allCategory = $courseCategoryManger->getAll();
        $form = FormBuilder::render($courseCategoryManger->getCategoryForm());
        $view = new View("courses/createCategory", "back");
        $view->assign("form", $form);
        $view->assign("categories", $allCategory);
    }

    public function save(): void
    {
        $courseCategoryManger = new CourseCategoryModel();
        $errors = Verificator::checkForm($courseCategoryManger->getCategoryForm(), $this->request);
        if ($errors) {
           $this->route->goBack();
           $this->session->addFlashMessage("error", $errors[0]);
        } else {
            $category = new CourseCategoryModel();
            $category->setName($this->request->get('name'));
            $category->setDescription($this->request->get('description'));
            $category->save();
            $this->route->goBack();
            $this->session->addFlashMessage("success", "Category created");
        }
    }

    public function edit(): void
    {
        $courseCategoryManger = new CourseCategoryModel();
        $category = $courseCategoryManger->setId($this->request->get('category_id'));
        $form = FormBuilder::render($category->editCategory());
        $view = new View("courses/editCategory", "back");
        $view->assign("form", $form);
        $view->assign("category", $category);
    }

    public function update(): void
    {
        $courseCategoryManger = new CourseCategoryModel();
        $category = $courseCategoryManger->setId($this->request->get('category_id'));
        $errors = Verificator::checkForm($category->editCategory(), $this->request);
        if ($errors) {
           $this->route->goBack();
           $this->session->addFlashMessage("error", $errors[0]);
        } else {
           
            if($this->request->get('name')){
                $category->setName($this->request->get('name'));
            }

            if($this->request->get('description')){
                $category->setDescription($this->request->get('description'));
            }
            
            $category->save();
            $this->route->redirect('/category');
            $this->session->addFlashMessage("success", "Category updated");
        }
    }

    public function delete(): void
    {
        $courseCategoryManger = new CourseCategoryModel();
        $category = $courseCategoryManger->setId($this->request->get("id"));
        $category->delete();
        $category->save();
        $this->session->addFlashMessage("success", "Category deleted");
        $this->route->goBack();
    }
    

}