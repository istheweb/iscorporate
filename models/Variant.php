<?php namespace Istheweb\IsCorporate\Models;

use Backend\Facades\BackendAuth;
use Illuminate\Support\Facades\Request;
use October\Rain\Database\Traits\Validation;

/**
 * Variant Model
 */
class Variant extends Base
{
    use Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_iscorporate_variants';

    /**
     * @var array
     */
    public $implement = [
        'Istheweb.IsCorporate.Behaviors.VariantModel'
    ];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'code',
        'employee_id',
        'projectable_id',
        'projectable_type',
        'name',
        'plazo',
        'horas',
        'price',
        'available_on',
        'pricing_calculator',
    ];

    protected $jsonable = ['data', 'urls'];

    public $rules = [
        'code'      => 'required|unique:istheweb_iscorporate_variants',
        'name'      => 'required',
        'plazo'     => 'required',
        'horas'     => 'required',
        'price'     => 'required'
    ];

    /**
     * @var array
     */
    protected $dates = ['available_on', 'available_until'];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'reports'       => 'Istheweb\IsCorporate\Models\Report',
    ];
    public $belongsTo = [
        'employee'      => 'Istheweb\IsCorporate\Models\Employee',
    ];
    public $belongsToMany = [
        'optionsValues' => ['Istheweb\IsCorporate\Models\OptionValue',
            'table' => 'istheweb_iscorporate_pivots',
        ],
    ];
    public $morphTo = [
        'projectable' => []
    ];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function getPricingCalculatorOptions(){
        return [
            'standard'                          => 'istheweb.iscorporate::lang.labels.standard',
            'channel_and_currency_based'        => 'istheweb.iscorporate::lang.labels.channel_and_currency_based'
        ];
    }

    public function getProjectsOptions(){
        $projects = Project::all()->lists('name', 'id');
        return $projects;
    }

    public function getBugetsOptions()
    {
        $budgets = Budget::all()->lists('name', 'id');
        return $budgets;
    }

    public function getStatusOptions()
    {
        return [
            '1' => 'Nueva',
            '2' => 'En progreso',
            '3' => 'Suspendida',
            '4' => 'Finalizada',

        ];
    }

    public function getSelectedStatus($status)
    {
        $statuses = $this->getStatusOptions();
        foreach($statuses as $key => $value){
            if($key == $status){
                return $value;
            }
        }

    }

    public function scopeProject($query)
    {
        $path = explode('/', Request::path());
        $id = last($path);
        return $query->where('projectable_id', '=', $id)
            ->where('projectable_type', 'Istheweb\IsCorporate\Models\Project');
    }

    public function isBackendUser(){
        $isbackend = false;
        if($this->employee->user->id == BackendAuth::getUser()->id){
            $isbackend = true;
        }
        return $isbackend;
    }

    public function getEmployees()
    {
        return Employee::all();
    }

    public function getBudgets()
    {
        return Budget::all();
    }

    public function beforeSave()
    {
        $manage_id = post('_relation_field');
        if(isset($manage_id)){
            $path = explode('/', Request::path());
            $id = last($path);
            if($path[3] == 'budgets'){
                $projectable = Budget::with(['variants'])->find($id);
            }elseif($path[3] == 'projects'){
                $projectable = Project::with(['variants'])->find($id);
            }else{
                $projectable = Invoice::with(['variants'])->find($id);
            }

            $variant = post('Variant');

            $this->projectable_id = $projectable->id;
            $this->projectable_type = get_class($projectable);
            $this->employee = $variant['employees'];
            $options = $variant['optionsValues'];

            foreach ($options as $k => $v){
                $ov = OptionValue::find($v);
                $this->optionsValues()->add($ov);
            }
        }
    }

    public function afterSave()
    {

    }

}