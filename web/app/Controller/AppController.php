<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
  public $helpers = array('Html', 'Form');
  public $components = array('Cookie', 'Session');

  public function beforeFilter() {
    parent::beforeFilter();
	$this->loadModel('Config');
	$this->loadModel('AppModel');
    $this->Cookie->name = 'ZoneMinder';
    if (!$this->Cookie->read('zmBandwidth')) {
      $this->Cookie->write('zmBandwidth', 'low', false);
    }
  $this->set('zmBandwidth', $this->Cookie->read('zmBandwidth'));


	$configFile =  "/usr/local/etc/zm.conf";
	$localConfigFile = basename($configFile);
	$options = $this->Config->find('list', array('fields' => array('Name', 'Value')));
	foreach ($options as $key => $value) {
		Configure::write($key, $value);
	}
  }
}