<?php


namespace App\Controller;

use App\Core\Verificator;
use App\Core\View;
use App\Model\ReportComment as ReportCommentModel;
use InvalidArgumentException;

class ReportComment extends BaseController
{

    public function showAll() : void
    {
        $reportCommentModel = new ReportCommentModel();
        $reportComments = $reportCommentModel->getAll();
        $view = new View('showReportsComments', 'back');
        $view->assign('comments', $reportComments);
    }

//    public function reportComment(): void
//    {
//        $reportManager = new ReportCommentModel();
//
//        if($this->request->get('user_id') && $this->request->get('comment_id') && $this->request->get('reason'))
//        {
//            $reportManager->setUser($this->request->get('user_id'));
//            $reportManager->setComment($this->request->get('comment_id'));
//            $reportManager->setReason($this->request->get('reason'));
//            $reportManager->save();
//        }
//        else {
//            $this->abort(400, 'Missing parameters');
//        }
//
//    }

    /**
     * @return void
     * Create a report comment base on a comment id and a reason send by the user
     */
    public function reportComment()
    {
        $reportCommentModel = new ReportCommentModel();
        $verification = Verificator::checkForm($reportCommentModel->getReportForm($this->request->get('comment_id')), $this->request);

        try {
        $reportCommentModel->setUser(\App\Model\User::getUserConnected()->getId());
        $reportCommentModel->setComment($this->request->get('comment_id'));
        $reportCommentModel->setReason($this->request->get('reason'));
        $reportCommentModel->save();

        }
        catch(\InvalidArgumentException $e)
        {
            $this->session->addFlashMessage('error', $e->getMessage());
        }

        $this->route->goBack();
    }

}