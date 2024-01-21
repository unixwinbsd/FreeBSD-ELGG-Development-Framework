<?php
/**
 * Walled garden body
 *
 * @uses $vars['messages'] System messages
 * @uses $vars['header'] Page header
 * @uses $vars['content'] Page content
 * @uses $vars['footer'] Page footer
 */
?>
<div class="elgg-page elgg-page-walled-garden">
	<div class="elgg-page-walled-garden-background"></div>
	<div class="elgg-page-messages">
		<?= elgg_extract('messages', $vars); ?>
	</div>
	<div class="elgg-inner">
		<header class="elgg-page-header">
			<div class="elgg-inner">
				<?= elgg_extract('header', $vars); ?>
			</div>
		</header>
		<main class="elgg-page-body">
			<div class="elgg-inner">
				<?= elgg_extract('content', $vars); ?>
			</div>
		</main>
		<footer class="elgg-page-footer">
			<div class="elgg-inner">
				<?= elgg_extract('footer', $vars); ?>
			</div>
		</footer>
	</div>
</div>
