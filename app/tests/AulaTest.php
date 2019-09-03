<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class AulaTest extends TestCase
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
        $response = $this->http->post('aula', [
            'query' => [
                'titulo' => 'test 22',
                'link' => 'http://www.google.com'
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());        
    }
    
    public function testDelete()
    {
        $response = $this->http->delete('aula/7');

        $this->assertEquals(200, $response->getStatusCode());        
    }
    
    public function testUpdate()
    {
        $response = $this->http->put('aula/9', [
            'query' => [
                'titulo' => 'TEST'
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());        
    }
    
    public function testRead()
    {
        $response = $this->http->get('aula/9');

        $this->assertEquals(200, $response->getStatusCode());        
    }
}