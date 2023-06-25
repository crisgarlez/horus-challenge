<?php

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TriangleControllerTest extends WebTestCase
{
    public function testGetTriangle()
    {
        $client = static::createClient();

        $client->request('GET', '/triangle/3/4/5');

        $response = $client->getResponse();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));

        $expectedData = [
            'surface' => '6.0',
            'circumference' => '12.0',
            'type' => 'triangle',
            'a' => '3.0',
            'b' => '4.0',
            'c' => '5.0',
        ];
        $responseData = json_decode($response->getContent(), true);

        $this->assertSame($expectedData, $responseData);
    }

    public function testSumObjects()
    {
        $client = static::createClient();

        $triangle1 = ['a' => 3, 'b' => 4, 'c' => 5];
        $triangle2 = ['a' => 3, 'b' => 4, 'c' => 5];
        $payload = ['triangle1' => $triangle1, 'triangle2' => $triangle2];
        $jsonData = json_encode($payload);

        $client->request('POST', '/triangle/sum-objects', [], [], [], $jsonData);

        $response = $client->getResponse();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));

        $responseData = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('totalAreas', $responseData);
        $this->assertArrayHasKey('totalDiameters', $responseData);

        // Assert the calculated total areas and total diameters
        $this->assertEquals(12, $responseData['totalAreas']);
        $this->assertEquals(24, $responseData['totalDiameters']);
    }
}