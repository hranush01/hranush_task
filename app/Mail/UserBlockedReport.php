<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserBlockedReport extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $reportText;

    public function __construct($user, $reportText)
    {
        $this->user = $user;
        $this->reportText = $reportText;
    }

    public function build()
    {
        return $this->view('emails.user_blocked_report')
            ->subject('User Blocked Report')
            ->with([
                'user' => $this->user,
                'reportText' => $this->reportText,
            ]);
    }
}
