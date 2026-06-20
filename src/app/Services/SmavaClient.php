<?php
declare(strict_types=1);

namespace App\Services;

use App\Helpers\LoanOffer;
use App\Interfaces\LoanOfferClient;

class SmavaClient Implements LoanOfferClient{

    private string $apiKey = "";
    private string $endpoint = 'https://api.jsontest.io/v3/b/1212f324324f342344f4f';

    public function fetch(int $amount): ?LoanOffer {

        return null;
    }

}