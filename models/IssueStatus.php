<?php namespace Istheweb\IsCorporate\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use October\Rain\Database\Traits\Validation;

/**
 * IssueStatus Model
 */
class IssueStatus extends Base
{
    use Validation;
    use SoftDeletes;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_iscorporate_issue_statuses';

    /**
     * @var array
     */
    protected $fillable = ['name', 'is_active'];

    /**
     * @var array
     */
    public $attributeNames = [
        'name'      => 'istheweb.iscorporate::lang.fieds.name',
        'is_active' => 'istheweb.iscorporate::lang.fieds.is_active'
    ];

    /**
     * @var array
     */
    public $rules = [
        'name'      => 'required|max:50',
        'is_active' => 'boolean'
    ];

    /**
     * @var array
     */
    public $belongsToMany = [
        'tickets' => ['Istheweb\IsCorporate\Models\Issue']
    ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * @return mixed
     */
    public static function getActiveList()
    {
        return self::active()->get()->lists('name', 'id');
    }

}