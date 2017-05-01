<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 16/01/17
 * Time: 15:21
 */

namespace istheweb\iscorporate\behaviors;

use Flash;
use Istheweb\IsCorporate\Models\IssueStatus;

class IssueStatusController extends BaseController
{

    /**
     * @return void
     */
    protected function deleteChecked()
    {
        foreach (post('checked') as $statusId) {
            if ( ! $status = IssueStatus::find($statusId)) {
                continue;
            }

            $status->delete();
        }

        Flash::success(trans('istheweb.iscorporate::lang.issuestatus.delete_selected_success'));
    }

    /**
     * @return string
     */
    protected function getEmptyCheckMessage()
    {
        return trans('istheweb.iscorporate::lang.issuestatus.delete_selected_empty');
    }

}