<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
   /**
    * Contiene el perfil del usuario
    *
    * @var int
    */
   public $perf_id;

   /**
    * Contiene el centro familiar al que pertenece el usuario
    *
    * @var int
    */
   public $cefa_id;

   /**
    * Componentes del sistema
    *
    * @var array
    */
   public $components = array(
      'Session',
      'Paginator',
      'DebugKit.Toolbar',
      'Auth' => array(
         'flash' => array(
            'element' => 'auth',
            'key' => 'auth',
            'params' => array()
         ),
         'loginAction' => array(
            'controller' => 'usuarios',
            'action' => 'login',
            'plugin' => null
         ),
         'authError' => 'Su sesión ha terminado.',
         'authenticate' => array(
            'Form' => array(
               'userModel' => 'Usuario',
               'fields' => array(
                  'username' => 'usua_username',
                  'password' => 'usua_password'
               )
            )
         )
      )
   );

   /**
    * Sobreescritura beforeFilter
    *
    * @return void
    */
   public function beforeFilter() {
      $url = $this->request->url .'/'. $this->params->action;
      $this->set(compact('url'));

      if ($this->Auth->loggedIn()) {
         if (!empty($this->Auth->user('PerfilUsuario.perf_id'))) {
            $this->perf_id = $this->Auth->user('PerfilUsuario.perf_id');
            $this->set('perf_id', $this->Auth->user('PerfilUsuario.perf_id'));
         }

         if (!empty($this->Auth->user('PerfilUsuario.cefa_id'))) {
            $this->cefa_id = $this->Auth->user('PerfilUsuario.cefa_id');
            $this->set('cefa_id', $this->Auth->user('PerfilUsuario.cefa_id'));
         }
      }

      parent::beforeFilter();
   }
}
