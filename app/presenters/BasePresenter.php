<?php

/**
 * Base class for all application presenters.
 *
 * @author Michal Kos
 * @method \SystemContainer getContext() getContext()
 * @property \SystemContainer $context
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	
	/** @var \Model */
	protected $model;

	protected function startup()
	{
		parent::startup();
		$this->model = $this->getContext()->model;
	}
	
}
