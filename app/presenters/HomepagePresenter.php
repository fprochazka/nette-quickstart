<?php

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

	/**
	 * @var TaskList\Tasks
	 */
	private $tasks;



	protected function startup()
	{
		parent::startup();

		if (!$this->getUser()->isLoggedIn()) {
			$this->redirect('Sign:in');
		}

		$this->tasks = $this->context->tasks;
	}



	/**
	 * @return TaskList\TaskListControl
	 */
	public function createComponentIncompleteTasks()
	{
		return new TaskList\TaskListControl($this->tasks->findIncomplete(), $this->tasks);
	}



	/**
	 * @return TaskList\TaskListControl
	 */
	public function createComponentUserTasks()
	{
		$incomplete = $this->tasks->findIncompleteByUser($this->getUser()->getId());
		$control = new TaskList\TaskListControl($incomplete, $this->tasks);
		$control->displayTaskList = TRUE;
		$control->displayUser = FALSE;
		return $control;
	}

}
