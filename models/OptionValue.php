<?php namespace Istheweb\IsCorporate\Models;

use October\Rain\Database\Traits\Validation;

/**
 * OptionValue Model
 */
class OptionValue extends Base
{

    use Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_iscorporate_option_values';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['project_option', 'code', 'value', 'price'];

    protected $rules = [
        'project_option' => 'required',
        'code',
        'name',
        'price',
    ];

    /**
     * @var array Relations
     */

    public $belongsTo = [
        'project_option'       => 'Istheweb\IsCorporate\Models\ProjectOption'
    ];
    public $belongsToMany = [
        'variants' => ['Istheweb\IsCorporate\Models\Variant',
            'table' => 'istheweb_iscorporate_pivots',
        ]
    ];




}