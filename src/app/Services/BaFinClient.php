<?php
declare(strict_types=1);

namespace App\Services;

use App\Helpers\LoanOffer;
use App\Interfaces\LoanOfferClient;

class BaFinClient Implements LoanOfferClient{

    private string $apiKey   = "";
    private string $endpoint = "";

    public function fetch(int $amount): ?LoanOffer {
        return null;
    }

}