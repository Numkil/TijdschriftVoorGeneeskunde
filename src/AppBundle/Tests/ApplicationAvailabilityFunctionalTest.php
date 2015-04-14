<?php

namespace AppBundle\Tests;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * Please don't forget whenever you create a new url in a controller to put it in this array, so
     * the test can check if it correctly loads.
     */
    function urlProvider()
    {
        return array(
            array('/'),
            array('/login'),
            array('/register/'),
        );
    }


}
