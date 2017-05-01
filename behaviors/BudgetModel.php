<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 19/01/17
 * Time: 19:09
 */

namespace istheweb\iscorporate\behaviors;


use Illuminate\Support\Facades\Lang;
use Istheweb\IsCorporate\Models\Budget;
use Istheweb\IsCorporate\Models\Variant;
use Renatio\DynamicPDF\Classes\PDF;
use Renatio\DynamicPDF\Models\PDFTemplate;
use Istheweb\Connect\Models\CompanySettings;
use System\Classes\ModelBehavior;
use Illuminate\Support\Facades\Mail;
use Flash;

class BudgetModel extends ModelBehavior
{
    public function __construct($model)
    {
        parent::__construct($model);
    }

    public function getBudget($id){
        //dd($id);
        return Budget::find($id);
    }

    public function getScoresState(){
        foreach($this->model->getEstadoOptions() as $key => $value){
            $scores[] = $this->model->estado($key)->count();
        }

        return $scores;
    }

    public function isProjectVisible()
    {
        if($this->model->estado == 2 || $this->model->estado == 4 || $this->model->estado == 6){
            return true;
        }
        return false;
    }

    public function getTotalBudgets(){
        return Budget::all()->count();
    }

    public function getData($id, $is_created)
    {
        $company = CompanySettings::instance();
        $budget = $this->getBudget($id);
        $client = $budget->client;
        $sendto['email'] = $client->company->email;
        $sendto['name'] = $client->company->name;

        $pdf = $this->getPdfNames($is_created);
        $items = $budget->variants;
        $total = Variant::getTotal($items);

        $data = [
            'subject' => $budget->motivo,
            'email' => $client->company->email,
            'name'  => $client->company->name,
            'site'  => $company->name,
            'email-site' => $company->email,
            'company'   => $company,
            'address'   => $company->address,
            'client'    => $client,
            'budget'    => $budget,
            'pdf'    => $pdf['name'],
            'pdfNumber' => $pdf['number'],
            'items' => $items,
            'subtotal' => number_format($total, 2),
            'total' => number_format($total,2),
        ];
        return $data;
    }

    public function getPdfNames($is_count)
    {
        $count = Budget::invoice()->count();

        if($is_count){
            $count++;
        }

        $pdf = date('Y'). '-'.$count.'.pdf';
        $pdfNumber = date('Y'). '-'.$count;

        return [
            "name" => $pdf,
            'number' => $pdfNumber
        ];
    }

    public function getSelectedColumn($k){

        $array = $this->model->getEstadoOptions();
        foreach($array as $key => $value){
            if($k == $key) {
                return Lang::get($value);
            }
        }
    }

}