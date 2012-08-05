<?php

use Nette\Application\UI\Form;



/**
 * Presenter that ensures the listing of task lists.
 *
 * @property callable $taskFormSubmitted
 */
class TaskPresenter extends BasePresenter
{

	/**
	 * @var TaskList\TaskLists
	 */
	private $taskLists;

	/**
	 * @var TaskList\Tasks
	 */
	private $tasks;

	/**
	 * @var TaskList\Users
	 */
	private $users;

	/**
	 * @var \Nette\Database\Table\ActiveRow
	 */
	private $list;



	protected function startup()
	{
		parent::startup();

		if (!$this->getUser()->isLoggedIn()) {
			$this->redirect('Sign:in');
		}

		$this->taskLists = $this->context->taskLists;
		$this->tasks = $this->context->tasks;
		$this->users = $this->context->users;
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
	}



	/**
	 * @return TaskList\TaskListControl
	 */
	protected function createComponentTaskList()
	{
		if ($this->list === NULL) {
			$this->error('Wrong action');
		}

		return new TaskList\TaskListControl($this->taskLists->tasksOf($this->list), $this->tasks);
	}



	/**
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentTaskForm()
	{
		$userPairs = $this->users->findAll()->fetchPairs('id', 'name');

		$form = new Form();
		$form->addText('text', 'Úkol:', 40, 100)
			->addRule(Form::FILLED, 'Je nutné zadat text úkolu.');
		$form->addSelect('userId', 'Pro:', $userPairs)
			->setPrompt('- Vyberte -')
			->addRule(Form::FILLED, 'Je nutné vybrat, komu je úkol přiřazen.')
			->setDefaultValue($this->getUser()->getId());

		$form->addSubmit('create', 'Vytvořit');
		$form->onSuccess[] = $this->taskFormSubmitted;

		return $form;
	}



	/**
	 * @param Nette\Application\UI\Form $form
	 */
	public function taskFormSubmitted(Form $form)
	{
		$this->tasks->createTask($this->list->id, $form->values->text, $form->values->userId);
		$this->flashMessage('Úkol přidán.', 'success');
		if (!$this->isAjax()) {
			$this->redirect('this');
		}

		$form->setValues(array('userId' => $form->values->userId), TRUE);
		$this->invalidateControl('form');
		$this['taskList']->invalidateControl();
	}

}
