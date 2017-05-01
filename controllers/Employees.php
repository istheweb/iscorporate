<?php namespace Istheweb\IsCorporate\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Backend\Models\User;
use Backend\Models\UserGroup;
use Istheweb\IsCorporate\Models\Employee;

/**
 * Employees Back-end Controller
 */
class Employees extends Controller
{

    public $requiredPermissions = ['istheweb.iscorporate.access_employees'];

    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
        'Istheweb.Connect.Behaviors.DeleteList'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $bodyClass = 'compact-container';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Istheweb.IsCorporate', 'iscorporate', 'employees');
    }

    /**
     * Called before the creation form is saved.
     * @param Model
     */
    public function formBeforeCreate( $model )
    {
        $user = post(Employee::MODEL_NAME)['user'];
        $model->user = User::create([
            'login'                  => $user['login'],
            'email'                 => $user['email'],
            'first_name'            => $user['first_name'],
            'last_name'             => $user['last_name'],
            'password'              => $user['password'],
            'password_confirmation' => $user['password_confirmation'],
            'permissions'           => [],
            'is_superuser'          => false,
            'is_activated'          => true
        ]);
        $connect = UserGroup::whereCode(Employee::USER_GROUP_CODE)->first();
        $model->user->addGroup($connect);
    }
}