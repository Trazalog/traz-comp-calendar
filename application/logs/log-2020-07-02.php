<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

DEBUG - 2020-07-02 17:32:41 --> UTF-8 Support Enabled
DEBUG - 2020-07-02 17:32:41 --> No URI present. Default controller set.
DEBUG - 2020-07-02 17:32:41 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2020-07-02 17:32:41 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
DEBUG - 2020-07-02 17:32:41 --> Total execution time: 0.1271
DEBUG - 2020-07-02 17:32:43 --> UTF-8 Support Enabled
DEBUG - 2020-07-02 17:32:43 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2020-07-02 17:32:43 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
DEBUG - 2020-07-02 17:32:43 --> #TRAZA | #REST | #CURL | #URL >> http://localhost:8080/eventos
DEBUG - 2020-07-02 17:32:46 --> #TRAZA | #REST | #CURL >> Fallo Conexión
ERROR - 2020-07-02 17:33:03 --> Severity: Warning --> Cannot modify header information - headers already sent C:\xampp\htdocs\traz-comp-calendar\system\core\Common.php 570
ERROR - 2020-07-02 17:33:03 --> Severity: Error --> Uncaught Exception: Failed to connect to localhost port 8080: Connection refused in C:\xampp\htdocs\traz-comp-calendar\application\libraries\REST.php:76
Stack trace:
#0 C:\xampp\htdocs\traz-comp-calendar\application\models\traz-comp-calendar\Calendarios.php(16): REST->callAPI('GET', 'http://localhos...')
#1 C:\xampp\htdocs\traz-comp-calendar\application\controllers\Calendario.php(19): Calendarios->getEventos()
#2 C:\xampp\htdocs\traz-comp-calendar\system\core\CodeIgniter.php(532): Calendario->getEventos()
#3 C:\xampp\htdocs\traz-comp-calendar\index.php(315): require_once('C:\\xampp\\htdocs...')
#4 {main}
  thrown C:\xampp\htdocs\traz-comp-calendar\application\libraries\REST.php 76
