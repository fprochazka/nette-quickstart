<?php

namespace TaskList;

use Nette;



/**
 * @author Filip Procházka <filip.prochazka@kdyby.org>
 */
class Users extends Table
{

	/**
	 * @var string
	 */
	protected $tableName = 'user';



	/**
	 * @param string $username
	 * @return \Nette\Database\Table\ActiveRow
	 */
	public function findByName($username)
	{
		return $this->findAll()->where('username', $username)->fetch();
	}



	/**
	 * @param int $id
	 * @param string $password
	 */
	public function setPassword($id, $password)
	{
		$this->getTable()->where(array('id' => $id))->update(array(
			'password' => Authenticator::calculateHash($password)
		));
	}

}
