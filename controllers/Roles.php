<?php namespace Istheweb\IsCorporate\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Roles Back-end Controller
 */
class Roles extends Controller
{
    public $requiredPermissions = ['istheweb.iscorporate.access_employees'];

    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
        'Istheweb.IsCorporate.Behaviors.DeleteList'

    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Istheweb.IsCorporate', 'iscorporate', 'roles');
    }
}