<?php

namespace Elgg\Http;

use Elgg\IntegrationTestCase;

class ClientIntegrationTest extends IntegrationTestCase {
	
	public function testCanCreateHttpClient() {
		$this->assertInstanceOf(\Elgg\Http\Client::class, elgg_get_http_client());
	}
	
	public function testCanPassOptions() {
		$client = elgg_get_http_client(['foo' => 'bar']);
		
		$reflector = new \ReflectionClass($client);
		$reflector = $reflector->getParentClass();
		$property = $reflector->getProperty('config');
		$property->setAccessible(true);
		
		$config = $property->getValue($client);
		
		$this->assertArrayHasKey('foo', $config);
		$this->assertEquals('bar', $config['foo']);
	}
}
