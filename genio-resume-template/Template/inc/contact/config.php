<?php
/**
 * Genio - Resume Template 
 *
 * @license     http://themeforest.com/license
 * @version     1.0
 * @package     genio
 */

/**
 * Add contact email here
 *
 * You will receive contact me form messages to this email
 * You can provide single or multi emails
 * 
 * eg. hello@gmail.com
 * eg. hello@gmail.com, hello@yahoo.com
 * eg. hello@gmail.com, hello@yahoo.com, hello@fastmail.com
 *
 * @since 1.0
 * @var string
 */
$contact_emails = 'put@email.here';

/**
 * Add hire me email here
 *
 * You will receive hire me form messages to this email
 * You can provide single or multi emails
 * 
 * eg. hire@gmail.com
 * eg. hire@gmail.com, hire@yahoo.com
 * eg. hire@gmail.com, hire@yahoo.com, hire@fastmail.com
 *
 * @since 1.0
 * @var string
 */
$hire_me_emails = 'put@email.here';

/**
 * Contact message plain template
 *
 * In plain message newline character become \n
 * 
 * Available Filters
 * __NAME__
 * __EMAIL__
 * __SUBJECT__
 * __MESSAGE__
 *
 * Each of these filters will replaced later with client submitted data
 * 
 * @since 1.0
 * @var string
 */
$contact_email_plain_tpl = "Name: __NAME__\nEmail: __EMAIL__\nSubject: __SUBJECT__\nMessage: __MESSAGE__";

/**
 * Hire me message plain template
 *
 * In plain message newline character become \n
 * 
 * Available Filters
 * __NAME__
 * __EMAIL__
 * __TIMEFRAME__
 * __EXPERIENCE__
 * __PROCESS__
 * __PACKAGE__
 * __REQUIREMENTS__
 *
 * Each of these filters will replaced later with client submitted data
 * 
 * @since 1.0
 * @var string
 */
$hire_me_email_plain_tpl = "Name: __NAME__\n Email: __EMAIL__\nTimeframe: __TIMEFRAME__\nExperience Level: __EXPERIENCE__\nProcess: __PROCESS__\nPackage: __PACKAGE__\nRequirements: __REQUIREMENTS__";