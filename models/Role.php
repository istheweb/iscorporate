<?php namespace Istheweb\IsCorporate\Models;


/**
 * Role Model
 */
class Role extends Base
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_iscorporate_roles';

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
    public $belongsTo = [];
    public $belongsToMany = [
        'employees' => [
            'Istheweb\IsCorporate\Models\Employee',
            'table' => 'istheweb_iscorporate_pivots',
        ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function afterDelete()
    {
        if($this->employees()) $this->employees()->detach();
    }

    public function getEmployeesOptions()
    {
        $options = [];
        $employees = Employee::orderBy('last_name', 'asc')->orderBy('first_name', 'asc')->get();
        foreach ($employees as $employee) {
            $options[$employee->id] = $employee->name;
        }
        return $options;
    }

}