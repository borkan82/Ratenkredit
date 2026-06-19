<?php
// @Fixme - Use strict types!!!

class RatenKredit // @Fixme - Could be also final class ? You dont need to extend it anymore
{
    public function __construct() {
        ini_set('display_errors', 'off'); // @Fixme No way - you can not put ini_set in constructor
    }
    public function get($providers = null)
    {
        if (!$providers) {
            $providers = ['ing-diba','Smava',  'ba_fin']; // @Fixme - This needs to be defned as private variables or in newer PHP like Enums...
        } else $providers = [$providers]; // @Fixme No comment :) .......... at least needs to bi inside brackets
        $r = array(); // @Fixme - use []

        $ingdiba = "https://api.jsonbin.io/v3/b/65a6e50e266cfc3fde79aa14?meta=false&amount=$_GET[amount]"; // @Fixme - Uhhh .. Place to private variable, define in constuctor, $_GET not secure, it needs escaping, what about amount ???
        for ($i = 0; $i <= count($providers); $i++) { // @Fixme Its deprecated way of itteration
            switch ($providers[$i]) { // @Fixme - Switch is ok, but fom PHP version 8.0 use match
                case 'ing-diba':
                    // @Fixme - Whole part is badly written, not readable, unclear
                    $offer = file_get_contents($ingdiba, false, stream_context_create([
                        "http" => [
                            "method" => "GET",
                            "header" => 'X-Access-key: $2a$10$NH1p52EaThQFAUbsMloZ.ObhsAsdBC77RJROzFiJ7OUc52oBIn5DS' // this is only for mock
                        ]
                    ]));
                    $offer = json_decode($offer, true);
                    break;
                case 'Smava':
                    // @Fixme - Also needs refactorind for a better readability, throw out the commented code that is not used
                    $curl = curl_init();
                    curl_setopt_array($curl, array( // @Fixme - up is stream_context... here cURL .. Where dissapeared consistency?
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
                        // @Fixme - Where is default case ??? Where is break??
            }
            $r[$providers[$i]] = $offer;
        }
        return $r;
    }
}

if (@$_GET['submit']) { // @Fixme - Do this never again!!! Silence opereator not allowed. Use validations!!!
    $ratenkredit = new RatenKredit();
    $offers = $ratenkredit->get($_ENV['providers']); // @Fixme - Ok... how.. the hell came $_ENV here??
}

include(dirname(__FILE__).'/view.phtml');