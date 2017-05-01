<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 16/01/17
 * Time: 15:22
 */

namespace istheweb\iscorporate\behaviors;

use Flash;
use Istheweb\IsCorporate\Models\IssueType;

class IssueTypeController extends BaseController
{

    /**
     * @return void
     */
    protected function deleteChecked()
    {
        foreach (post('checked') as $typeId) {
            if ( ! $type = IssueType::find($typeId)) {

                continue;
            }

            $type->delete();
        }

        Flash::success(trans('istheweb.iscorporate::lang.issuetype.delete_selected_success'));
    }

    /**
     * @return string
     */
    protected function getEmptyCheckMessage()
    {
        return trans('istheweb.iscorporate::lang.issuetype.delete_selected_empty');
    }

}
