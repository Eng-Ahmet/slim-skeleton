<?php

declare(strict_types=1);

namespace API\src\utilities\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailSender
{
    protected $mail;
    private $email = 'noreply@edu-luma.com'; // Your email address
    private $name = 'LUMA Academy'; // Sender name

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
            $this->mail->Host       = 'smtp.hostinger.com'; // Hostinger SMTP server
            $this->mail->SMTPAuth   = true; // Enable authentication
            $this->mail->Username   = 'noreply@edu-luma.com'; // SMTP username (email address)
            $this->mail->Password   = 'Ah1no2ab3???'; // SMTP password (update with your actual email password)
            $this->mail->SMTPSecure = 'ssl'; // Use SSL encryption (as a string)
            $this->mail->Port       = 465; // SMTP port for SSL
        } catch (Exception $e) {
            throw new Exception("Failed to initialize mailer: {$e->getMessage()}");
        }
    }

    public function sendMail($recipientEmail, $recipientName, $subject, $body)
    {
        try {
            // Sender info
            $this->mail->setFrom($this->email, $this->name);

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

    public function sendActivationEmail($recipientEmail, $recipientName, $activationLink)
    {
        $subject = 'Activate Your Account';

        $body = "
            <div style='font-family: Arial, sans-serif; background-color: #f9f9f9; color: #333; padding: 20px;'>
                <h1 style='color: #28a745; font-size: 24px;'>Welcome to LUMA ACADEMY!</h1>
                <p style='font-size: 16px; line-height: 1.5;'>Dear {$recipientName},</p>
                <p style='font-size: 16px; line-height: 1.5;'>Thank you for registering with us! We're excited to have you on board.</p>
                <p style='font-size: 16px; line-height: 1.5;'>Please click the button below to activate your account:</p>
                <a href='{$activationLink}' style='display: inline-block; padding: 10px 20px; margin-top: 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s;'>Activate Your Account</a>
                <p style='font-size: 16px; line-height: 1.5;'>If you did not create an account, please ignore this email.</p>
                <p style='font-size: 16px; line-height: 1.5;'>Best regards,<br>LUMA ACADEMY Team</p>
            </div>
        ";

        return $this->sendMail($recipientEmail, $recipientName, $subject, $body);
    }
}
