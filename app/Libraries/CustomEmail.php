<?php

namespace App\Libraries;

class CustomEmail
{
    private $email;
    private $from;
    private $fromName;

    public function __construct()
    {
        $this->from = $_ENV['SMTP_USERNAME'];
        $this->fromName = 'CIGruas';

        $this->email = \Config\Services::email();
        $this->email->initialize([
            'protocol' => 'smtp',
            'SMTPHost' => 'smtp.gmail.com',
            'SMTPUser' => $_ENV['SMTP_USERNAME'],
            'SMTPPass' => $_ENV['SMTP_PASSWORD'],
            'SMTPPort' => 587,
            'SMTPCrypto' => 'tls',
            'mailType' => 'html',
            'charset' => 'utf-8'
        ]);
    }

    /**
     * Send email
     * @param string $to
     * @param string $subject
     * @param string $message
     * @return bool true if the email was sent successfully, false otherwise
     * @throws \Exception if there is an error sending the email
     */
    public function sendEmail($to, $subject, $message, $attachmentPath = null)
    {
        try {
            $this->email->setFrom($this->from, $this->fromName);
            $this->email->setTo($to);

            $this->email->setSubject($subject);
            $this->email->setMessage($message);

            if ($attachmentPath) {
                $this->email->attach($attachmentPath);
            }

            $success = $this->email->send();

            if (!$success) {
                throw new \Exception($this->email->printDebugger(['headers']));
            }

            return $success;

        } catch (\Exception $e) {
            log_message('error', 'Error al enviar correo electrónico: ' . $e->getMessage());
            return false;
        }


    }

    /**
     * Send confirmation email to user with view email/confirmation template
     * @param string $to
     * @param string $token
     * @return bool true if the email was sent successfully, false otherwise
     */
    public function sendConfirmationEmail($to, $token)
    {
        $subject = 'Confirmación de cuenta';
        $message = view('emails/confirmation', ['token' => $token, 'subject' => $subject]);
        return $this->sendEmail($to, $subject, $message);
    }

    public function sendResetPasswordEmail($to, $token)
    {
        $subject = 'Reestablecimiento de contraseña';
        $message = view('emails/reset_password', ['token' => $token, 'subject' => $subject]);
        return $this->sendEmail($to, $subject, $message);
    }

}