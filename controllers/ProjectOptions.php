<?php namespace Istheweb\IsCorporate\Controllers;

use Backend\Facades\BackendAuth;
use Backend\Models\User;
use Backend\Models\UserGroup;
use BackendMenu;
use Backend\Classes\Controller;
use Carbon\Carbon;
use Istheweb\IsCorporate\Models\Employee;
use Istheweb\IsCorporate\Models\OptionValue;
use Istheweb\IsCorporate\Models\ProjectOption;
use Istheweb\Shop\Models\Option;
use Request;
use Flash;
use Redirect;

/**
 * Project Options Back-end Controller
 */
class ProjectOptions extends Controller
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

        BackendMenu::setContext('Istheweb.IsCorporate', 'iscorporate', 'projectoptions');
    }

    public function onSeedData()
    {

    }
}