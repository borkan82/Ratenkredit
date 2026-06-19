<?php
declare(strict_types=1);

namespace App\Interfaces;

use App\Helpers\LoanOffer;

interface LoanOfferClient
{
    public function fetch(int $amount): ?LoanOffer;
}