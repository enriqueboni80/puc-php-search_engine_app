#!/usr/bin/php
<?php

require 'vendor/autoload.php';

use App\EnterCommand;
use Symfony\Component\Console\Application;

$console = new Application();
$console->add(new EnterCommand());
$console->run();




