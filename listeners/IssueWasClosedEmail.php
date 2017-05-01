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

class IssueWasClosedEmail
{
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * @param Mailer $mailer
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
        $email = $issue->creator->email;
        $name = $issue->creator->full_name;

        $data = [
            'name'   => $name,
            'issue' => $issue,
            'url'    => $issue->getUrl(),
        ];

        dd($data);

        $this->mailer->queue('istheweb.iscorporate::mail.issue_closed', $data, function ($message) use ($email, $name) {
            $message->to($email, $name);
        });
    }
}