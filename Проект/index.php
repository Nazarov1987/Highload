<?php
require_once('vendor/autoload.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

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

