<?php
/*	app/models/users.php
		* Contiene las restricciones del modelo de los datos del usuario.
		* @authors: Pablo Herrera & Mariano Vallés
*/
class User extends AppModel {
    var $name = 'User';
	var $hasMany = array('Friend');
 	var $validate = array(	'name' => array('rule'=>array('custom', '/^[a-z0-9 ]*$/i')),
			'lastname' => array('alphaNumeric'),
			'username' => array('rule' =>array('alphaNumeric','isUnique')),
			'email' => array('rule' => array('email')),
			'password' => array('rule' => array('confirmPassword', 'password')),
			'password_confirm' => array('rule' => 'alphanumeric','required' => true),
			//	'pic' => array('rule' => array(
			//					'extension', array('gif', 'jpeg', 'png', 'jpg'),
			//					'allowEmpty'=>true
			//					)
			//			)
			);




	/*	confirmPassword
			* verifica mediante dos campos si la contraseña insertada por un usuario coincide.
			@sets: -
			@params: data, campos del formulario.
			@return: boolean, si es valido o no.
	*/	
  	function confirmPassword($data) {
		$valid = false;
		if ($data['password'] == Security::hash(Configure::read('Security.salt') . $this->data['User']['password_confirm'])) {
			$valid = true;
		}
		return $valid;
	}
    
}
?>
