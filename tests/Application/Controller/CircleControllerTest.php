<?php

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CircleControllerTest extends WebTestCase
{
    public function testGetCircle()
    {
        $client = static::createClient();

        $client->request('GET', '/circle/2');

        $response = $client->getResponse();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));

        $expectedData = [
            'surface' => '12.57',
            'circumference' => '12.57',
            'type' => 'circle',
            'radius' => '2.0',
        ];
        $responseData = json_decode($response->getContent(), true);

        $this->assertSame($expectedData, $responseData);
    }

    public function testSumObjects()
    {
        $client = static::createClient();

        $circle1 = ['radius' => 2];
        $circle2 = ['radius' => 2];
        $payload = ['circle1' => $circle1, 'circle2' => $circle2];
        $jsonData = json_encode($payload);

        $client->request('POST', '/circle/sum-objects', [], [], [], $jsonData);

        $response = $client->getResponse();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));

        $responseData = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('totalAreas', $responseData);
        $this->assertArrayHasKey('totalDiameters', $responseData);

        // Assert the calculated total areas and total diameters
        $this->assertEquals(25.14, $responseData['totalAreas']);
        $this->assertEquals(8, $responseData['totalDiameters']);
    }
}