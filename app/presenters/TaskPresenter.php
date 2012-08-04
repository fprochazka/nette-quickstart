<?php

use Nette\Application\UI\Form;



/**
 * Presenter, který zajišťuje výpis seznamů úkolů.
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
		$this->template->tasks = $this->taskLists->tasksOf($this->list);
	}



	/**
	 * @throws Nette\Application\BadRequestException
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
			->addRule(Form::FILLED, 'Je nutné vybrat, komu je úkol přiřazen.');

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
		$this->redirect('this');
	}

}
