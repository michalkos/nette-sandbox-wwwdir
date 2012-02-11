<?php

namespace Model;

use Nette;

/**
 * Extend this when you are creating a Model
 * @author Michal Kos
 */
abstract class BaseModel extends Nette\Object
{
	
	/** @var \Model */
	public $model;
	
	/** @var \SystemContainer|\Nette\DI\Container|NULL */
	protected $context;
	
	/** @var bool */
	protected $modelStarted = false;
	
	
	/**
	 * ModelFactory Construct
	 * @param \Model $model
	 * @param Nette\DI\Container|NULL $context
	 */
	public function __construct(\Model $model, Nette\DI\Container $context = NULL)
	{
		$this->model = $model;
		$this->context = $context;
		$this->startup();
	}
	
	
	/**
	 * This is always called after model initialization
	 */
	protected function startup()
	{
		$this->modelStarted = true;
	}
	
}