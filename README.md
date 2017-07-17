# phpplaysms
PHP Extension using PlaySMS

#How To Use
...php
require_once __DIR__ ."/vendor/autoload.php";
use \alimasyhur\phpplaysms\PlaySms;

$playsms = new PlaySms([
    'url' => 'http://example.com/index.php',
    'user' => 'youruser',
    'token' => 'yourtoken'
]);

$arrNumber = ['+628xxxxxxx','+628xyxyxyxxy''];
$message = 'Hello World';
$response = $playsms->send($arrNumber, #message);
var_dump($response);
exit(1);
...