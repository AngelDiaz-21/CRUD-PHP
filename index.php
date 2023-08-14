<?php
//! Se configuran los errores, se habilitan todos los errores para que se puedan mostrar en la APP, esto para evitar estar imprimiendo o usando var_dumps
error_reporting(E_ALL); // Error/Exception engine, always use E_ALL
ini_set('ignore_repeated_errors', TRUE); // Always use TRUE
ini_set('display_erros', FALSE); //Error/Exception display, use FALSE only in production
ini_set('log_errors', TRUE); //Error/Exception file logging engine
// URL del archivo donde se van a guardar los logs
ini_set("error_log", "C:/laragon/www/crud-php/php-error.log");
error_log('Inicio de app');

require_once 'classes/errormessages.php';
require_once 'classes/successmessages.php';
require_once 'libs/database.php';
require_once 'libs/controller.php';
require_once 'libs/model.php';
require_once 'libs/view.php';
require_once 'classes/sessionController.php';
require_once 'libs/app.php';

require_once 'config/config.php';

	$app = new App();
	// phpinfo();
?>