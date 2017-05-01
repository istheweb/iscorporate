<?php namespace Istheweb\IsCorporate\Models;

use October\Rain\Database\Traits\Validation;

/**
 * ProjectOption Model
 */
class ProjectOption extends Base
{
    use Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_iscorporate_project_options';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name', 'code'];

    protected $rules = [
        'name'  => 'required',
        'code' => 'unique:istheweb_iscorporate_project_options',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'values'        => 'Istheweb\IsCorporate\Models\OptionValue'
    ];
    public $belongsTo = [];
    public $belongsToMany = [
        'projects' => ['Istheweb\IsCorporate\Models\Product',
            'table' => 'istheweb_iscorporate_pivots',
        ],
        'budgets' => ['Istheweb\IsCorporate\Models\Budget',
            'table' => 'istheweb_iscorporate_pivots',
        ],
        'invoices' => [
            'Istheweb\IsCorporate\Models\Invoice',
            'table' => 'istheweb_iscorporate_pivots',
        ],

    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}