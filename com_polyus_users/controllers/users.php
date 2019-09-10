<?php
/**
* @version    CVS: 1.0.0
* @package    Com_Polyus_users
* @author     Cristopher Chong <cris_chong2@hotmail.com>
* @copyright  2019 Cristopher Chong
* @license    GNU General Public License version 2 or later; see LICENSE.txt
*/

// No direct access.
defined('_JEXEC') or die;

/**
* Users list controller class.
*
* @since  1.6
*/
class Polyus_usersControllerUsers extends Polyus_usersController
{
	/**
	* Proxy for getModel.
	*
	* @param   string  $name    The model name. Optional.
	* @param   string  $prefix  The class prefix. Optional
	* @param   array   $config  Configuration array for model. Optional
	*
	* @return object	The model
	*
	* @since	1.6
	*/
	public function &getModel($name = 'Users', $prefix = 'Polyus_usersModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}
	public function reg(){
		$get = (object)JRequest::get();
		$app = JFactory::getApplication();
    jimport('joomla.filesystem.file');


		if($get->email){

			$user = new JUser;
			$pass = rand(0, 99999999);
			$data['email'] = JStringPunycode::emailToPunycode($get->email);
			$data['password'] = $pass;
			$data['name'] = $get->name;
			$data['username'] = $get->email;
			$data['groups'][] = 2;

			$model = $this->getModel('Users', 'Polyus_usersModel');


			if (!$user->bind($data))
			{
				die('error');
			}

			if (!$user->save())
			{
				die('error');
			}else{
				$pathh = '';
				if($get->pic){

					$singleFile = $model->base64_to_pic($get->pic, 'user__'.rand().'.png');

					$filename = JFile::stripExt($singleFile);
					$extension = JFile::getExt($singleFile);
					$filename = preg_replace('/[^\w_]+/u', "-", $filename);
					$filename = $filename . '.' . $extension;
					$uploadPath = JPATH_ROOT . '/images/users/' . $filename;
					$path = '/images/users/' . $filename;
					$fileTemp = $singleFile;

					if (!JFile::exists($uploadPath))
					{

						if (!JFile::copy($fileTemp, $uploadPath))
						{
              $pathh = $path;
						}

						$pathh = $path;

					}
				}

				$db = JFactory::getDbo();
				$query = $db->getQuery(true);
				$columns = array('state', 'name', 'lastname', 'email', 'phone', 'subdivision', 'pic');
				$values = array(1, $db->quote($get->name),  $db->quote($get->lastname), $db->quote($get->email), $db->quote($get->phone), $db->quote($get->be), $db->quote($pathh));
				$query
				->insert($db->quoteName('#__polyus_users'))
				->columns($db->quoteName($columns))
				->values(implode(',', $values));
				$db->setQuery($query);
				$db->execute();

				$activity = $model->getActivity($get->email);
				$addInfo = $model->getAddInfo($get->email);
				$total_activity = $model->getAllActivity();

				$logged_user = $user;

				$addInfo = $model->getAddInfo($logged_user->email);

				$logged_user->lastname = $addInfo->lastname;
				$logged_user->phone = $addInfo->phone;
				$logged_user->company = $addInfo->company;
				$logged_user->subdivision = $addInfo->subdivision;
				$logged_user->pic = $addInfo->pic;
				$logged_user->password = '';

				$logged_user->lastname = $addInfo->lastname;

				$logged_user->email = $addInfo->email;
				$logged_user->currentmail = $addInfo->email;

				$logged_user->phone = $addInfo->phone;
				$logged_user->company = $addInfo->company;
				$logged_user->subdivision = $addInfo->subdivision;
				$logged_user->pic = $addInfo->pic;

				$logged_user->activity = $activity;

				$logged_user->total = $total_activity;

				$mailer = JFactory::getMailer();
				$config = JFactory::getConfig();
				$sender = array(
					$config->get( 'mailfrom' ),
					$config->get( 'fromname' )
				);
        $mailer->setSubject('Регистрация');
				$mailer->setSender($sender);
				$mailer->addRecipient($logged_user->email);
				$body   = '<h3>Вы успешно зарегистрировались в Polyus Sport!</h3>'
				. '<p><b>Логин: </b>'.$logged_user->email.'</p>'
				. '<p><b>Пароль: </b>'.$pass.'</p>';
				$mailer->isHtml(true);
				$mailer->Encoding = 'base64';
				$mailer->setBody($body);
				$send = $mailer->Send();
				if ( $send !== true ) {
					$message = 'Мы отправили вам пароль по электронной почте. Далее, его можно будет изменить в личном кабинете.';
					$app->redirect(JRoute::_('/'), $message, 'success');
				} else {
					$message = 'Мы отправили вам пароль по электронной почте. Далее, его можно будет изменить в личном кабинете.';
					$app->redirect(JRoute::_('/'), $message, 'success');
				}



			}

		}
	}
}
