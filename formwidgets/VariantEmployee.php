<?php namespace Istheweb\IsCorporate\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * VariantEmployee Form Widget
 */
class VariantEmployee extends FormWidgetBase
{

    /**
     * {@inheritDoc}
     */
    protected $defaultAlias = 'istheweb_iscorporate_variant_employee';

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
        return $this->makePartial('variantemployee');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
        $this->vars['allEmployees'] = $this->model->getEmployees();
        $this->vars['budgets'] = $this->model->getBudgets();
    }

    /**
     * {@inheritDoc}
     */
    public function loadAssets()
    {
        $this->addCss('css/variantemployee.css', 'Istheweb.IsCorporate');
        $this->addJs('js/variantemployee.js', 'Istheweb.IsCorporate');
    }

    /**
     * {@inheritDoc}
     */
    public function getSaveValue($value)
    {
        return $value;
    }

}
