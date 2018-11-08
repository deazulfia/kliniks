<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

function init_date_variable(){
	return "1800-01-01 00:00:00";
}

function date_now(){
   	$time = new DateTime(date('Y-m-d', time()));
	$stamp = $time->format('Y-m-d');
	return $stamp;
}

function date_time(){
	$time = new DateTime(date('Y-m-d H:i:s', time()));
	$stamp = $time->format('Y-m-d H:i:s');
	return $stamp;
}

function get_month(){
   	$time = new DateTime(date('Y-m-d H:i:s', time()));
	$stamp = $time->format('M-Y');
	return $stamp;
}

function get_month_id(){
	$time = new DateTime(date('Y-m-d H:i:s', time()));
 	$stamp = $time->format('Ym');
 	return $stamp;
}

function time_now(){
	$time = new DateTime(date('H:i:s', time()));
	$stamp = $time->format('H:i:s');
	return $stamp;
}

function generate_random_string() {
	$length = 25;
    return substr(str_shuffle("123456789abcdefghijklmnopqrstuvwxyz"), 0, $length);
}

