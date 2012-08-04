<?php

namespace TaskList;

use Nette;



/**
 * @author Filip Procházka <filip.prochazka@kdyby.org>
 */
class TaskLists extends Table
{

	/**
	 * @var string
	 */
	protected $tableName = 'tasklist';



	/**
	 * @param \Nette\Database\Table\ActiveRow $taskList
	 *
	 * @return \Nette\Database\Table\Selection
	 */
	public function tasksOf(Nette\Database\Table\ActiveRow $taskList)
	{
		return $taskList->related('task')->order('created');
	}



	/**
	 * @param string $title
	 * @return \Nette\Database\Table\ActiveRow
	 */
	public function createList($title)
	{
		return $this->getTable()->insert(array(
			'title' => $title
		));
	}

}
