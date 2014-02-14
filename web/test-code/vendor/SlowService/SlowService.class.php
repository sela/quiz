<?php

/**
 * SlowService
 *
 * Our service is slow and not that reliable either.  To make up for it we've
 * made it easier for you to cache the results via the
 * registerWidgetChangeListener() listener method.
 */
class SlowService {
	/**
	 * @return SlowService
	 */
	public static function getInstance() {
		// Mystery stuff
	}

	/**
	 * Get all widgets from the slow service
	 *
	 * @throws SlowServiceException
	 * @return SlowServiceWidget[]
	 */
	public function getWidgets() {
		// Mystery stuff
	}

	/**
	 * Get a single widget from the slow service
	 *
	 * Returns null if the widget doesn't exist
	 *
	 * @throws SlowServiceException
	 * @param int $id
	 * @return SlowServiceWidget
	 */
	public function getWidget($id) {
		// Mystery stuff
	}

	/**
	 * Register a widget change listener
	 *
	 * This will call the PHP callable listener with an array of the widget ids
	 * which have changed.
	 *
	 * @param mixed $callable
	 */
	public function registerWidgetChangeListener($callable) {
		// Mystery stuff
	}
}
