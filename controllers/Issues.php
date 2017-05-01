<?php namespace Istheweb\IsCorporate\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Istheweb\IsCorporate\Models\Issue;

/**
 * Issues Back-end Controller
 */
class Issues extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Istheweb.IsCorporate.Behaviors.IssueController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        $this->addCss('/plugins/istheweb/iscorporate/assets/css/main.css', 'Istheweb.IsCorporate');
        $this->addJs('/plugins/istheweb/iscorporate/assets/js/main.js', 'Istheweb.IsCorporate');

        BackendMenu::setContext('Istheweb.IsCorporate', 'iscorporate', 'issues');
    }

    /**
     * @return void
     */
    public function index()
    {
        $this->vars['open'] = Issue::getOpenedCount();
        $this->vars['closed'] = Issue::getClosedCount();

        $this->asExtension('ListController')->index();
    }

    /**
     * @param Ticket $ticket
     * @return string
     */
    public function listInjectRowClass(Issue $issue)
    {
        if ($issue->is_closed) {
            return 'strike';
        }
    }
}