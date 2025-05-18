<?php

declare(strict_types=1);

namespace API\src\utilities\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailSender
{
    protected $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->initializeMailer();
    }

    protected function initializeMailer()
    {
        try {
            // Server settings
            $this->mail->isSMTP();
            $this->mail->Host       = '127.0.0.1'; // MailHog SMTP server
            $this->mail->SMTPAuth   = false; // MailHog doesn't require authentication
            $this->mail->Port       = 1025; // MailHog SMTP port
        } catch (Exception $e) {
            throw new Exception("Failed to initialize mailer: {$e->getMessage()}");
        }
    }

    public function sendMail($recipientEmail, $recipientName, $subject, $body)
    {
        try {
            // Sender info
            $this->mail->setFrom('your@example.com', 'Your Name');

            // Recipient
            $this->mail->addAddress($recipientEmail, $recipientName);

            // Email content
            $this->mail->isHTML(true); // Set email format to HTML
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;

            // Send email
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            throw new Exception("Failed to send email: {$e->getMessage()}");
        }
    }
}
