<?php

namespace App\Controller;

use App\Model\User;
use App\Core\Verificator;
use App\Model\Lesson;
use App\Model\LessonCommentaire as CommentaireManager;

class LessonCommentaire extends BaseController
{
    public function store() : void
    {
        $commentaireManager = new CommentaireManager();
        $lessonManager = new Lesson();
        $lesson = $lessonManager->setId($this->request->get("lesson_id"));
        if(!$lesson)
        {
            $this->session->addFlashMessage("error", "Lesson not found");
            $this->abort();
        }

        $errors = Verificator::checkForm($commentaireManager->getCommentaireForm($lesson->getId()), $this->request);
        if ($errors) {
            $this->session->addFlashMessage("error", $errors[0]);
            $this->route->redirect("/show/lesson/" . $this->request->get("lesson_id"));
        }

        $commentaireManager->setContent($this->request->get("content"));
        $commentaireManager->setLesson($this->request->get("lesson_id"));
        $commentaireManager->setUser(User::getUserConnected()->getId());

        $commentaireManager->save();
        $this->route->redirect("/show/lesson?lesson_id=" . $this->request->get("lesson_id"));
    }


    public function delete()
    {

    }

}