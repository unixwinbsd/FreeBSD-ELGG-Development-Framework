<?php

namespace Elgg\Cache;

use Elgg\UnitTestCase;
use Phpfastcache\Cluster\ClusterPoolInterface;

class SystemCacheUnitTest extends UnitTestCase {

	/**
	 * @var bool previous System Cache enabled state
	 */
	protected $is_enabled;
	
	public function up() {
		$this->is_enabled = _elgg_services()->config->system_cache_enabled;
		_elgg_services()->config->system_cache_enabled = false;
	}

	public function down() {
		_elgg_services()->config->system_cache_enabled = $this->is_enabled;
	}

	public function testCanEnableSystemCache() {

		elgg_enable_system_cache();

		$this->assertTrue(elgg_is_system_cache_enabled());

		elgg_disable_system_cache();

		$this->assertFalse(elgg_is_system_cache_enabled());

	}

	public function testCanStoreValuesInSystemCache() {

		$cache = elgg_get_system_cache();

		$cache->save('foo', 'bar');

		$this->assertEquals('bar', $cache->load('foo'));

		$cache->delete('foo');

		$this->assertNull($cache->load('foo'));
	}

	public function testCanStoreValuesInSystemCacheUsingApiMethods() {

		elgg_enable_system_cache();

		elgg_save_system_cache('foo', 'bar');

		$this->assertEquals('bar', elgg_load_system_cache('foo'));

		elgg_reset_system_cache();

		$this->assertNull(elgg_load_system_cache('foo'));
	}

	public function testCanNotStoreValuesInSystemCacheWhenDisabled() {

		elgg_disable_system_cache();

		$this->assertFalse(elgg_save_system_cache('foo', 'bar'));

		$this->assertNull(elgg_load_system_cache('foo'));

		elgg_enable_system_cache();

		elgg_save_system_cache('foo', 'bar');

		$this->assertEquals('bar', elgg_load_system_cache('foo'));

		elgg_disable_system_cache();

		$this->assertNull(elgg_load_system_cache('foo'));

		elgg_reset_system_cache();
	}
	
	public function testCanDeleteSingleKeyFromCache() {
		elgg_enable_system_cache();
		elgg_reset_system_cache();
		
		elgg_save_system_cache('foo', 'bar');
		elgg_save_system_cache('foo2', 'bar2');
		
		$this->assertTrue(elgg_delete_system_cache('foo'));
		$this->assertNull(elgg_load_system_cache('foo'));
		
		$this->assertEquals('bar2', elgg_load_system_cache('foo2'));
		
		elgg_reset_system_cache();
	}
	
	public function testCanStoreItemWithTTL() {
		elgg_enable_system_cache();
		elgg_reset_system_cache();
		
		elgg_save_system_cache('foo', 'bar', 1);
		
		$pool = $this->getInaccessableProperty(elgg_get_system_cache(), 'pool');
		
		if ($pool instanceof ClusterPoolInterface) {
			$this->markTestSkipped('Unable to test a cluster as it does not implement detachAllItems for all pool drivers');
		}
		
		$pool->detachAllItems();
		
		// need to wait longer than the previous set TTL
		sleep(2);
		$this->assertNull(elgg_load_system_cache('foo'));
		
		elgg_save_system_cache('foo', 'bar', 5);
		$pool->detachAllItems();
		
		$this->assertEquals('bar', elgg_load_system_cache('foo'));
	}
}
