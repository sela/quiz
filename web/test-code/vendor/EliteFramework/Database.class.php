<?php

/**
 * Database
 *
 * This is how we access the database in the Elite framework.  No fancy ORM
 * stuff, but it does the job.
 */
class Database {
	/**
	 * @return Database
	 */
	public static function getInstance() {
		// Magic
	}

	/**
	 * SELECT query
	 *
	 * This runs the SQL and returns the results as an array.  Eg.
	 *
	 * $database->select('SELECT * FROM users WHERE  <= ?', array(2));
	 *
	 * Might return:
	 *
	 * array(
	 *   array('id' => 1, 'name' => 'User 1'),
	 *   array('id' => 2, 'name' => 'User 2')
	 * )
	 *
	 * @param string $sql
	 * @param array $params
	 * @return array
	 */
	public function select($sql, $params=array()) {

	}

	/**
	 * Run an INSERT query
	 *
	 * Eg.
	 *
	 * $database->insert("INSERT INTO users SET name = ?", array('Ross'));
	 *
	 * @param string $sql
	 * @param array $params
	 */
	public function insert($sql, $params=array()) {

	}
}
