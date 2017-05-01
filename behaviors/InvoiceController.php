<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 22/01/17
 * Time: 17:53
 */

namespace istheweb\iscorporate\behaviors;

use Flash;
use Event;
use Istheweb\IsCorporate\Models\Invoice;
use istheweb\ispdf\classes\PDF;
use Lang;
use Illuminate\Support\Facades\Redirect;
use October\Rain\Exception\ApplicationException;

class InvoiceController extends BaseController
{

    /**
     * @param $recordId
     * @return mixed
     */
    public function onGeneratePdf($recordId)
    {
        $invoice = Invoice::find($recordId);
        $pdf = $this->createPDF($invoice->id);
        if($pdf){
            $invoice->is_pdf = 1;
            $invoice->save();
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
        $invoice = Invoice::with(['client.company', 'client'])->findOrFail($recordId);
        Event::fire('invoice.sendClient', [$invoice]);
        $invoice->client_sent = 1;
        $invoice->save();

        Flash::success(Lang::get('istheweb.iscorporate::lang.send_email_client_success'));

        return Redirect::refresh();
    }

    /**
     * @param $recordId
     * @return mixed
     */
    public function preview($recordId){
        $invoice = Invoice::find($recordId);
        $data = $invoice->getData($invoice->id, false);
        try {
            return PDF::loadTemplate(Invoice::INVOICE_TEMPLATE_CODE, $data)->stream();
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
        $invoice = Invoice::find($recordId);
        $data = $invoice->getData($recordId, true);
        try
        {
            return PDF::loadTemplate(Invoice::INVOICE_TEMPLATE_CODE, $data)->save('storage/app/media/facturas/'.$invoice->invoice_number.'.pdf');
        } catch (Exception $e) {
            Flash::error($e->getMessage());
        }
    }

    /**
     *
     */
    protected function deleteChecked()
    {
        foreach (post('checked') as $issueId) {
            if ( ! $issue = Invoice::find($issueId)) {
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