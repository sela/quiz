<?php

/**
 * BaseTask
 *
 * This is the base class for a scheduled task, to be run via cron or similar.
 */
abstract class BaseTask {
	/**
	 * Run the task
	 */
	abstract public function run();
}
