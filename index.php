<?php
/**
 *
 *    阿里云DDNS-API By D-Jy
 *
 *    MIT License
 *
 */

date_default_timezone_set('UTC');

include_once 'AlicloudUpdateRecord.php';

use Roura\Alicloud\V20150109\AlicloudUpdateRecord;

/**
 *使用说明
 *eg. http://xxx.com/?ip=127.0.0.1&name=d-jy.net&type=A&rr=www
 *URL未指定参数时自动解析当前设备ip eg. http://xxx.com
 */

//参数说明：
//data	记录值	eg. x.x.x.x or xxx.com ....
//name	根域名	eg. d-jy.net
//type	解析类型	eg. A CNAME....
//rr	二级域名	eg. @ www ....

//id	AccessKeyId
//secret 	AccessKeySecret


//设置开始

//以下设置在URL中未定义时生效
$Name	= 'xzhang.ink';	//指定根域名   eg. d-jy.net
$Type	= 'A';		//指定解析类型 eg. A CNAME....
$rr	= '@';		//指定主机记录 eg. @ www ....
 
//以下设置留空则网页获取
$AccessKeyId	= '';
$AccessKeySecret	= '';

//设置结束


//以下内容谨慎修改

$ip		= $_GET['ip'];	//获取IP
$data		= $_GET['data'];	//获取DATA
$KeyId		= $_GET['id'];	//获取AccessKeyId
$KeySecret	= $_GET['secret'];	//获取AccessKeySecret

$DomainName	= $_GET['name'];	//获取域名
$RecordType	= $_GET['type'];	//获取解析类型 eg. A CNAME....
$RR	 	= $_GET['rr'];	//获取解析记录

$test		= $_GET['debug'];	//Debug

$updater         = new AlicloudUpdateRecord($AccessKeyId, $AccessKeySecret);

	//如果IP不存在或者为空
	if((!isset($ip) || ($ip == ''))) {
		//获取IP
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		   $ip = $_SERVER['HTTP_CLIENT_IP'];
		}else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		   $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
 		   $ip= $_SERVER['REMOTE_ADDR'];
		}  
	}

	//如果data不存在或者为空
	if((!isset($data) || ($data == ''))) {
		$data = $ip;
	}
	//如果KeyId不存在或者为空
	if((!isset($AccessKeyId) || ($AccessKeyId == ''))) {
		$AccessKeyId = $KeyId;
	}
	//如果KeySecret不存在或者为空
	if((!isset($AccessKeySecret) || ($AccessKeySecret == ''))) {
		$AccessKeySecret = $KeySecret;
	}

	//如果DomainName不存在或者为空
	if((!isset($DomainName) || ($DomainName == ''))) {
		$DomainName = $Name;
	}
	//如果RecordType不存在或者为空
	if((!isset($RecordType) || ($RecordType == ''))) {
		$RecordType = $Type;
	}
	//如果RR不存在或者为空
	if((!isset($RR) || ($RR == ''))) {
		$RR = $rr;
	}


$updater->setDomainName($DomainName);
$updater->setRecordType($RecordType);
$updater->setRR($RR);
$updater->setValue($data);

//Debug
if((!isset($test) || ($test == 'false'))) {
echo "OK";
 }else{
	echo "<h1>Debug</h1>";
	echo "</br>";
	echo "Data: ";
	echo $data;
	echo "</br>";
	echo "DomainName: ";
	echo $DomainName;
	echo "</br>";
	echo "Type: ";
	echo $RecordType;
	echo "</br>";
	echo "RR: ";
	echo $RR;
	echo "</br>";
	echo "Result: ";
	print_r($updater->sendRequest());
	} 
