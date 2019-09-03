<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class CategoriaTest extends TestCase
{
    private $http;

    public function setUp()
    {
        $this->http = new \GuzzleHttp\Client(['base_uri' => 'http://localhost/backend-challenge/app/public/index.php/']);
    }

    public function tearDown() {
        $this->http = null;
    }
    
    public function testCreate()
    {
        $response = $this->http->post('categoria', [
            'query' => [
                'nome' => 'test'
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());        
    }
    
    public function testDelete()
    {
        $response = $this->http->delete('categoria/4');

        $this->assertEquals(200, $response->getStatusCode());        
    }
    
    public function testUpdate()
    {
        $response = $this->http->put('categoria/6', [
            'query' => [
                'nome' => 'TEST'
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());        
    }
    
    public function testRead()
    {
        $response = $this->http->get('categoria/10');

        $this->assertEquals(200, $response->getStatusCode());        
    }
}