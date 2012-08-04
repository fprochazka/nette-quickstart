<?php

namespace TaskList;

use Nette;



/**
 * @author Filip Procházka <filip.prochazka@kdyby.org>
 */
class Tasks extends Table
{

	/**
	 * @var string
	 */
	protected $tableName = 'task';



	/**
	 * @return \Nette\Database\Table\Selection
	 */
	public function findIncomplete()
	{
		return $this->findBy(array('done' => false))->order('created ASC');
	}

}
