<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 20/01/17
 * Time: 15:32
 */

namespace istheweb\iscorporate\behaviors;


use Carbon\Carbon;
use Istheweb\Connect\Models\CompanySettings;
use Istheweb\IsCorporate\Models\Invoice;
use Istheweb\IsCorporate\Models\Variant;
use System\Classes\ModelBehavior;
use Lang;

class InvoiceModel extends ModelBehavior
{
    public function __construct($model)
    {
        parent::__construct($model);
    }

    public function generateInvoiceFromBudget($budget)
    {
        $invoice = $this->model->firstOrNew(['budget_id' => $budget->id]);
        $invoice->client = $budget->client;
        $invoice->budget = $budget;
        $invoice->invoice_number = $this->formatNumberInvoice();
        $invoice->invoice_date = Carbon::now();
        $invoice->project_types = $budget->project_types;
        $invoice->options = $budget->options;
        $totals = $this->getTotal($budget->variants);
        $invoice->taxable_base = $totals['taxable_base'];
        $invoice->tax = $totals['tax'];
        $invoice->total = $totals['total'];
        $invoice->status = 1;

        $invoice->save();
        if(!$budget->variants->isEmpty()){
            foreach($budget->variants as $variant){
                $p_variant = Variant::createVariant($invoice, $variant);
                //dd($p_variant);
                $invoice->variants()->add($p_variant);
            }
        }

        return $invoice;
    }

    public function getTotalInvoices(){
        return Invoice::all()->count();
    }

    public function getScoresStatus(){
        foreach($this->model->getStatusOptions() as $key => $value){
            $scores[] = $this->model->status($key)->count();
        }

        return $scores;
    }

    public function getTotalByPaymentType(){
        foreach($this->model->getPaymentTypeOptions() as $key => $value){
            $scores[] = $this->model->status($key)->count();
        }

        return $scores;
    }

    public function getSelectedColumn($k){

        $array = $this->model->getStatusOptions();
        foreach($array as $key => $value){
            if($k == $key) {
                return Lang::get($value);
            }
        }
    }

    public function getData($id, $is_created)
    {
        $company = CompanySettings::instance();
        $invoice = Invoice::find($id);
        $client = $invoice->client;
        $sendto['email'] = $client->company->email;
        $sendto['name'] = $client->company->name;

        $items = $invoice->variants;
        $total = $this->getTotal($items);

        $data = [
            'subject' => $invoice->motivo,
            'email' => $client->company->email,
            'name'  => $client->company->name,
            'site'  => $company->name,
            'email-site' => $company->email,
            'company'   => $company,
            'address'   => $company->address,
            'client'    => $client,
            'invoice'    => $invoice,
            'items' => $items,
            'subtotal' => number_format($total, 2),
            'total' => number_format($total,2),
        ];
        return $data;
    }

    protected function formatNumberInvoice(){
        $company = CompanySettings::instance();
        $format = $company->company_name_nid.'-';
        $count = Invoice::all()->count();

        if($count == 0){
            $number = $company->invoice_number;
        }else{
            $number = Invoice::invoiceNumber()->first();
            $split_number = last(explode('-', $number));
            $number = $split_number + 1;
        }
        if($company->is_year_invoice == 1){
            if($company->position_year_number == 'before'){
                $format .= Carbon::now()->year.'-'.$number;
            }else{
                $format .= $number.'-'.Carbon::now()->year;
            }
        }else{
            $format .= $number;
        }
        return $format;
    }

    protected function getTotal($data){
        $taxable_base = Variant::getTotal($data);
        /**
         * TODO: Gestionar dinámicamente los tipos de IVA
         */
        $tax = $taxable_base * 0.21;
        $total = $taxable_base + $tax;
        return [
           'taxable_base'   => $taxable_base,
            'tax'           => $tax,
            'total'         => $total
        ];
    }
}