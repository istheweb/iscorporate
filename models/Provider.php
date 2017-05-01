<?php namespace Istheweb\IsCorporate\Models;

/**
 * Provider Model
 */
class Provider extends Base
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_iscorporate_providers';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'company'           => 'Istheweb\Connect\Models\Company'
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}