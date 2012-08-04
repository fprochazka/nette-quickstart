<?php

/**
 * Base presenter for all application presenters.
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

}
