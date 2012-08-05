<?php

namespace TaskList;

use Nette;



class TaskListControl extends Nette\Application\UI\Control
{

	/**
	 * @var boolean
	 */
	public $displayUser = TRUE;

	/**
	 * @var boolean
	 */
	public $displayTaskList = FALSE;

	/**
	 * @var \Nette\Database\Table\Selection
	 */
	private $selected;

	/**
	 * @var Tasks
	 */
	private $tasks;



	/**
	 * @param \Nette\Database\Table\Selection $selected
	 * @param Tasks $tasks
	 */
	public function __construct(Nette\Database\Table\Selection $selected, Tasks $tasks)
	{
		parent::__construct(); // we have to call constructor from parent class
		$this->selected = $selected;
		$this->tasks = $tasks;
	}



	/**
	 * @param int $taskId
	 */
	public function handleMarkDone($taskId)
	{
		$this->tasks->markDone($taskId);
		if (!$this->presenter->isAjax()) {
			$this->presenter->redirect('this');
		}

		$this->invalidateControl();
	}



	public function render()
	{
		$this->template->setFile(__DIR__ . '/TaskList.latte');
		$this->template->tasks = $this->selected;
		$this->template->displayUser = $this->displayUser;
		$this->template->displayTaskList = $this->displayTaskList;
		$this->template->render();
	}

}
