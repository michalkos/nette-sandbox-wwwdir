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
		$this->model->insert('users', array('username' => 'username', 'created' => new DateTime));
		$id = (int) $this->model->db->lastInsertId();
		
		$users = $this->model->table('users');
		$users->where($users->getPrimary(), $id)->delete();
		
	}

}
