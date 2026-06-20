<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\LoanOffer;
use App\Helpers\LoanProvider;
use App\Services\IngDibaClient;
use App\Services\SmavaClient;
use App\Services\BaFinClient;

final class Ratenkredit {

    private array $clients;

    public function __construct()
    {
        $this->clients = [
            LoanProvider::IngDiba->value => new IngDibaClient(),
            LoanProvider::Smava->value => new SmavaClient(),
            LoanProvider::BaFin->value => new BaFinClient(),
        ];
    }

    public function get(int $amount){
        $values = array_map(
            fn (LoanProvider $provider) => $provider->value,
            LoanProvider::cases()
        );


    }

}