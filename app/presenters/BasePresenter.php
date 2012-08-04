<?php

use Nette\Application\UI\Form;



/**
 * Base presenter for all application presenters.
 *
 * @property callable $newTasklistFormSubmitted
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	/**
	 * @var TaskList\TaskLists
	 */
	private $taskLists;



	protected function startup()
	{
		parent::startup();
		$this->taskLists = $this->context->taskLists;
	}



	public function beforeRender()
	{
		$this->template->taskLists = $this->taskLists->findAll()->order('title ASC');
	}



	protected function createComponentNewTasklistForm()
	{
		if (!$this->getUser()->isLoggedIn()) {
			$this->redirect('Sign:in');
		}

		$form = new Form();
		$form->addText('title', 'Název:', 15, 50)
			->addRule(Form::FILLED, 'Musíte zadat název seznamu úkolů.');

		$form->addSubmit('create', 'Vytvořit');
		$form->onSuccess[] = $this->newTasklistFormSubmitted;

		return $form;
	}



	public function newTasklistFormSubmitted(Form $form)
	{
		$tasklist = $this->taskLists->createList($form->values->title);
		$this->flashMessage('Seznam úkolů založen.', 'success');
		$this->redirect('Task:default', $tasklist->id);
	}



	public function handleSignOut()
	{
		$this->getUser()->logout();
		$this->redirect('Sign:in');
	}

}
