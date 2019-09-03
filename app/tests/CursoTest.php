<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class CursoTest extends TestCase
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
        $response = $this->http->post('curso', [
            'query' => [
                'titulo' => 'test',
                'tipo' => 'tipo test'
            ],
            'json' => ['TEST']
        ]);

        $this->assertEquals(200, $response->getStatusCode());        
    }
    
    public function testDelete()
    {
        $response = $this->http->delete('curso/1');

        $this->assertEquals(200, $response->getStatusCode());        
    }
    
    public function testUpdate()
    {
        $response = $this->http->put('curso/3', [
            'query' => [
                'titulo' => 'TEST'
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());        
    }
    
    public function testRead()
    {
        $response = $this->http->get('curso/4');

        $this->assertEquals(200, $response->getStatusCode());        
    }
}