<?php

namespace Elgg\Cache;

class RuntimeCacheUnitTest extends BaseCacheUnitTestCase {

	function createCache(string $namespace = 'runtime_test') {
		return new CompositeCache($namespace, _elgg_services()->config, ELGG_CACHE_RUNTIME);
	}
}
