<?php namespace Istheweb\IsCorporate\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Istheweb\IsCorporate\Models\Invoice;

/**
 * Invoices Back-end Controller
 */
class Invoices extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
        'Istheweb.IsCorporate.Behaviors.InvoiceController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Istheweb.IsCorporate', 'iscorporate', 'invoices');
    }

    public function index()
    {
        $this->vars['scores'] = Invoice::getTotalByPaymentType();
        $this->vars['total']  = Invoice::getTotalInvoices();
        $this->vars['statuses'] = Invoice::getScoresStatus();
        $this->asExtension('ListController')->index();
    }

    public function getColumnValue($value){
        return Invoice::getSelectedColumn($value);
    }
}