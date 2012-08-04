<?php



/**
 * Presenter, který zajišťuje výpis seznamů úkolů.
 */
class TaskPresenter extends BasePresenter
{

	/**
	 * @var TaskList\TaskLists
	 */
	private $taskLists;

	/**
	 * @var \Nette\Database\Table\ActiveRow
	 */
	private $list;



	protected function startup()
	{
		parent::startup();
		$this->taskLists = $this->context->taskLists;
	}



	public function actionDefault($id)
	{
		$this->list = $this->taskLists->find($id);
		if ($this->list === FALSE) {
			$this->setView('notFound');
		}
	}



	public function renderDefault()
	{
		$this->template->taskList = $this->list;
		$this->template->tasks = $this->taskLists->tasksOf($this->list);
	}

}
