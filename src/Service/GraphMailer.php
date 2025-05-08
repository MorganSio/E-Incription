<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Psr\Log\LoggerInterface;

class GraphMailer
{
    private const TOKEN_ENDPOINT = 'https://login.microsoftonline.com/%s/oauth2/v2.0/token';
    private const GRAPH_ENDPOINT = 'https://graph.microsoft.com/v1.0/users/%s/sendMail';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly LoggerInterface $logger,
        private readonly string $clientId,
        private readonly string $clientSecret,
        private readonly string $tenantId,
        private readonly string $fromEmail
    ) {}

    private function getAccessToken(): ?string
    {
        $response = $this->httpClient->request('POST', sprintf(self::TOKEN_ENDPOINT, $this->tenantId), [
            'body' => [
                'client_id' => $this->clientId,
                'scope' => 'https://graph.microsoft.com/.default',
                'client_secret' => $this->clientSecret,
                'grant_type' => 'client_credentials',
            ],
        ]);

        $data = $response->toArray(false);
        return $data['access_token'] ?? null;
    }

    public function sendMail(string $to, string $subject, string $content, ?string $cc = null, array $attachments = []): bool
    {
        try {
            $token = $this->getAccessToken();

            if (!$token) {
                $this->logger->error('Impossible d\'obtenir le token d\'accès.');
                return false;
            }

            $message = [
                'subject' => $subject,
                'body' => [
                    'contentType' => 'HTML',
                    'content' => $content,
                ],
                'toRecipients' => [[
                    'emailAddress' => ['address' => $to],
                ]],
            ];

            if ($cc) {
                $message['ccRecipients'] = [[
                    'emailAddress' => ['address' => $cc],
                ]];
            }

            if (!empty($attachments)) {
                $message['attachments'] = array_map(fn ($att) => [
                    '@odata.type' => '#microsoft.graph.fileAttachment',
                    'name' => $att['name'],
                    'contentBytes' => $att['contentBytes'],
                    'contentType' => $att['contentType'],
                ], $attachments);
            }            

            $response = $this->httpClient->request('POST', sprintf(self::GRAPH_ENDPOINT, $this->fromEmail), [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'message' => array_merge($message, [
                        'attachments' => $attachments
                    ]),
                    'saveToSentItems' => true,
                ],
            ]);

            return $response->getStatusCode() === 202;
        } catch (\Throwable $e) {
            $this->logger->error('Erreur lors de l\'envoi via Graph API : ' . $e->getMessage());
            return false;
        }
    }
}