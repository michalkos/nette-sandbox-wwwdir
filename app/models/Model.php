<?php

/**
 * Basic Model class
 * @author Michal Kos
 */
class Model extends Nette\Object
{
	
	/** @var Nette\Database\Connection */
	public $db;

	
	/**
	 * @param Nette\Database\Connection $database
	 */
	public function __construct(Nette\Database\Connection $database)
	{
		$this->db = $database;
	}

	
	/**
	 * @param string $table Table name
	 * @return Nette\Database\Table\Selection
	 */
	public function table($table)
	{
		return $this->db->table($table);
	}
	
	
	/**
	 * Load Model
	 * @param string $name Class name
	 * @param Nette\DI\Container|NULL $context You can need to set a context sometimes
	 * @return \{$name}
	 */
	public function loadModel($name, Nette\DI\Container $context = null)
	{
		return new $name($this, $context);
	}
	
	
	/**
	 * Insert new row
	 * @param string $table
	 * @param array $values
	 * @return Nette\Database\Table\ActiveRow|FALSE 
	 */
	public function insert($table, $values)
	{
		return $this->table($table)->insert($values);
	}
	
	
	/**
	 * Update a row
	 * @param string $table
	 * @param array $values
	 * @param array|int $where
	 * @param bool $solvePrimary Get a primary column automatically
	 * @return int|FALSE
	 */
	public function update($table, $values, $where = null, $solvePrimary = true)
	{
		if(is_null($where)) {
			return $this->table($table)->update($values);
			
		} else {
			if(is_int($where) && $where > 0 && $solvePrimary) {
				$primary = $this->table($table)->getPrimary();
				$where = array($primary => $where);
			}
			
			return $this->table($table)->where($where)->update($values);
		}
	}
	
	
	/**
	 * Delete a row
	 * @param string $table
	 * @param array|int $where
	 * @param bool $solvePrimary Get a primary column automatically
	 * @return int|FALSE 
	 */
	public function delete($table, $where, $solvePrimary = true)
	{
		if(is_int($where) && $where > 0 && $solvePrimary) {
			$primary = $this->table($table)->getPrimary();
			$where = array($primary => $where);
		}
		
		return $this->table($table)->where($where)->delete();
	}
	

}