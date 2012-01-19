<?php

/**
 * Homepage presenter.
 *
 * @author Michal Kos
 */
class HomepagePresenter extends BasePresenter
{

	public function renderDefault()
	{
		$this->model->table('users')->where(array('username' => 'x'))->fetch();
		
	}

}
