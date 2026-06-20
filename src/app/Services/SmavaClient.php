<?php
declare(strict_types=1);

namespace App\Services;

use App\Helpers\LoanOffer;
use App\Interfaces\LoanOfferClient;

class SmavaClient Implements LoanOfferClient{

    private string $apiKey = "";
    private string $endpoint = 'https://api.jsontest.io/v3/b/1212f324324f342344f4f';

    public function fetch(int $amount): ?LoanOffer {

        $ch = curl_init($this->endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => ["X-Access-key: {$this->apiKey}"],
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_FAILONERROR    => false,
        ]);

        try {
            $reponse = curl_exec($ch);

        } catch(Exception $e){

        }
    }
}