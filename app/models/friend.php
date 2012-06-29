<?php
/*	app/models/friends.php
		* Contiene las restricciones del modelo de los datos de friends.
		* @authors: Pablo Herrera & Mariano Vallés
*/
class Friend extends AppModel{
	var $name = "Friend";
	var $belongsTo = array('User');
}
