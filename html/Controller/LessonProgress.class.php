<?php

namespace App\Controller;

use App\Model\LessonProgress as LessonProgressManager;

class LessonProgress extends BaseController
{
    public function store() : void
    {
        $lessonManager = new LessonProgressManager();
        $lesson = $lessonManager->getOneByMany(["lesson" => $this->request->get('lesson_id'), "user" => $this->request->get('user_id')]);
        if($lesson && $this->request->get("progress") !== "true")
        {                
             $lesson->delete();
            return;

        }

        $newProgress = new LessonProgressManager();
        $newProgress->setUser($this->request->get('user_id'));
        $newProgress->setLesson($this->request->get('lesson_id'));
        $newProgress->save();
        
    }

}