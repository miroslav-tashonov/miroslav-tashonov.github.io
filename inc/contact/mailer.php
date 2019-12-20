<?php
/**
 * Genio - Resume Template 
 *
 * @license     http://themeforest.com/license
 * @version     1.0
 * @package     genio
 */

/**
 * Send emails
 * 
 * @since 1.0
 */
class Mailer {
	
	/**
	 * Contact emails
	 *
	 * @since 1.0
	 * @access private
	 * @var string a list of contact emails 
	 */
	private $contact_emails;

	/**
	 * Hire emails
	 *
	 * @since 1.0
	 * @access private
	 * @var string a list of hire me emails
	 */
	private $hire_me_emails;

	/**
	 * Contact message plaing tpl
	 *
	 * @since 1.0
	 * @access private
	 * @var string contact me email template
	 */
	private $contact_email_plain_tpl;

	/**
	 * Hire message plain tpl
	 *
	 * @since 1.0
	 * @access private
	 * @var string hire me email template
	 */
	private $hire_me_email_plain_tpl;

	/**
	 * Contact me data
	 *
	 * @since 1.0
	 * @access private
	 * @var array client submitted feedback data
	 */
	private $feedback_data = array(
		'default_subject' => 'Feedback',
	);

	/**
	 * Hire me data
	 *
	 * @since 1.0
	 * @access private
	 * @var array client submitted hire me data
	 */
	private $hireme_data = array(
		'default_subject' => 'Hire Request',
	);

	/**
	 * Default response
	 *
	 * @since 1.0
	 * @access private
	 * @var array mailer created response
	 */
	private $response = array(
            'status' => 'error',
            'data' => ''
      );

	/**
	 * Class constructor
	 *
	 * @since 1.0
	 * @access public
	 * @param array $data
	 * @return void
	 */
	public function __construct($data)
	{
		$this->contact_emails = $data['contact_emails'];
		$this->hire_me_emails = $data['hire_me_emails'];
		$this->contact_email_plain_tpl = $data['contact_email_plain_tpl'];
		$this->hire_me_email_plain_tpl = $data['hire_me_email_plain_tpl'];
	}

	/**
	 * Move all the shit away that may come from contact form
	 *
	 * @since 1.0
	 * @access public
	 * @return bool
	 */
	public function clearContactData()
	{
		if(!function_exists('mail')){
			$this->response['data'] = 'Internal server error.';
			return false;
		}
		if( !(isset($_POST['is_legit'])) || !(empty($_POST['is_legit'])) ){
			$this->response['data'] = 'Bad request.';
			return false;
		}

		$this->feedback_data['contact_name'] = (isset($_POST['contact_name'])) ? trim(filter_var($_POST['contact_name'], FILTER_SANITIZE_STRING)) : false;
		$this->feedback_data['contact_email'] = (isset($_POST['contact_email'])) ? trim(filter_var($_POST['contact_email'], FILTER_SANITIZE_EMAIL)) : false;
		$this->feedback_data['contact_subject'] = (isset($_POST['contact_subject'])) ? trim(filter_var($_POST['contact_subject'], FILTER_SANITIZE_STRING)) : false;
		$this->feedback_data['contact_message'] = (isset($_POST['contact_message'])) ? trim(filter_var($_POST['contact_message'], FILTER_SANITIZE_STRING)) : false;

		if( ($this->feedback_data['contact_name'] === false) || (empty($this->feedback_data['contact_name'])) ){
			$this->response['data'] = 'Please provide your name.';
			return false;
		}

		if(strlen($this->feedback_data['contact_name']) < 3){
			$this->response['data'] = 'Provided name is too short.';
			return false;
		}

		if( ($this->feedback_data['contact_email'] === false) || (empty($this->feedback_data['contact_email'])) || !(filter_var($this->feedback_data['contact_email'], FILTER_VALIDATE_EMAIL)) ){
			$this->response['data'] = 'Please provide your email.';
			return false;
		}
		// uncomment to make subject required
		if( ($this->feedback_data['contact_subject'] === false)/* || (empty($this->feedback_data['contact_subject']))*/ ){
			$this->response['data'] = 'Please provide a subject.';
			return false;
		}
	
		if( ($this->feedback_data['contact_message'] === false) || (empty($this->feedback_data['contact_message'])) ){
			$this->response['data'] = 'Please provide your message.';
			return false;
		}

		if(strlen($this->feedback_data['contact_message']) < 5){
			$this->response['data'] = 'Provided message is too short.';
			return false;	
		}
		
		return true;
	}

	/**
	 * Move all the shit away that may come from hire me form
	 *
	 * @since 1.0
	 * @access public
	 * @return bool
	 */
	public function clearHireData()
	{
		if(!function_exists('mail')){
			$this->response['data'] = 'Internal server error.';
			return false;
		}
		if( !(isset($_POST['is_legit'])) || !(empty($_POST['is_legit'])) ){
			$this->response['data'] = 'Bad request.';
			return false;
		}

		$this->hireme_data['hireme_name'] = (isset($_POST['hireme_name'])) ? trim(filter_var($_POST['hireme_name'], FILTER_SANITIZE_STRING)) : false;
		$this->hireme_data['hireme_email'] = (isset($_POST['hireme_email'])) ? trim(filter_var($_POST['hireme_email'], FILTER_SANITIZE_EMAIL)) : false;
		$this->hireme_data['hireme_timeframe'] = ( (isset($_POST['hireme_timeframe'])) && (in_array($_POST['hireme_timeframe'], array('1','2','3','4','5','6'))) ) ? $_POST['hireme_timeframe'] : false;
		$this->hireme_data['hireme_experience'] = ( (isset($_POST['hireme_experience'])) && (in_array($_POST['hireme_experience'], array('1','2','3','4','5'))) ) ? $_POST['hireme_experience'] : false;
		$this->hireme_data['hireme_process'] = ( (isset($_POST['hireme_process'])) && (in_array($_POST['hireme_process'], array('1','2','3','4'))) ) ? $_POST['hireme_process'] : false;
		$this->hireme_data['hireme_package'] = ( (isset($_POST['hireme_package'])) && (in_array($_POST['hireme_package'], array('1','2','3'))) ) ? $_POST['hireme_package'] : false;
		$this->hireme_data['hireme_requirements'] = (isset($_POST['hireme_requirements'])) ? trim(filter_var($_POST['hireme_requirements'], FILTER_SANITIZE_STRING)) : false;

		if( ($this->hireme_data['hireme_name'] === false) || (empty($this->hireme_data['hireme_name'])) ){
			$this->response['data'] = 'Please provide your name.';
			return false;
		}

		if(strlen($this->hireme_data['hireme_name']) < 3){
			$this->response['data'] = 'Provided name is too short.';
			return false;	
		}

		if( ($this->hireme_data['hireme_email'] === false) || (empty($this->hireme_data['hireme_email'])) || !(filter_var($this->hireme_data['hireme_email'], FILTER_VALIDATE_EMAIL)) ){
			$this->response['data'] = 'Please provide your email.';
			return false;
		}
	
		if( ($this->hireme_data['hireme_timeframe'] === false) || (empty($this->hireme_data['hireme_timeframe'])) ){
			$this->response['data'] = 'Please provide a timeframe.';
			return false;
		}

		if( ($this->hireme_data['hireme_experience'] === false) || (empty($this->hireme_data['hireme_experience'])) ){
			$this->response['data'] = 'Please provide experience level.';
			return false;
		}

		if( ($this->hireme_data['hireme_process'] === false) || (empty($this->hireme_data['hireme_process'])) ){
			$this->response['data'] = 'Please provide process.';
			return false;
		}

		if( ($this->hireme_data['hireme_package'] === false) || (empty($this->hireme_data['hireme_package'])) ){
			$this->response['data'] = 'Please provide a prefered package.';
			return false;
		}

		if( ($this->hireme_data['hireme_requirements'] === false) || (empty($this->hireme_data['hireme_requirements'])) ){
			$this->response['data'] = 'Please provide project requirements.';
			return false;
		}

		if(strlen($this->hireme_data['hireme_requirements']) < 5){
			$this->response['data'] = 'Provided project requirements is too short.';
			return false;	
		}

		$this->hireme_data['hireme_timeframe'] = str_replace(array('1','2','3','4','5','6'), array(
				"As soon as possible (rush job)",
				"Within 1 week (rush job)",
				"Within 2 weeks",
				"Within a month",
				"Sometime in the next few months",
				"I'm not really sure"
			), $this->hireme_data['hireme_timeframe']);
		$this->hireme_data['hireme_experience'] = str_replace(array('1','2','3','4','5'), array(
				"Not much, I'll need your help",
				"Average - I surf the web",
				"I can design websites",
				"I can hand code HTML",
				"I'm not really sure"
			), $this->hireme_data['hireme_experience']);
		$this->hireme_data['hireme_process'] = str_replace(array('1','2','3','4'), array(
				"I'm just starting to explore options",
				"I'm sending out requests to a few vendors",
				"I want to use you, I just need some more details",
				"I'm ready to get started, where do I send payment?"
			), $this->hireme_data['hireme_process']);
		$this->hireme_data['hireme_package'] = str_replace(array('1','2','3'), array(
				"designer",
				"developer",
				"speaker"
			), $this->hireme_data['hireme_package']);

		return true;
	}

	/**
	 * Send feedback message
	 *
	 * @since 1.0
	 * @access public
	 * @return bool
	 */
	public function sendFeedbackMail()
	{
		$headers = "MIME-Version: 1.0" . PHP_EOL;
		$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
		$message = str_replace(
			array('__NAME__', 
				'__EMAIL__', 
				'__SUBJECT__',
				'__MESSAGE__'),
			array($this->feedback_data['contact_name'],
				$this->feedback_data['contact_email'],
				$this->feedback_data['contact_subject'],
				$this->feedback_data['contact_message']), 
			$this->contact_email_plain_tpl);
		$this->feedback_data['contact_name'] = stripslashes(html_entity_decode($this->feedback_data['contact_name'], ENT_QUOTES));
		$this->feedback_data['contact_email'] = stripslashes(html_entity_decode($this->feedback_data['contact_email'], ENT_QUOTES));
		$headers .= "From: {$this->feedback_data['contact_name']} <{$this->feedback_data['contact_email']}>" . PHP_EOL;

		if( mail($this->contact_emails, $this->feedback_data['default_subject'], stripslashes(html_entity_decode($message, ENT_QUOTES)), $headers) ){
			$this->response['status'] = 'success';
			$this->response['data'] = "Thanks, We will respond as soon as possible.";
			return true;
		}else{
			$this->response['data'] = "Error, please, try again later";
			return false;
		}
	}

	/**
	 * Send hire me message
	 *
	 * @since 1.0
	 * @access public
	 * @return bool
	 */
	public function sendHiremeMail()
	{
		$headers = "MIME-Version: 1.0" . PHP_EOL;
		$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
		$message = str_replace(
			array('__NAME__', 
				'__EMAIL__', 
				'__TIMEFRAME__',
				'__EXPERIENCE__',
				'__PROCESS__',
				'__PACKAGE__',
				'__REQUIREMENTS__'), 
			array($this->hireme_data['hireme_name'],
				$this->hireme_data['hireme_email'],
				 $this->hireme_data['hireme_timeframe'],
				 $this->hireme_data['hireme_experience'],
				 $this->hireme_data['hireme_process'],
				 $this->hireme_data['hireme_package'],
				 $this->hireme_data['hireme_requirements']),
			$this->hire_me_email_plain_tpl);
		$this->hireme_data['hireme_name'] = stripslashes(html_entity_decode($this->hireme_data['hireme_name'], ENT_QUOTES));
		$this->hireme_data['hireme_email'] = stripslashes(html_entity_decode($this->hireme_data['hireme_email'], ENT_QUOTES));
		$headers .= "From: {$this->hireme_data['hireme_name']} <{$this->hireme_data['hireme_email']}>" . PHP_EOL;
 
		if( mail($this->hire_me_emails, $this->hireme_data['default_subject'], stripslashes(html_entity_decode($message, ENT_QUOTES)), $headers) ){
			$this->response['status'] = 'success';
			$this->response['data'] = "Thanks, We will respond as soon as possible.";
			return true;
		}else{
			$this->response['data'] = "Error, please, try again later";
			return false;
		}
	}

	/**
	 * Get response
	 *
	 * @since 1.0
	 * @access public
	 * @return string
	 */
	public function getResponse()
	{
		if($this->isAjax()){
            	header('Content: application/json');
            	echo json_encode($this->response);
            }else{
            	echo $this->response['data'];
            }
            die();
	}

	/**
	 * Check if request is ajax
	 *
	 * These global vars set by jquery
	 * 
	 * @since 1.0
	 * @access private
	 * @return bool
	 */
	private function isAjax()
	{
		if( !isset($_SERVER['HTTP_X_REQUESTED_WITH']) ){
			return false;
		}
		if( (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) || (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') ){
			return false;
		}
		return true;
	}
}