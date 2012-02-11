<?php

/**
 * Basic Model class for dibi
 * @author Michal Kos
 */
class Model extends Nette\Object
{
	
	/** @var DibiConnection */
	protected $db;

	/** @var string */
	public $sql;
	
	/**
	 * @param Nette\Database\Connection $database
	 */
	public function __construct($parameters, $name = 'dibi0')
	{
		if( ! (isset($this->db) && $this->db->isConnected())) {
			if(isset($parameters['name'])) unset($parameters['name']);
			$this->db = dibi::connect($parameters, $name);
		}
	}
	
	
	/**
	 * Load Model
	 * @param string $name Class name
	 * @param Nette\DI\Container|NULL $context You can need to set a context sometimes
	 * @return \Model\{$name}|\{$name}
	 */
	public function loadModel($name, Nette\DI\Container $context = null)
	{
		$name = ucfirst($name);
		$class = 'Model\\' . $name;
		
		if (class_exists($class)) {
			$model = new $class($this, $context);
		} else {
			$model = new $name($this, $context);
		}
		
		return $model;
	}
	
	
	/**
	 * @param string $table Table name
	 * @param mixed $select Select columns
	 * @return DibiFluent
	 */
	public function table($table, $select = null)
	{
		if(is_null($select)) {
			$select = '*';
		}
		
		return $this->db->select($select)->from($table);
	}
	
	
	/**
	 * Generates and executes SQL query - Monostate for DibiConnection::query().
	 * @param  array|mixed      one or more arguments
	 * @return DibiResult|int   result set object (if any)
	 * @throws DibiException
	 */
	public function query($args)
	{
		$args = func_get_args();
		
		$q = $this->db->query($args);
		$this->sql = dibi::$sql;
		
		return $q;
	}
	
	
	/**
	 * Get Data Source from SQL query
	 * @param  array|mixed      one or more arguments
	 * @return DibiDataSource 
	 */
	public function dataSourceQuery($args)
	{
		$args = func_get_args();
		return $this->db->dataSource($args);
	}
	
	
	/**
	 * Get Data Source
	 * @param string $table Table name
	 * @param bool $valid_till If TRUE - 'where valid_till is null' is applied
	 * @return DibiDataSource 
	 */
	public function getDataSource($table, $valid_till = false)
	{
		$q[] = 'SELECT * FROM %n';
		$q[] = $table;
		
		if($valid_till) {
			$q[] = 'WHERE [valid_till] IS NULL';
		}
		
		return $this->dataSourceQuery($q);
	}
	
}