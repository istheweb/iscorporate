<?php namespace Istheweb\IsCorporate\Models;


use Illuminate\Support\Facades\Lang;
use October\Rain\Database\Traits\Validation;

/**
 * Budget Model
 */
class Budget extends Base
{
    use Validation;

    const BUDGET_TEMPLATE_CODE = 'budget-template';

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_iscorporate_budgets';

    /**
     * @var array
     */
    public $implement = [
        'Istheweb.IsCorporate.Behaviors.BudgetModel'
    ];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'estado',
        'fecha_entrega',
        'motivo',
        'observaciones_entrega',
        'motivo_no_aceptacion',
        'options',
        'project_types'
    ];

    /**
     * @var array
     */
    public $rules = [
        'estado'        => 'required',
        'motivo'        => 'required',
        'fecha_entrega' => 'required'
    ];

    /**
     * @var array
     */
    protected $dates = ['fecha_entrega'];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'client'           => 'Istheweb\IsCorporate\Models\Client'
    ];
    public $belongsToMany = [
        'options' => ['Istheweb\IsCorporate\Models\ProjectOption',
            'table' => 'istheweb_iscorporate_pivots',
        ],
        'project_types' => ['Istheweb\IsCorporate\Models\ProjectType',
            'table' => 'istheweb_iscorporate_pivots',
        ]
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [
        'variants'      => ['Istheweb\IsCorporate\Models\Variant', 'name' => 'projectable']
    ];
    public $attachOne = [];
    public $attachMany = [];

    public function getEstadoOptions()
    {
        return [
            '1' => 'istheweb.iscorporate::lang.budget_state.requested',
            '2' => 'istheweb.iscorporate::lang.budget_state.acepted',
            '3' => 'istheweb.iscorporate::lang.budget_state.rejected',
            '4' => 'istheweb.iscorporate::lang.budget_state.delivered',
            '5' => 'istheweb.iscorporate::lang.budget_state.contacted',
            '6' => 'istheweb.iscorporate::lang.budget_state.lowcost',
        ];
    }

    public function scopeInvoice($query){
        $query->where('invoice', '<>', '');
    }

    public function scopeEstado($query, $estado){
        $query->where('estado', $estado);
    }

    public function filterFields($fields, $context = null)
    {
        if ($this->estado == 3) {
            $fields->motivo_no_aceptacion->hidden = false;
        }
        else {
            $fields->motivo_no_aceptacion->hidden = true;
        }
    }

}