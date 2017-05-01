<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 16/01/17
 * Time: 17:48
 */

namespace istheweb\iscorporate\listeners;

use Illuminate\Mail\Mailer;
use Istheweb\IsCorporate\Models\Issue;

class EmailSupportTeam
{

    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * @param Mailer $mailer
     * @param Settings $settings
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param Issue $issue
     */
    public function handle(Issue $issue)
    {

        $resource = $issue->resource;
        $member['name'] = $resource->user->name;
        $member['email'] = $resource->user->email;
        $owner = $issue->creator->full_name;
        $url = $issue->getUrl();

        $data = [
            'name'          => $resource->fullname,
            'owner'         => $owner,
            'issue'         => $issue,
            'url'           => $url
        ];

        $this->mailer->queue('istheweb.iscorporate::mail.new_issue', $data, function ($message) use ($member) {
            $message->to($member['email'], $member['name']);
        });

    }
}