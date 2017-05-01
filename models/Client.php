<?php namespace Istheweb\IsCorporate\Models;

use October\Rain\Database\Traits\Validation;

/**
 * Client Model
 */
class Client extends Base
{
    use Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_iscorporate_clients';

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'actividad',
        'url',
        'forma_pago',
        'banco',
        'sucursal',
        'dc',
        'cuentas',
        'observaciones'
    ];

    public $rules = [
        'company'       => 'required'
    ];

    /**
     * @var array Relations
     */
    public $hasMany = [
        'budgets'       => 'Istheweb\IsCorporate\Models\Budget',
        'projects'       => 'Istheweb\IsCorporate\Models\Project',
    ];
    public $belongsTo = [
        'company'           => 'Istheweb\Connect\Models\Company'
    ];

}