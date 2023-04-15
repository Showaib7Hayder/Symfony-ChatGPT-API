<?php

declare(strict_types=1);


namespace App\Service;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ChatGPTClient
{

    public function __construct(
        private HttpClientInterface $httpClient,
        private ParameterBagInterface $parameterBag,
    ) {
    }

    public function getAnswer(string $prompt): string
    {

        $chatGPTApiUrl = $this->parameterBag->get('chat-gpt-api-url');
        $chatGPTApiKey = $this->parameterBag->get('chat-gpt-api-key');

        $response = $this->httpClient->request(
            Request::METHOD_POST,
            $chatGPTApiUrl,
            [
                'headers' => [
                    'Authorization' => "Bearer {$chatGPTApiKey}",
                ],
                'json' => [
                    'prompt' => $prompt,
                    'max_tokens' => 100,
                    'temperature' => 0.9,
                    'model' => 'text-davinci-003',
                ]
            ]

        );

        if ($response->getStatusCode() === Response::HTTP_OK) {
            $content = $response->toArray();

            return $content['choices'][0]['text'];
        }
        return '';
    }
}
