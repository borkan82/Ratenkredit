<?php
declare(strict_types=1);

namespace App\Interfaces;

use App\Helpers\LoanOffer;

interface LoanOfferClient {
    /**
     * Interface Implemented from all Providers
     *
     * @param int $amount
     *
     * @return LoanOffer|null
     */
    public function fetch(int $amount): ?LoanOffer;
}