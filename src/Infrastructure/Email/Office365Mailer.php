<?php

// src/Infrastructure/Email/Office365Mailer.php

namespace App\Infrastructure\Email;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\Transport;

class Office365Mailer
{
    private string $fromAddress;
    private Office365OAuthTokenProvider $tokenProvider;

    public function __construct(
        string $fromAddress,
        Office365OAuthTokenProvider $tokenProvider
    ) {
        $this->fromAddress = $fromAddress;
        $this->tokenProvider = $tokenProvider;
    }

    public function send(string $to, string $subject, string $body): void
    {
        $token = $this->tokenProvider->getAccessToken();

        $dsn = sprintf(
            'smtp://%s:%s@smtp.office365.com:587?encryption=tls&auth_mode=xoauth2',
            urlencode($this->fromAddress),
            urlencode($token)
        );

        $mailer = new Mailer(Transport::fromDsn($dsn));

        $email = (new Email())
            ->from($this->fromAddress)
            ->to($to)
            ->subject($subject)
            ->text($body);

        $mailer->send($email);
    }
}