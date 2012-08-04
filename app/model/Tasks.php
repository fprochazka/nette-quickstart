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



	/**
	 * @param int $userId
	 *
	 * @return \Nette\Database\Table\Selection
	 */
	public function findIncompleteByUser($userId)
	{
		return $this->findIncomplete()->where(array(
			'user_id' => $userId
		));
	}



	/**
	 * @param int $taskListId
	 * @param string $task
	 * @param int $assignedUser
	 *
	 * @return \Nette\Database\Table\ActiveRow
	 */
	public function createTask($taskListId, $task, $assignedUser)
	{
		return $this->getTable()->insert(array(
			'text' => $task,
			'user_id' => $assignedUser,
			'created' => new \DateTime(),
			'tasklist_id' => $taskListId
		));
	}



	/**
	 * @param int $id
	 */
	public function markDone($id)
	{
		$this->findOneBy(array('id' => $id))->update(array('done' => 1));
	}

}
