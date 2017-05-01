<?php namespace Istheweb\IsCorporate\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Issue Statuses Back-end Controller
 */
class IssueStatuses extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Istheweb.IsCorporate.Behaviors.IssueStatusController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Istheweb.IsCorporate', 'iscorporate', 'issuestatuses');
    }
}