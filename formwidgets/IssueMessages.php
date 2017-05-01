<?php namespace Istheweb\IsCorporate\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Istheweb\IsCorporate\Models\Issue;

/**
 * IssueMessages Form Widget
 */
class IssueMessages extends FormWidgetBase
{

    /**
     * {@inheritDoc}
     */
    protected $defaultAlias = 'istheweb_iscorporate_issue_messages';

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
        return $this->makePartial('issuemessages');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['issue'] = Issue::with(['messages.user', 'creator'])->find($this->model->id);
    }

    /**
     * {@inheritDoc}
     */
    public function loadAssets()
    {
        $this->addCss('css/issuemessages.css', 'Istheweb.IsCorporate');
        $this->addJs('js/issuemessages.js', 'Istheweb.IsCorporate');
    }



}
