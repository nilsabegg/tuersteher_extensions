<?php

namespace Tuersteher\Extension;

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
        return $this->createResult(true, 'bla');
    }
}
