<?php

/**
 * Presenter that allows only logged in users.
 */
abstract class SecuredPresenter extends BasePresenter
{

	protected function startup()
	{
		parent::startup();

		if (!$this->getUser()->isLoggedIn()) {
			$this->redirect('Sign:in');
		}
	}

}
