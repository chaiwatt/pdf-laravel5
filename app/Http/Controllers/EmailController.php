<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail()
    {
        $mailTo = 'joerock@domain.com';
        $details = [
            'title' => 'Test Email from Laravel',
            'body' => 'This is a test email using Mailtrap',
        ];

        Mail::to($mailTo)->send(new \App\Mail\TestMail($details));

        return 'Email sent successfully';
    }
}
