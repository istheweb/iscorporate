<?php namespace Istheweb\IsCorporate\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Istheweb\IsCorporate\Models\Budget;
use Istheweb\IsCorporate\Models\Employee;
use Istheweb\IsCorporate\Models\Project;

/**
 * Projects Back-end Controller
 */
class Projects extends Controller
{
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

        BackendMenu::setContext('Istheweb.IsCorporate', 'iscorporate', 'projects');

        $this->preparevars();
    }

    protected function preparevars(){

    }

    /**
     * @return void
     */
    public function index()
    {
        $this->vars['completed'] = Project::getCompletedCount();
        $this->vars['open'] = Project::getOpenedCount();
        $this->vars['closed'] = Project::getClosedCount();

        $this->asExtension('ListController')->index();
    }

    public function getColumnValue($value, $column){
        return Project::getSelectedColumn($value, $column);
    }



}