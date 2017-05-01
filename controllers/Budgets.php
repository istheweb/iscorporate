<?php namespace Istheweb\IsCorporate\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Istheweb\IsCorporate\Models\Budget;
use Renatio\DynamicPDF\Models\PDFTemplate;
use Flash;

/**
 * Budgets Back-end Controller
 */
class Budgets extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
        'Istheweb.IsCorporate.Behaviors.BudgetController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Istheweb.IsCorporate', 'iscorporate', 'budgets');
    }


    public function index()
    {
        $this->vars['scores'] = Budget::getScoresState();
        $this->vars['total']  = Budget::getTotalBudgets();
        $this->asExtension('ListController')->index();
    }



}