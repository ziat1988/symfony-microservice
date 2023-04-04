<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LowestPriceControllerTest extends WebTestCase
{
    public function testRoutingProduct(): void
    {
        $client = static::createClient();
        $id= 1;

        $crawler = $client->jsonRequest('POST', "/products/{$id}/lowest-price",
            [
                'quantity'=>5,
                'requestLocation'=>'FR',
                'voucherCode'=> 'OU812',
                'requestDate'=>'2023-11-25',
            ]
        );


        $this->assertResponseIsSuccessful();

    }
}
