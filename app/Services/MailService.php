<?php

namespace App\Services;

use App\Mail\SharedMarkdownMail;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailService {
    protected $from;
    protected $title;

    public function __construct() {
        $this->from = config('params.mail_username');
        $this->title = config('params.site_title');
    }

    /**
     * Send an email.
     *
     * @param array $data
     * @return bool
     */
    public function sendMail(array $data): bool {
        $emails = $data['email'] ?? [];
        if (!is_array($emails)) $emails = [$emails];

        try {
            foreach ($emails as $email) {
                Mail::to($email)->send(new SharedMarkdownMail($data));
            }

            return true;
        } catch (Exception $e) {
            Log::error('Failed to send email: ' . $e->getMessage(), ['exception' => $e]);
            return false;
        }
    }
}
