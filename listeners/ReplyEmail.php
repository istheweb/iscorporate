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

class ReplyEmail
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

        $lastMessage = $issue->messages->last();

        $toSupport = $this->isToSupportTeam($issue, $lastMessage);

        $toSupport ? $this->sendEmailToSupport($issue, $lastMessage) : $this->sendMailToOwner($issue, $lastMessage);
    }

    /**
     * @param Issue $issue
     * @param $lastMessage
     */
    private function sendEmailToSupport(Issue $issue, $lastMessage)
    {
        $resource = $issue->resource;
        $member['name'] = $resource->user->full_name;
        $member['email'] = $resource->user->email;

        $data = [
            'name'   => $member['name'],
            'issue' => $issue,
            'reply'  => $lastMessage->reply,
            'url'    => $issue->getUrl(),
        ];

        $this->mailer->queue('istheweb.iscorporate::mail.new_reply', $data, function ($message) use ($member) {
            $message->to($member['email'], $member['name']);
        });

    }

    /**
     * @param Issue $issue
     * @param $lastMessage
     */
    private function sendMailToOwner(Issue $issue, $lastMessage)
    {
        $email = $issue->creator->email;
        $name = $issue->creator->full_name;

        $data = [
            'name'   => $name,
            'issue' => $issue,
            'reply'  => $lastMessage->reply,
            'url'    => $issue->getUrl(),
        ];

        $this->mailer->queue('istheweb.iscorporate::mail.new_reply', $data, function ($message) use ($email, $name) {
            $message->to($email, $name);
        });
    }

    /**
     * @param Issue $issue
     * @param $lastMessage
     * @return bool
     */
    protected function isToSupportTeam(Issue $issue, $lastMessage)
    {
        return $issue->resource->id == $lastMessage->user_id;
    }
}