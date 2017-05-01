<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 19/01/17
 * Time: 23:52
 */

namespace istheweb\iscorporate\behaviors;


use Istheweb\IsCorporate\Models\Budget;
use Istheweb\IsCorporate\Models\Invoice;
use Istheweb\IsCorporate\Models\Project;
use Istheweb\IsPdf\Classes\PDF;
use Istheweb\IsPdf\Models\PDFTemplate;
use Illuminate\Support\Facades\Redirect;
use October\Rain\Exception\ApplicationException;
use Flash;
use Event;
use Lang;

class BudgetController extends BaseController
{

    /**
     * @param $recordId
     * @return mixed
     */
    public function onGenerateInvoice($recordId)
    {
        $budget = Budget::getBudget($recordId);
        $invoice = Invoice::generateInvoiceFromBudget($budget);

        if($invoice){
            Flash::success(Lang::get('istheweb.iscorporate::lang.project.flash_created_message'));
        }else{
            Flash::error(Lang::get('istheweb.iscorporate::lang.project.flash_error_created_message'));
        }
        return Redirect::refresh();
    }


    /**
     * @param $recordId
     * @return mixed
     */
    public function onGenerateProject($recordId)
    {
        $budget = Budget::getBudget($recordId);
        $project = Project::generateProjectFromBudget($budget);

        if($project){
            $budget->is_project_created = 1;
            $budget->save();
            Flash::success(Lang::get('istheweb.iscorporate::lang.project.flash_created_message'));
        }else{
            Flash::error(Lang::get('istheweb.iscorporate::lang.project.flash_error_created_message'));
        }

        return Redirect::refresh();
    }

    /**
     * @param $recordId
     * @return mixed
     */
    public function onGeneratePdf($recordId)
    {
        $budget = Budget::getBudget($recordId);
        $pdf = $this->createPDF($budget->id);
        if($pdf){
            $pdf_arr = $budget->getPdfNames(true);
            $budget->invoice = $pdf_arr['number'];
            $budget->save();
            Flash::success('Se ha creado y guardado correctamente el pdf');
        }else{
            Flash::error('No se ha creado el pdf');
        }

        return Redirect::refresh();
    }

    /**
     * @param $recordId
     * @return mixed
     */
    public function onSend($recordId)
    {
        $budget = Budget::with(['client.company', 'client'])->findOrFail($recordId);
        Event::fire('budget.sendClient', [$budget]);
        $budget->estado = 4;
        $budget->save();

        Flash::success(Lang::get('istheweb.iscorporate::lang.send_email_client_success'));

        return Redirect::refresh();
    }

    /**
     * @param $recordId
     * @return mixed
     */
    public function preview($recordId){
        $budget = Budget::getBudget($recordId);
        $data = $budget->getData($budget->id, false);
        try {
            return PDF::loadTemplate(Budget::BUDGET_TEMPLATE_CODE, $data)->stream();
        } catch (ApplicationException $e) {
            $this->pageTitle = trans('istheweb.ispdf::lang.templates.preview');
            $this->vars['error'] = $e->getMessage();
        }
    }

    /**
     * @param $recordId
     * @return mixed
     */
    protected function createPDF($recordId)
    {
        $budget = Budget::getBudget($recordId);
        $data = $budget->getData($recordId, true);
        try
        {
            return PDF::loadTemplate(Budget::BUDGET_TEMPLATE_CODE, $data)->save('storage/app/media/presupuestos/'.$data['pdf']);
        } catch (Exception $e) {
            Flash::error($e->getMessage());
        }
    }

    public function getColumnValue($value){
        return Budget::getSelectedColumn($value);
    }

    /**
     *
     */
    protected function deleteChecked()
    {
        foreach (post('checked') as $issueId) {
            if ( ! $issue = Budget::find($issueId)) {
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