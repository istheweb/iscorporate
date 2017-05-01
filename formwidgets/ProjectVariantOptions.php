<?php namespace Istheweb\IsCorporate\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Istheweb\IsCorporate\Models\OptionValue;
use Istheweb\IsCorporate\Models\Variant;

/**
 * ProjectVariantOptions Form Widget
 */
class ProjectVariantOptions extends FormWidgetBase
{

    /**
     * {@inheritDoc}
     */
    protected $defaultAlias = 'istheweb_iscorporate_project_variant_options';

    /**
     * {@inheritDoc}
     */
    protected $project;

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
        return $this->makePartial('projectvariantoptions');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;

        $this->project = $this->vars['project'] = $this->controller->vars['formModel'];

        $this->vars['options'] = $this->getOptions();
    }

    /**
     * {@inheritDoc}
     */
    public function loadAssets()
    {
        $this->addCss('css/projectvariantoptions.css', 'Istheweb.IsCorporate');
        $this->addJs('js/projectvariantoptions.js', 'Istheweb.IsCorporate');
    }

    /**
     * {@inheritDoc}
     */
    public function getSaveValue($value)
    {
        //dd($value);
        if(is_array($value)){
            $arr = array();
            foreach ($value as $k => $v){
                $option = OptionValue::find($v);
                $arr[] = $option;
            }
        }

        if(isset($arr)) {
            return $arr;
        }else{
            return null;
        }
    }

    protected function getVariants()
    {
        return $this->controller->vars['formModel'];
    }

    protected function getOptions()
    {
        $options = $this->project->options;

        $arr = array();
        if(count($this->model->attributes) > 0){
            $variant = Variant::with('optionsValues')->find($this->model->id);
            foreach($variant->optionsValues as $option){
                $arr[] = $option->id;
            }
        }

        $this->vars['variants'] = $arr;

        $option_values = array();
        foreach($options as $option){
            $values = OptionValue::where('project_option_id', $option->id)->get();
            $items['name'] = $option->name;
            $items['code'] = $option->code;
            $items['price'] = $option->price;
            $items['option_value_id'] = $option->id;
            $items['optionValues'] = $values;
            $option_values[] = $items;
        }

        return $option_values;
    }

}
