<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\LoanOffer;
use App\Helpers\LoanProvider;
use App\Services\IngDibaClient;
use App\Services\SmavaClient;
use App\Services\BaFinClient;

final class Ratenkredit {

    /** @var array<string, LoanOfferClient> */
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

        $offers = [];

        foreach (LoanProvider::cases() as $provider) {
            $client = $this->clients[$provider->value] ?? null;

            if ($client === null) {
                continue;
            }

            try {
                $offer = $client->fetch($amount);

                if ($offer !== null) {
                    $offers[$provider->value] = $offer;
                }
            } catch (RuntimeException $e) {

            }
        }

        return $offers;



    }

}