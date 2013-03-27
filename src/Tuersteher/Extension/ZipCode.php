<?php

/**
 * This file is part of the Türsteher library.
 */
namespace Tuersteher\Extension;

use \Guzzle\Http\Client as HttpClient;
use \Tuersteher\Exception\InvalidArgument as InvalidArgumentException;
use \Tuersteher\Validator\Validator as Validator;

/**
 * ZipCode
 *
 * This class is a zip code validator for the Türsteher library.
 * The zip code can be validated by various webservices.
 *
 * @author      Nils Abegg <tuersteher@nilsabegg.de>
 * @version     0.2
 * @package     Türsteher Extensions
 * @category    Validation
 */
class ZipCode extends Validator
{

    /**
     * country
     *
     * Holds the country code for the zip code.
     * The country code has to be in ISO-3166 format.
     *
     * @access protected
     * @var    string
     */
    protected $country = 'DE';

    /**
     * service
     *
     * Holds the webservice to validate the zip code.
     *
     * @access protected
     * @var    string
     */
    protected $service = 'geonames';

    /**
     * username
     *
     * Holds the username for the webservice.
     *
     * @access protected
     * @var    string
     */
    protected $username = 'demo';

    /**
     * country
     *
     * This is a shortcut for $this->setCountry($country).
     * The country code has to be in ISO-3166 format.
     *
     * @access public
     * @param  string $country The country has to be in ISO-3166 format
     * @return \Tuersteher\Extension\ZipCode
     * @see    \Tuersteher\Extension\ZipCode::setCountry()
     */
    public function country($country)
    {

        return $this->setCountry($country);

    }

    /**
     * service
     *
     * This is a shortcut for $this->setService($service).
     *
     * @access public
     * @param  string $service
     * @return \Tuersteher\Extension\ZipCode
     * @see    \Tuersteher\Extension\ZipCode::setService()
     * @throws \Tuerster\Exception\InvalidArgument
     */
    public function service($service)
    {

        return $this->setService($service);

    }

    /**
     * username
     *
     * This is a shortcut for $this->setUsername($username).
     *
     * @access public
     * @param  string $username
     * @return \Tuersteher\Extension\ZipCode
     * @see    \Tuersteher\Extension\ZipCode::setUsername()
     * @throws \Tuerster\Exception\InvalidArgument
     */
    public function username($username)
    {

        return $this->setUsername($username);

    }

    /**
     * setCountry
     *
     * Sets the country for the zip code.
     * The country code has to be in ISO-3166 format.
     *
     * @access public
     * @param  string $country The country has to be in ISO-3166 format
     * @return \Tuersteher\Extension\ZipCode
     */
    public function setCountry($country)
    {

        $this->country = $country;

        return $this;

    }

    /**
     * setService
     *
     * Sets the service to validate the zip code.
     *
     * @access public
     * @param  string $service
     * @return \Tuersteher\Extension\ZipCode
     * @throws \Tuerster\Exception\InvalidArgument
     */
    public function setService($service)
    {

        if (method_exists($this, 'validate' . ucfirst($service)) == true) {
            $this->service = $service;

            return $this;
        } else {
            throw new InvalidArgumentException('The service "' . $service . '" is not implemented.');
        }

    }

    /**
     * username
     *
     * Sets the username for the webservice.
     *
     * @access public
     * @param  string $username
     * @return \Tuersteher\Extension\ZipCode
     * @throws \Tuerster\Exception\InvalidArgument
     */
    public function setUsername($username)
    {

        if (is_string($username) == true) {
            $this->username = $username;

            return $this;
        } else {
            throw new InvalidArgumentException('The username must be a string.');
        }

    }

    /**
     * validate
     *
     * 
     *
     * @access protected
     * @param  string $value
     * @return \Tuersteher\Interfaces\Result\Validator
     */
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

    /**
     * validateGeonames
     *
     *
     *
     * @access protected
     * @param  string $zip
     * @return boolean
     */
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

    /**
     * validateZiptastic
     *
     *
     *
     * @access protected
     * @param  string $zip
     * @return boolean
     */
    protected function validateZiptastic($zip)
    {

        $client = new HttpClient('http://zip.elevenbasetwo.com');
        $request = $client->get('/v2/' . urlencode($this->country) . '/' . urlencode($zip));
        try {
            $request->send();

            return true;
        } catch (\Guzzle\Http\Exception\ClientErrorResponseException $exception) {

            return false;
        }

    }
}
