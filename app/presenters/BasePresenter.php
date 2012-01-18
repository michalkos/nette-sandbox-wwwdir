<?php

/**
 * Base class for all application presenters.
 *
 * @author Michal Kos
 * @method \SystemContainer|\Nette\DI\Container getContext() getContext()
 * @property \SystemContainer|\Nette\DI\Container $context
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	
	/** @var \Model */
	protected $model;

	protected function startup()
	{
		parent::startup();
		$this->model = $this->getService('model');
	}
	
}
