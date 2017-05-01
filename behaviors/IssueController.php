<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 16/01/17
 * Time: 14:57
 */

namespace istheweb\iscorporate\behaviors;

use Backend\Facades\BackendAuth;
use Flash;
use Istheweb\IsCorporate\Models\Issue;
use Istheweb\IsCorporate\Models\IssueMessage;
use Istheweb\IsCorporate\Models\IssueStatus;
use Event;


class IssueController extends BaseController
{

    /**
     * @return mixed
     */
    public function index_onClose()
    {
        if ( ! $this->checked()) {
            Flash::error(trans('istheweb.iscorporate::lang.issue.close_selected_empty'));

            return;
        }

        $this->closeChecked();

        return $this->controller->listRefresh();
    }

    /**
     * @param $recordId
     * @return array
     * @throws \SystemException
     */
    public function onSendReply($recordId)
    {
        $issue = Issue::with(['messages.user', 'creator'])->findOrFail($recordId);
        $message = $this->createMessage($issue);

        Event::fire('issue.newReply', [$issue]);

        Flash::success(trans('istheweb.iscorporate::lang.message.success'));

        return ['@#messages-list' => $this->controller->makePartial('message', ['message' => $message])];
    }

    /**
     * @param $recordId
     * @return array
     * @throws \SystemException
     */
    public function update_onChangeStatus($recordId)
    {
        $issue = $this->controller->formFindModelObject($recordId);
        $issue->setStatus(post('status'));

        Flash::success(trans('istheweb.iscorporate::lang.status.success'));

        return $this->prepareChangeStatusResponse($issue);
    }

    /**
     * @param $recordId
     * @return mixed
     */
    public function update_onClose($recordId)
    {
        $issue = $this->controller->formFindModelObject($recordId);
        $issue->close();

        Flash::success(trans('istheweb.iscorporate::lang.issue.close_success'));

        return ['#close-ticket' => $this->controller->makePartial('open_btn', ['model' => $issue])];
    }

    /**
     * @param $recordId
     * @return mixed
     */
    public function update_onOpen($recordId)
    {
        $issue = $this->controller->formFindModelObject($recordId);
        $issue->open();

        Flash::success(trans('istheweb.iscorporate::lang.issue.open_success'));

        return ['#close-ticket' => $this->controller->makePartial('close_btn', ['model' => $issue])];
    }


    /**
     * @param Ticket $issue
     * @return mixed
     */
    private function createMessage(Issue $issue)
    {
        $message = new IssueMessage();
        $message->user = BackendAuth::getUser()->id;
        $message->messageable_id = $issue->id;
        $message->messageable_type = get_class($issue);
        $message->reply = post('Issue')['reply'];
        /*$message = IssueMessage::create([
            'user'   => BackendAuth::getUser()->id,
            'messageable_id' => $issue->id,
            'messageable_type'  => get_class($issue),
            'reply'  => post('Issue')['reply']
        ]);*/



        $issue->messages()->save($message);

        return $message;
    }

    /**
     * @return void
     */
    private function closeChecked()
    {
        foreach (post('checked') as $issueId) {
            if ( ! $issue = Issue::find($issueId)) {
                continue;
            }

            $issue->close();
        }

        Flash::success(trans('istheweb.iscorporate::lang.issue.close_selected_success'));
    }

    /**
     * @param Ticket $issue
     * @return array
     */
    protected function prepareChangeStatusResponse(Issue $issue)
    {
        return [
            '#change-status'  => $this->controller->makePartial('change_status_btn',
                ['model' => $issue, 'statuses' => IssueStatus::getActiveList()]),
            '.support-status' => $this->controller->makePartial('support_status', ['model' => $issue])
        ];
    }

    /**
     * @return void
     */
    protected function deleteChecked()
    {
        foreach (post('checked') as $issueId) {
            if ( ! $issue = Issue::find($issueId)) {
                continue;
            }

            $issue->delete();
        }

        Flash::success(trans('istheweb.iscorporate::lang.issue.delete_selected_success'));
    }

    /**
     * @return string
     */
    protected function getEmptyCheckMessage()
    {
        return trans('istheweb.iscorporate::lang.issue.delete_selected_empty');
    }

}