<?php
declare(strict_types=1);

namespace App\Services;

use App\Helpers\LoanOffer;
use App\Helpers\LoanProvider;
use App\Interfaces\LoanOfferClient;
use RuntimeException;

class SmavaClient Implements LoanOfferClient{

    private string $apiKey   = '';
    private string $endpoint = 'https://my-json-server.typicode.com/borkan82/Ratenkredit/posts';
//    private string $apiKey   = '$2a$10$NH1p52EaThQFAUbsMloZ.ObhsAsdBC77RJROzFiJ7OUc52oBIn5DS';
//    private string $endpoint = 'https://api.jsontest.io/v3/b/1212f324324f342344f4f';

    public function fetch(int $amount): ?LoanOffer {

        $ch = curl_init($this->endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => ["X-Access-key: $this->apiKey"],
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_FAILONERROR    => false,
        ]);

        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === false) {
            throw new RuntimeException("cURL request failed: $curlError");
        }

        if ($httpCode < 200 || $httpCode >= 300) {
            throw new RuntimeException("Unexpected HTTP status $httpCode from loan provider.");
        }

        $data = json_decode($response, true)[0];

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException("Invalid JSON response: " . json_last_error_msg());
        }

        if (empty($data)) {
            return null;
        }

        if (!isset($data['Interest'], $data['Terms']['Duration'])) {
            throw new RuntimeException("Incomplete loan offer response: missing required fields.");
        }

        if (!is_numeric($data['Interest']) || $data['Interest'] < 0) {
            throw new RuntimeException("Invalid interestRate value: {$data['Interest']}");
        }

        $durationMonth = (int) $data['Terms']['Duration'];

        if (!is_int($durationMonth) || $durationMonth <= 0) {
            throw new RuntimeException("Invalid durationMonths value: {$durationMonth}");
        }

        return new LoanOffer(
            provider:       LoanProvider::Smava,
            interestRate:   (float) $data['Interest'],
            durationMonths: $durationMonth
        );
    }
}