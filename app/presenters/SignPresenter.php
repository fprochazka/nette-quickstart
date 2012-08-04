<?php

use Nette\Application\UI\Form;
use Nette\Security as NS;


/**
 * Sign in/out presenters.
 *
 * @property callable $signInFormSubmitted
 */
class SignPresenter extends BasePresenter
{

	/**
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = new Form();
		$form->addText('username', 'Uživatelské jméno:', 30, 20);
		$form->addPassword('password', 'Heslo:', 30);
		$form->addCheckbox('persistent', 'Pamatovat si mě na tomto počítači');

		$form->addSubmit('login', 'Přihlásit se');
		$form->onSuccess[] = $this->signInFormSubmitted;

		return $form;
	}



	/**
	 * @param Nette\Application\UI\Form $form
	 */
	public function signInFormSubmitted(Form $form)
	{
		try {
			$user = $this->getUser();
			$values = $form->getValues();
			if ($values->persistent) {
				$user->setExpiration('+30 days', FALSE);
			}
			$user->login($values->username, $values->password);
			$this->flashMessage('Přihlášení bylo úspěšné.', 'success');
			$this->redirect('Homepage:');

		} catch (NS\AuthenticationException $e) {
			$form->addError('Neplatné uživatelské jméno nebo heslo.');
		}
	}

}
