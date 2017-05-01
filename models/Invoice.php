<?php namespace Istheweb\IsCorporate\Models;

use Model;
use October\Rain\Database\Traits\Validation;

/**
 * Invoice Model
 */
class Invoice extends Base
{
    use Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_iscorporate_invoices';

    public $implement = [
        'Istheweb.IsCorporate.Behaviors.InvoiceModel'
    ];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'invoice_number',
        'client',
        'budget',
        'status',
        'taxable_base',
        'tax',
        'total'
    ];

    protected $rules = [
        'client'            => 'required',
        'budget'            => 'required',
        'taxable_base'      => 'required|numeric',
        'tax'               => 'required|numeric',
        'total'             => 'required|numeric',
        'invoice_number'    => 'required|unique:istheweb_iscorporate_invoices'
    ];

    /**
     * @var array
     */
    protected $dates = ['invoice_date', 'vto_date', 'send_date'];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'client'            => 'Istheweb\IsCorporate\Models\Client',
        'budget'            => 'Istheweb\IsCorporate\Models\Budget'
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

    public function getStatusOptions()
    {
        return [
            '1' => 'istheweb.iscorporate::lang.invoice_state.waiting',
            '2' => 'istheweb.iscorporate::lang.invoice_state.paid',

        ];
    }

    public function getPaymentTypeOptions()
    {
        return [
            '1' => 'istheweb.iscorporate::lang.payment_types.check',
            '2' => 'istheweb.iscorporate::lang.payment_types.direct_debit',
            '3' => 'istheweb.iscorporate::lang.payment_types.cash',
            '4' => 'istheweb.iscorporate::lang.payment_types.promissory_note',
            '5' => 'istheweb.iscorporate::lang.payment_types.transfer',
        ];
    }

    public function scopeInvoiceNumber($query){
        $query->select('invoice_number')->orderBy('id', 'desc');
    }

    public function scopeStatus($query, $estado){
        $query->where('status', $estado);
    }

    public function scopePaymentType($query, $type){
        $query->whrere('payment_type', $type);
    }
}