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
		$insert = $this->model->insert('users', array('username' => 'username', 'created' => new DateTime));
		$id = (int) $insert->id;
		
		$users = $this->model->table('users');
		$users->where($users->getPrimary(), $id)->delete();
		
	}

}
