<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 19/01/17
 * Time: 23:47
 */

namespace istheweb\iscorporate\listeners;


use Carbon\Carbon;
use Illuminate\Contracts\Mail\Mailer;
use Istheweb\Connect\Models\CompanySettings;
use Istheweb\IsCorporate\Models\Budget;
use Istheweb\IsCorporate\Models\Variant;

class EmailClientBudget
{

    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param Issue $issue
     */
    public function handle(Budget $budget)
    {
        $client = $budget->client;
        $sendto['email'] = $client->company->email;
        $sendto['name'] = $client->company->name;
        $d = $budget->getData($budget->id, false);

        $data = [
            'site'  => $d['site'],
            'subject'  => $d['subject'],
            'companyName'   => $d['company']->name,
            'created_at'  => Carbon::parse($budget->created_at),
            'email'       => $d['email'],
            'pdfNumber'   => $d['pdfNumber'],
            'pdfName'     => $d['pdf'],
            'items'       => Variant::formatVariants($d['items']),
            'subtotal'    => $d['subtotal'],
            'total'       => $d['total']
        ];

        $this->mailer->send('istheweb.iscorporate::mail.email_budget', $data, function ($message) use ($sendto, $data) {
            $message->to($sendto['email'], $sendto['name']);
            $message->subject($data['subject']);
            $message->attach(storage_path().'/app/media/presupuestos/'.$data['pdfName']);
        });

    }
}