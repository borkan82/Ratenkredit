<?php
declare(strict_types=1);

namespace App\Helpers;

final class LoanOffer
{
    public function __construct(
        public LoanProvider $provider,
        public float $interestRate,
        public int $durationMonths
    ) {
    }
}