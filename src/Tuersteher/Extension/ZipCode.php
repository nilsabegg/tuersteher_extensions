<?php

namespace Tuersteher\Extension;

use \Guzzle\Http\Client as HttpClient;
use \Tuersteher\Exception\InvalidArgument as InvalidArgumentException;
use \Tuersteher\Validator\Validator as Validator;

class ZipCode extends Validator
{

    protected $country = 'DE';

    protected $service = 'geonames';

    protected $username = 'demo';

    public function country($country)
    {

        $this->country = $country;

        return $this;

    }

    public function service($service)
    {

        if (method_exists($this, 'validate' . ucfirst($service)) == true) {
            $this->service = $service;
        } else {
            throw new InvalidArgumentException('The service "' . $service . '" is not implemented.');
        }

    }

    public function username($username)
    {

        if (is_string($username) == true) {
            $this->username = $username;
        } else {
            throw new InvalidArgumentException('The username must be a string.');
        }

    }

    public function validate($value)
    {

        $methodName = 'validate' . ucfirst($this->service);
        $isValid = $this->$methodName($value);
        if ($isValid == true) {

            return $this->createResult(true, 'bla');
        } else {
            
            return $this->createResult(false, 'bla');
        }

    }

    protected function validateGeonames($zip)
    {

        $client = new HttpClient('http://api.geonames.org');
        $request = $client->get('/postalCodeLookupJSON');
        $query = $request->getQuery();
        $query->set('postalcode', urlencode($zip));
        $query->set('country', urlencode($this->country));
        $query->set('username', urldecode($this->username));
        $response = $request->send();
        $resultSet = $response->json();
        if (count($resultSet['postalcodes']) > 0) {

            return true;
        } else {

            return false;
        }

    }

    protected function validateZiptastic($zip)
    {

        $client = new HttpClient('http://zip.elevenbasetwo.com');
        $request = $client->get('/v2/' . urlencode($this->country) . '/' . urlencode($zip));
        try {
            $response = $request->send();

            return true;
        } catch (\Guzzle\Http\Exception\ClientErrorResponseException $exception) {

            return false;
        }

    }
}
