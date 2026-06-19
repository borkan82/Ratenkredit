<?php

class RatenKredit
{
    public function __construct() {
        ini_set('display_errors', 'off'); // @Fixme No way - you can not put ini_set in constructor
    }
    public function get($providers = null)
    {
        if (!$providers) {
            $providers = ['ing-diba','Smava',  'ba_fin']; // @Fixme - This needs to be defned as private variables or in newer PHP like Enums...
        } else $providers = [$providers]; // @Fixme No comment :) .......... needs to bi inside brackets
        $r = array(); // @Fixme - use []

        $ingdiba = "https://api.jsonbin.io/v3/b/65a6e50e266cfc3fde79aa14?meta=false&amount=$_GET[amount]"; // @Fixme - Uhhh .. Place to private variable, define in constuctor, $_GET not secure, it needs escaping, what about amount ???
        for ($i = 0; $i <= count($providers); $i++) { // @Fixme Its deprecated way of itteration
            switch ($providers[$i]) {
                case 'ing-diba':
                    $offer = file_get_contents($ingdiba, false, stream_context_create([
                        "http" => [
                            "method" => "GET",
                            "header" => 'X-Access-key: $2a$10$NH1p52EaThQFAUbsMloZ.ObhsAsdBC77RJROzFiJ7OUc52oBIn5DS' // this is only for mock
                        ]
                    ]));
                    $offer = json_decode($offer, true);
                    break;
                case 'Smava':
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL => 'https://api.jsonbin.io/v3/b/65a6e71e1f5677401f1ebd2c?meta=false',
                        /*post does not work with mock server CURLOPT_POST => 1,
                        CURLOPT_POSTFIELDS => array(
                            'month' => 3,
                            'loan' => $_GET['amount']
                        ),*/
                        CURLOPT_HTTPHEADER => [
                            'X-access-key: $2a$10$NH1p52EaThQFAUbsMloZ.ObhsAsdBC77RJROzFiJ7OUc52oBIn5DS',
                        ]
                    ));

                    $offer = json_decode(curl_exec($curl), true);
                    curl_close($curl);
                    break;
                    case 'ba_fin':
                    // no api docs yet?
            }
            $r[$providers[$i]] = $offer;
        }
        return $r;
    }
}

if (@$_GET['submit']) {
    $ratenkredit = new RatenKredit();
    $offers = $ratenkredit->get($_ENV['providers']);
}

include(dirname(__FILE__).'/view.phtml');