<?php
/**
 * Genio - Resume Template 
 *
 * @license     http://themeforest.com/license
 * @version     1.0
 * @package     genio
 */
/**
 * Path to root dir
 */
define( 'INC_ROOT', dirname(__FILE__) );

//include both config and mailer
require_once INC_ROOT . '/config.php';
require_once INC_ROOT . '/mailer.php';

/**
 * New mailer instance
 *
 * @since 1.0
 * @var object
 */
$Mailer  = new Mailer(array(
		'contact_emails' => $contact_emails,
		'hire_me_emails' => $hire_me_emails,
		'contact_email_plain_tpl' => $contact_email_plain_tpl,
		'hire_me_email_plain_tpl' => $hire_me_email_plain_tpl
	));

//check if there is an action
if(!isset($_POST['action'])){
	die();
}

//check if action come from contact form
if($_POST['action'] == 'contact'){
	//if there is any bad data return response
	if(!$Mailer->clearContactData()){
		$Mailer->getResponse();
	}
	//send mail and return response
	$Mailer->sendFeedbackMail();
	$Mailer->getResponse();
}
//check if action come from hire form
if($_POST['action'] == 'hire'){
	//if there is any bad data return response
	if(!$Mailer->clearHireData()){
		$Mailer->getResponse();
	}
	//send mail and return response
	$Mailer->sendHiremeMail();
	$Mailer->getResponse();
}