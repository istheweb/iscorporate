<?php namespace Istheweb\IsCorporate\Models;

use Backend\Facades\BackendAuth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Model;
use October\Rain\Database\Traits\Validation;

/**
 * IssueMessage Model
 */
class IssueMessage extends Model
{
    use Validation;
    use SoftDeletes;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_iscorporate_issue_messages';

    /**
     * @var array
     */
    protected $fillable = ['user', 'messageable_id', 'messageable_type', 'reply'];

    /**
     * @var array
     */
    public $attributeNames = [
        'user'   => 'istheweb.iscorporate::lang.fields.user',
        'messageable' => 'istheweb.iscorporate::lang.fields.message',
        'reply'  => 'istheweb.iscorporate::lang.fields.reply'
    ];

    /**
     * @var array
     */
    public $rules = [
        'user'   => 'required',
        'messageable' => 'required',
        'reply'  => 'required'
    ];

    /**
     * @var array Relations
     */

    public $belongsTo = [
        'user'   => ['Backend\Models\User'],
    ];

    public $morphTo = [
        'messageable' => []
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