<?php

namespace Tuersteher\Extension\Test;

class ZipCodeTest extends \PHPUnit_Framework_TestCase
{

    public function testValidate()
    {

        $tuersteher = new \Tuersteher\Tuersteher();
        $tuersteher->add('zip', '\\Tuersteher\\Extension\\ZipCode')->country('DE');
        $result = $tuersteher->validate(array('zip' => '76229'));
        $this->assertTrue($result());

        $result2 = $tuersteher->validate(array('zip' => '762293'));
        $this->assertFalse($result2());

    }

}