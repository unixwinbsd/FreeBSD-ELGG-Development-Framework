<?php

namespace Elgg\Discussions;

use Elgg\Plugins\RouteResponseIntegrationTestCase;

class RouteResponseTest extends RouteResponseIntegrationTestCase {

	protected $allow_global_discussions;
	
	/**
	 * @var \ElggPlugin
	 */
	protected $plugin;
	
	public function up() {
		parent::up();
		
		$this->plugin = elgg_get_plugin_from_id('discussions');
		$this->allow_global_discussions = $this->plugin->getSetting('enable_global_discussions');
		$this->plugin->setSetting('enable_global_discussions', true);
	}
	
	public function down() {
		$this->plugin->setSetting('enable_global_discussions', $this->allow_global_discussions);
		
		parent::down();
	}
	
	public function getSubtype() {
		return 'discussion';
	}
	
	public function groupRoutesProtectedByToolOption() {
		return [
			[
				'route' => "collection:object:{$this->getSubtype()}:group",
				'tool' => 'forum',
			],
		];
	}
}
