<?php namespace Istheweb\IsCorporate\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Istheweb\IsCorporate\Models\IssueStatus;

/**
 * IssueToolbar Form Widget
 */
class IssueToolbar extends FormWidgetBase
{

    /**
     * {@inheritDoc}
     */
    protected $defaultAlias = 'istheweb_iscorporate_issue_toolbar';

    /**
     * {@inheritDoc}
     */
    public function init()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('issuetoolbar');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['statuses'] = IssueStatus::active()->get()->lists('name', 'id');
        $this->vars['model'] = $this->model;
    }

    /**
     * {@inheritDoc}
     */
    public function loadAssets()
    {
        $this->addCss('css/issuetoolbar.css', 'Istheweb.IsCorporate');
        $this->addJs('js/issuetoolbar.js', 'Istheweb.IsCorporate');
    }



}
