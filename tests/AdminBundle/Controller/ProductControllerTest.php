<?php

namespace AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{

    public function testCompleteScenario()
    {
         /// Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/products');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /products");


        // Fill in the form and submit it
        $form = $crawler->selectButton('Add Products')->form(array(
            'adminbundle_product[name]'  => 'TestProduct',
            'adminbundle_product[price]'  => '12',
            'adminbundle_product[currency]'  => 'Eur',
            'adminbundle_product[quantity]'  => '200',
            'adminbundle_product[categories]'  => '1'
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("TestProduct")')->count(), 'Missing element td:contains("TestProduct")');
    }


}
