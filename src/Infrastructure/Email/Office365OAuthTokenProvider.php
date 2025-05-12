<?php

// src/Infrastructure/Email/Office365OAuthTokenProvider.php

namespace App\Infrastructure\Email;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class Office365OAuthTokenProvider
{
    private string $tenantId;
    private string $clientId;
    private string $clientSecret;
    private HttpClientInterface $httpClient;

    public function __construct(
        string $tenantId,
        string $clientId,
        string $clientSecret,
        HttpClientInterface $httpClient
    ) {
        $this->tenantId = $tenantId;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->httpClient = $httpClient;
    }

    public function getAccessToken(): string
    {
        $response = $this->httpClient->request('POST', "https://login.microsoftonline.com/{$this->tenantId}/oauth2/v2.0/token", [
            'body' => [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'scope' => 'https://outlook.office365.com/.default',
                'grant_type' => 'client_credentials',
            ],
        ]);

        $data = $response->toArray();

        if (!isset($data['access_token'])) {
            throw new \RuntimeException('Token OAuth2 manquant ou invalide.');
        }

        return $data['access_token'];
    }
}