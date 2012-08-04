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
		$this->tasks = $this->context->tasks;
	}



	public function createComponentIncompleteTasks()
	{
		return new TaskList\TaskListControl($this->tasks->findIncomplete(), $this->tasks);
	}

}
