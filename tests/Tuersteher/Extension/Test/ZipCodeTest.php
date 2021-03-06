<?php

namespace Tuersteher\Extension\Test;

class ZipCodeTest extends \PHPUnit_Framework_TestCase
{

    public function testValidate()
    {

        $tuersteher = new \Tuersteher\Tuersteher();
        $tuersteher->add('zip', '\\Tuersteher\\Extension\\ZipCode')->country('DE')->username('nilsabegg');
        $result = $tuersteher->validate(array('zip' => '76229'));
        $this->assertTrue($result());

        $result2 = $tuersteher->validate(array('zip' => '762293'));
        $this->assertFalse($result2());

    }

    public function testServiceException()
    {

        $tuersteher = new \Tuersteher\Tuersteher();
        $this->setExpectedException('\\Tuersteher\\Exception\\InvalidArgument');
        $tuersteher->add('zip', '\\Tuersteher\\Extension\\ZipCode')->country('DE')->service('noService');

    }

    public function testUsernameException()
    {

        $tuersteher = new \Tuersteher\Tuersteher();
        $this->setExpectedException('\\Tuersteher\\Exception\\InvalidArgument');
        $tuersteher->add('zip', '\\Tuersteher\\Extension\\ZipCode')->country('DE')->username(array());

    }
    
    public function testZiptastic()
    {

        $tuersteher = new \Tuersteher\Tuersteher();
        $tuersteher->add('zip', '\\Tuersteher\\Extension\\ZipCode')->country('DE')->service('ziptastic');
        $result = $tuersteher->validate(array('zip' => '76229'));
        $this->assertTrue($result());

        $result2 = $tuersteher->validate(array('zip' => '762293'));
        $this->assertFalse($result2());

    }

}