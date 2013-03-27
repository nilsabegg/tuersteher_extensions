<?php

namespace Tuersteher\Extension;

use Guzzle\Http\Client as HttpClient;
use \Tuersteher\Validator\Validator as Validator;

class ZipCode extends Validator
{

    protected $country;

    public function country($country)
    {

        $this->country = $country;

        return $this;

    }

    public function validate($value)
    {
        
        $result = $this->apiRequest($value);
        if (count($result['postalcodes']) > 0) {
            return $this->createResult(true, 'bla');
        } else {
            return $this->createResult(false, 'bla');
        }

    }

    protected function apiRequest($zip)
    {

        $client = new HttpClient('http://api.geonames.org');
        $request = $client->get('/postalCodeLookupJSON');
        $query = $request->getQuery();
        $query->set('username', $zip);
        $query->set('country', $this->country);
        $query->set('username', 'tuersteher');
        $request->setQuery($query);
        $response = $request->send();
        $resultSet = $response->json();

        return $resultSet;

    }
}
