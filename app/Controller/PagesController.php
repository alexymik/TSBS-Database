<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Bulletin', 'Vehicle');

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function display() {

		// TODO: Make 'function getLast5Bulletins($make = null, $year = null, $year = null) {}'

		$this->set('title_for_layout', 'TSBS Database');

		$latest_bulletins = array();

		$makes = $this->Vehicle->find('all', array(
			'order' => array('MAKE ASC'),
			'group' => array('MAKE')
		));

		// Get a list of all makes from the DB, this is always displayed

		$makes_formatted = array();

		foreach($makes as $make) {
			array_push($makes_formatted, $make['Vehicle']['MAKE']);
		}

		$this->set('makes', $makes_formatted);

		// Filtering goes in order by: MAKE > YEAR > MODEL
		// Shows the last 5 entries for the furthest filtered item

		if (isset($_POST['data']['Page']['make']) && $_POST['data']['Page']['make']) {
			
			$selected_make = $_POST['data']['Page']['make'];
			$this->set('selected_make', $selected_make);

			$years = $this->Vehicle->find('all', array(
				'conditions' => array(
					'MAKE' => $makes_formatted[$selected_make]
				), 
				'group' => array('YEAR'),
			 	'order' => array('YEAR DESC') //Newest first
			 ));


			$years_formatted = array();

			// Get an array of only years for the form
			foreach($years as $year) {
				array_push($years_formatted, $year['Vehicle']['YEAR']); 
			}

			$this->set('years', $years_formatted);

			if (isset($_POST['data']['Page']['year']) && is_numeric($_POST['data']['Page']['year'])) {

				$selected_year = $_POST['data']['Page']['year'];

				$this->set('selected_year', $selected_year);

				$models = $this->Vehicle->find('all', array(
					'conditions' => array(
						'MAKE' => $makes_formatted[$selected_make], 
						'YEAR' => $years_formatted[$selected_year]
					),
					'group' => array('MODEL'),
					'order' => array('MODEL ASC')
				));

				$models_formatted = array();
				foreach($models as &$model) {
					array_push($models_formatted, $model['Vehicle']['MODEL']);
				}

				$this->set('models', $models_formatted);

				if (isset($_POST['data']['Page']['model']) && $_POST['data']['Page']['model']) {

					$selected_model = $_POST['data']['Page']['model'];
					$this->set('selected_model', $selected_model);

					$latest_bulletins = $this->Bulletin->find('all', array(
						//'limit' => 5,
						'order' => array(
							'BUL_DATE DESC'
						), 
						'conditions' => array(
							'MODEL' => $models_formatted[$selected_model],
							'MAKE' => $makes_formatted[$selected_make],
							'YEAR' => $years_formatted[$selected_year]
						),
						// 'group' => array(
						// 	'BUL_NO'
						// )
					));

				} else {

					$latest_bulletins = $this->Bulletin->find('all', array(
						'limit' => 5, 
						'order' => array(
							'BUL_DATE DESC'
						), 
						'conditions' => array(
							'MAKE' => $makes_formatted[$selected_make],
							'YEAR' => $years_formatted[$selected_year]
						),
						// 'group' => array(
						// 	'BUL_NO'
						// )
					));

				}

			} else {

				$latest_bulletins = $this->Bulletin->find('all', array(
					'limit' => 5,
					'order' => array(
						'BUL_DATE DESC'
					),
					'conditions' => array(
						'MAKE' => $makes_formatted[$selected_make]
					),
					// 'group' => array(
					// 	'BUL_NO'
					// )
				));
			}

		} else {

			// Show the last 5 bulletins added if nothing is selected
			$latest_bulletins = $this->Bulletin->find('all', array(
				'limit' => 5,
				'order' => array('BULLETIN.BUL_DATE DESC')
			));

		}

		$this->set('bulletins', $latest_bulletins);

		$this->render('home');
	}


}