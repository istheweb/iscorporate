<?php namespace Istheweb\IsCorporate\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use October\Rain\Database\Traits\Validation;


/**
 * Note Model
 */
class Note extends Base
{

    use Validation;
    use SoftDeletes;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_iscorporate_notes';

    /**
     * @var array
     */
    public $rules = [
        'user'   => 'required',
        'ticketable' => 'required',
        'reply'  => 'required'
    ];

    /**
     * @var array
     */
    protected $fillable = ['user', 'reply'];

    /**
     * @var array Relations
     */

    public $belongsTo = [
        'user'   => ['Backend\Models\User'],
    ];

    public $morphTo = [
        'ticketable' => []
    ];

    /**
     * @param string $value
     */
    public function setReplyAttribute($value)
    {
        $this->attributes['reply'] = strip_tags(trim($value));
    }

    /**
     * @return bool
     */
    public function isOwner()
    {
        return $this->user->id == BackendAuth::getUser()->id;
    }

}