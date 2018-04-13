<?php

namespace AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{

    public function testCompleteScenario()
    {
        /// Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/categories/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /category/");


        // Fill in the form and submit it
        $form = $crawler->selectButton('Add Category')->form(array(
            'adminbundle_category[name]'  => 'TestCategoryTest'
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("TestCategoryTest")')->count(), 'Missing element td:contains("TestCategoryTest")');
    }


}
