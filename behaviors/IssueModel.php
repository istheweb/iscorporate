<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 16/01/17
 * Time: 13:04
 */

namespace istheweb\iscorporate\behaviors;

use Backend\Facades\Backend;
use Backend\Facades\BackendAuth;
use Carbon\Carbon;
use Istheweb\IsCorporate\Models\IssueStatus;
use Istheweb\IsCorporate\Models\TicketStatus;
use Event;
use System\Classes\ModelBehavior;


class IssueModel extends ModelBehavior
{
    /**
     * @param \System\Classes\October\Rain\Database\Model $model
     * @throws \ApplicationException
     */
    public function __construct($model)
    {
        parent::__construct($model);
    }

    /**
     * @return void
     */
    public function close()
    {
        if ( ! $this->model->is_closed) {
            $this->model->is_closed = true;
            $this->model->save();

            Event::fire('issue.wasClosed', [$this->model]);
        }
    }

    /**
     * @return void
     */
    public function open()
    {
        if ($this->model->is_closed) {
            $this->model->is_closed = false;
            $this->model->save();

            Event::fire('issue.wasOpened', [$this->model]);
        }
    }

    /**
     * @return mixed
     */
    public function getOpenedCount()
    {
        return $this->model->opened()->count();
    }

    /**
     * @return mixed
     */
    public function getClosedCount()
    {
        return $this->model->closed()->count();
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return Backend::url('istheweb/iscorporate/issues/update/' . $this->model->id);
    }

    /**
     * @param $status
     */
    public function setStatus($status)
    {
        $this->model->status = $status;
        $this->model->status_updated_at = Carbon::now();
        $this->model->save();
    }

    /**
     * Delete ticket attachments
     */
    public function deleteAttachments()
    {
        foreach ($this->model->attachments as $file) {
            $file->delete();
        }
    }

    /**
     * @return void
     */
    public function setDefaults()
    {
        $this->model->creator = $this->model->creator ?: BackendAuth::getUser()->id;
        $this->model->status = IssueStatus::first()->id;
        $this->model->status_updated_at = Carbon::now();
    }

    public function getIssue()
    {
        //dd($this->model);
    }

    /**
     * @param $context
     * @return bool
     */
    public function isAllowedToUpdate($context)
    {
        return $context == 'update' && ! BackendAuth::getUser()->hasAccess('istheweb.iscorporate.access_other_issues');
    }
}