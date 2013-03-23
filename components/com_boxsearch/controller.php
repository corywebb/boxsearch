<?php
/**
 * @package         Joomla.Administrator
 * @subpackage      com_boxsearch
 *
 * @copyright       Copyright (C) 2013 Servant Holdings LLC
 * @license         GNU General Public License version 3
 */

class BoxsearchController extends JControllerLegacy
{



	public function __construct($config = array())
	{
		JLoader::register('BoxsearchHelper', __DIR__ . '/helpers/boxsearch.php');
		parent::__construct($config);
		$app = JFactory::getApplication();

		// register tasks
		$this->registerTask('authenticate', 'authenticate');
		$this->registerTask('setClientSecret', 'setClientSecret');

		$model = $this->getModel('Clientsecret');
		$refresh = $model->refresh();

		// do we need to refresh
		if ($refresh)
		{
			JFactory::getApplication()->input->set('task', 'authenticate');
		}

		// set the secrets
		if ($app->input->get('state')=='authenticated' && $app->input->get('code'))
		{
			JFactory::getApplication()->input->set('task', 'setClientSecret');
		}

	}
	public function authenticate()
	{
		echo BoxsearchHelper::authenticateBox();
	}
	public function setClientSecret()
	{
		$token = $this->getClientSecret();

		if(isset($token->error))
		{
			$this->setMessage($token->error . " " . $token->error_description, 'error');
			$this->setRedirect(
			JRoute::_('index.php?option=' . $this->option, false));
		}

		$model = $this->getModel('Clientsecret');
		$model->setSecret($token);
		 

		 
		$this->setMessage(JText::_('COM_BOXSEARCH_AUTHENTICATE_SUCCESS'), 'success');
		$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&redirect=0', false));
     }
     public function getClientSecret()
     {
     	return BoxsearchHelper::getClientSecret();
     }
}