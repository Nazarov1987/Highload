<?php
require_once('vendor/autoload.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

if($redis->get('price')==false){
$time_start = microtime();
   $mysql = new mysqli('127.0.0.1', 'root', 'Altair1215!', 'db_vagrant');
if ($mysql->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
else{echo 'Connected' ."<br>\n";}

  $query = "SELECT productName,productDescription,buyPrice FROM products WHERE productCode = 'S24_2011'";
   $result = mysqli_query($mysql,$query);
   while($row = mysqli_fetch_array($result))
   {
echo "Вывод из БД" ."<br>\n";
echo "Наименование товара: ".$row['productName']."<br>\n";
echo "Описание: ".$row['productDescription']."<br>\n";
echo "Цена: ".$row['buyPrice']."<br><hr>\n";
$time_end = microtime();
$time = $time_end - $time_start;
echo 'Время выполнения БД: ' . $time;
$redis->set('name', $row['productName']);
$redis->set('desk', $row['productDescription']);
$redis->set('price', $row['buyPrice']);
   }
}
else{
$time_start = microtime();
echo "Вывод из Redis";
var_dump($redis->get('name'));
var_dump($redis->get('desk'));
var_dump($redis->get('price'));
$time_end = microtime();
$time = $time_end - $time_start;
echo 'Время выполнения Radis: ' . $time;
};



// create a log channel
$log = new Logger('main');

$infoSH = new StreamHandler('log/info.log', Logger::INFO);
$debugSH = new StreamHandler('log/debug.log', Logger::DEBUG);
$errSH = new StreamHandler('log/error.log', Logger::ERROR);

$log->pushHandler($infoSH);
$log->pushHandler($debugSH);
$log->pushHandler($errSH);

$time_start = time();

// add records to the log
$log->info('info');
$log->notice('notice');
$log->debug('debug');
$log->warning('warning');
$log->alert('alert');
$log->error('error');
$log->emergency('emergency');

$time_end = time();

$log->debug($time_end - $time_start);

$log->debug(memory_get_usage());


