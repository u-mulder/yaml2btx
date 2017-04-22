<?php
/**
 * Yaml2Btx\Generator examples
 *
 * @author u_mulder <m264695502@gmail.com>
 */

error_reporting(E_ALL);
require_once "./vendor/autoload.php";

/* Instantiate new generator */
$g = new \Yaml2Btx\Generator();

/* Generate file from provided config `iblock.yaml` and store it as `new_iblock.php` */
$g->parse('./config/iblock.yaml')->save('./output/new_iblock.php');

/* Generate file from provided config `iblock.yaml` and donwload it */
//$g->parse('./bxcodegen/configs/iblock.yaml')->download(); // TODO

echo 'DONE!' . PHP_EOL;
