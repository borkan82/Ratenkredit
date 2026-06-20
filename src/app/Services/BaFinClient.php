<?php
declare(strict_types=1);

namespace App\Services;

use App\Helpers\LoanOffer;
use App\Interfaces\LoanOfferClient;

class BaFinClient implements LoanOfferClient {

    private string $apiKey = "";
    private string $endpoint = "";

    /**
     * Fetching BaFin Data from API - NOT IMPLEMENTED YET
     *
     * @param int $amount
     *
     * @return LoanOffer|null
     */
    public function fetch(int $amount): ?LoanOffer {
        // Return null since there is still no implementation
        return NULL;
    }

}