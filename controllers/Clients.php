<?php namespace Istheweb\IsCorporate\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Istheweb\IsCorporate\Models\Budget;
use Istheweb\IsCorporate\Models\Client;

/**
 * Clients Back-end Controller
 */
class Clients extends Controller
{
    public $requiredPermissions = ['istheweb.iscorporate.access_clients'];

    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
        'Istheweb.Connect.Behaviors.DeleteList'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';


    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Istheweb.IsCorporate', 'iscorporate', 'clients');
    }

    public function update($recordId, $context = null)
    {
        $client = Client::with('budgets')->find($recordId);

        foreach($client->budgets as $budget)
        {
            $project_types = $budget->project_types;
            $project_options = $budget->options;
            //dd($budget->variants);
            $project_variants = $budget->variants;
        }

        if(count($client->budgets) > 0){
            $this->vars['project_types'] = $project_types;
            $this->vars['options']  = $project_options;
            $this->vars['variants'] = $project_variants;
        }

        // Call the FormController behavior update() method
        return $this->asExtension('FormController')->update($recordId, $context);
    }

    public function getColumnValue($value){
        return Budget::getSelectedColumn($value);
    }
}