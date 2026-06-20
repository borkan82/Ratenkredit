<?php
declare(strict_types=1);

namespace App\Helpers;

enum LoanProvider: string {
    case IngDiba = 'ing-diba';
    case Smava = 'smava';
    case BaFin = 'ba_fin';
}