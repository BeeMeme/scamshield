<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function faucet_sweet_alert($type, $content)
{
	$title = ($type == 'success') ? 'Good job!' : 'Error!';
	return "<script> Swal.fire('" . $title . "', '" . $content . "', '" . $type . "')</script>";
}

function faucet_alert($type, $content)
{
	$icon = ($type == 'success') ? '<i class="far fa-check-circle"></i>' : '<i class="fas fa-exclamation-circle"></i>';
	return '<div class="alert text-center alert-' . $type . '">' . $icon . ' ' . $content . '</div>';
}

function faucetpay($address, $ip_address, $amount, $api, $currency, $referral = false)
{
	$param = array(
		'api_key' => $api,
		'amount' => $amount,
		'to' => $address,
		'currency' => $currency,
		'referral' => $referral,
		'ip_address' => $ip_address
	);
	$url = 'https://faucetpay.io/api/v1/send';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, count($param));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
	$result = json_decode(curl_exec($ch), true);
	curl_close($ch);
	return $result;
}
function fpCheck($address, $api, $currency)
{
	$param = array(
		'api_key' => $api,
		'address' => $address,
		'currency' => $currency,
	);
	$url = 'https://faucetpay.io/api/v1/checkaddress';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, count($param));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
	$result = json_decode(curl_exec($ch), true);
	curl_close($ch);
	return $result;
}

function get_captcha($config, $baseUrl, $slot)
{
	$availableCaptcha = explode('|', $config[$slot]);
	$captchaSelect = '<div class="form-group"><select class="form-control" id="selectCaptcha" name="captcha">';
	$captchaDisplay = '';

	if (!empty($config['recaptcha_v3_site_key']) && in_array('recaptchav3', $availableCaptcha)) {
		$captchaSelect .= '<option value="recaptchav3">Recaptcha V3</option>';
		$captchaDisplay .= '<script src="https://www.google.com/recaptcha/api.js?render=' . $config['recaptcha_v3_site_key'] . '"></script>
		<script>
		grecaptcha.ready(function() {
			grecaptcha.execute("' . $config['recaptcha_v3_site_key'] . '", {action: "homepage"}).then(function(token) {
				$("#recaptchav3Token").val(token);
			});
		});
		</script>
		<input type="hidden" id="recaptchav3Token" name="recaptchav3">
		<div id="recaptchav3" class="captcha" style="display: none;">
		This site is protected by reCAPTCHA and the Google
    <a href="https://policies.google.com/privacy">Privacy Policy</a> and
    <a href="https://policies.google.com/terms">Terms of Service</a> apply.
		</div>';
	}
	if (!empty($config['recaptcha_v2_site_key']) && in_array('recaptchav2', $availableCaptcha)) {
		$captchaSelect .= '<option value="recaptchav2">Recaptcha V2</option>';
		$captchaDisplay .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script><div id="recaptchav2" class="captcha" style="display: none;">
		<div class="g-recaptcha" data-sitekey="' . $config["recaptcha_v2_site_key"] . '"></div></div>';
	}
	if (!empty($config['c_key']) && in_array('solvemedia', $availableCaptcha)) {
		$captchaSelect .= '<option value="solvemedia">Solvemedia</option>';
		include APPPATH . 'third_party/solvemedia.php';
		$captchaDisplay .= '<div id="solvemedia" class="captcha" style="display: none;">' . solvemedia_get_html($config['c_key'], $error = null, $use_ssl = true) . '</div>';
	}
	if (!empty($config['hcaptcha_site_key']) && in_array('hcaptcha', $availableCaptcha)) {
		$captchaSelect .= '<option value="hcaptcha">Hcaptcha</option>';
		$captchaDisplay .= '<div id="hcaptcha" class="captcha" style="display: none;"><script src="https://hcaptcha.com/1/api.js" async defer></script>
		<div class="h-captcha" data-sitekey="' . $config["hcaptcha_site_key"] . '"></div></div>';
	}
	$captchaSelect .= '</select></div>';
	return $captchaSelect . $captchaDisplay;
}
function verifyRecaptchaV3($response, $secretKeys)
{
	$Captcha_url = 'https://www.google.com/recaptcha/api/siteverify';
	$Captcha_data = array('secret' => $secretKeys, 'response' => $response);
	$Captcha_options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($Captcha_data),
		),
	);
	$Captcha_context  = stream_context_create($Captcha_options);
	$Captcha_result = file_get_contents($Captcha_url, false, $Captcha_context);

	$result = json_decode($Captcha_result);
	return ($result->success && $result->score >= 0.3);
}
function verifyRecaptchaV2($response, $secretKeys)
{
	$Captcha_url = 'https://www.google.com/recaptcha/api/siteverify';
	$Captcha_data = array('secret' => $secretKeys, 'response' => $response);
	$Captcha_options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($Captcha_data),
		),
	);
	$Captcha_context  = stream_context_create($Captcha_options);
	$Captcha_result = file_get_contents($Captcha_url, false, $Captcha_context);
	return json_decode($Captcha_result)->success;
}
function verifyHcaptcha($response, $secretKeys, $ipAddress)
{
	$Captcha_url = 'https://hcaptcha.com/siteverify';
	$Captcha_data = array('secret' => $secretKeys, 'response' => $response, 'remoteip' => $ipAddress);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $Captcha_url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $Captcha_data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($ch);
	curl_close($ch);
	$result = @json_decode($result, true);
	if ((!empty($result['success'])) && ($result['success'] == true)) {
		return true;
	}
	return false;
}

function verifySolvemedia($v_key, $h_key, $ipAddress, $adcopyChallenge, $adcopyResponse)
{
	include APPPATH . 'third_party/solvemedia.php';
	$solvemedia_response = solvemedia_check_answer($v_key, $ipAddress, $adcopyChallenge, $adcopyResponse, $h_key);
	return $solvemedia_response->is_valid;
}
if (!function_exists('smtpMailer')) {
	function smtpMailer($email, $subject, $message, $settings)
	{
		require APPPATH . 'third_party/phpmailer/autoload.php';
		$mail = new PHPMailer(true);

		try {
			//Server settings
			$mail->isSMTP();
			// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
			$mail->Host       = $settings['smtp_host'];
			$mail->SMTPAuth   = true;
			$mail->Username   = $settings['smtp_username'];
			$mail->Password   = $settings['smtp_password'];
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
			$mail->Port       = $settings['smtp_port'];

			$mail->setFrom($settings['site_email'], $settings['name']);
			$mail->addAddress($email);

			$mail->isHTML(true);
			$mail->Subject = $subject;
			$mail->Body    = $message;
			$mail->AltBody = 'Active your account';

			$mail->send();
			return true;
		} catch (Exception $e) {
			error_log($mail->ErrorInfo);
			return false;
		}
	}
}
if (!function_exists('ciMail')) {
	function ciMail($email, $subject, $message, $settings)
	{
		$CI = &get_instance();
		$CI->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';

		$CI->email->initialize($config);
		$CI->email->clear();
		$CI->email->from($settings['site_email'], $settings['name']);
		$CI->email->to($email);
		$CI->email->subject($subject);
		$CI->email->message($message);

		if ($CI->email->send()) {
			return true;
		} else {
			return false;
		}
	}
}

function proxycheck($config, $ipAddress)
{
	$result['status'] = 0;
	$result['isocode'] = 'N/A';
	try {
		$request = @json_decode(file_get_contents('http://proxycheck.io/v2/' . $ipAddress . '?key=' . $config['proxycheck'] . '&vpn=1&asn=1&time=1&inf=1&risk=1&tag=UserCheck'), TRUE);
		if (!empty($request['status']) && $request['status'] == 'ok') {
			$result['status'] = ($request[$ipAddress]['proxy'] == 'yes' ? 1 : 0);
			$result['isocode'] = isset($request[$ipAddress]['isocode']) ? ((empty($request[$ipAddress]['isocode']) ? 'N/A' : strtolower($request[$ipAddress]['isocode']))) : 'N/A';
			$result['country'] = isset($request[$ipAddress]['country']) ? ((empty($request[$ipAddress]['country']) ? 'N/A' : $request[$ipAddress]['country'])) : 'N/A';
		}
		return $result;
	} catch (Exception $e) {
		return $result;
	}
}

function iphub($settings, $ipAddress)
{
	$result['status'] = 0;
	$result['isocode'] = 'N/A';
	$key = $settings['iphub'];
	try {
		$ch = curl_init();
		curl_setopt_array($ch, [
			CURLOPT_URL => "http://v2.api.iphub.info/ip/{$ipAddress}",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => ["X-Key: {$key}"]
		]);
		$request = json_decode(curl_exec($ch), TRUE);
		$result['status'] = isset($request['block']) ? $request['block'] : false;
		$result['isocode'] = isset($request['countryCode']) ? (($request['countryCode'] === 'zz') ? 'N/A' : strtolower($request['countryCode'])) : 'N/A';
		$result['country'] = isset($request['countryCode']) ? (($request['countryName'] === 'zz') ? 'N/A' : $request['countryName']) : 'N/A';
		return $result;
	} catch (Exception $e) {
		return $result;
	}
}

function sendMail($email, $subject, $message, $settings)
{
	if ($settings['mail_service'] == 'mail') {
		if (!ciMail($email, $subject, $message, $settings)) {
			$headers = array(
				'MIME-Version' => '1.0',
				'Content-type' => 'text/html;charset=UTF-8',
				'From' => $settings['name'] . ' <' . $settings['site_email'] . '>',
				'Reply-To' => $settings['site_email'],
				'X-Mailer' => 'PHP/' . phpversion()
			);
			if (!mail($email, $subject, $message, $headers)) {
				return false;
			}
		}
		return true;
	} else {
		return smtpMailer($email, $subject, $message, $settings);
	}
}

function get_data($url, $timeout = 15, $header = array(), $options = array())
{
	if (!function_exists('curl_init')) {
		return file_get_contents($url);
	} elseif (!function_exists('file_get_contents')) {
		return '';
	}

	if (empty($options)) {
		$options = array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
			CURLOPT_TIMEOUT => $timeout
		);
	}

	if (empty($header)) {
		$header = array(
			"User-Agent: Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31",
			"Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*\/*;q=0.5",
			"Accept-Language: en-us,en;q=0.5",
			"Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7",
			"Cache-Control: must-revalidate, max-age=0",
			"Connection: keep-alive",
			"Keep-Alive: 300",
			"Pragma: public"
		);
	}

	if ($header != 'NO_HEADER') {
		$options[CURLOPT_HTTPHEADER] = $header;
	}

	$ch = curl_init();
	curl_setopt_array($ch, $options);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function format_money($amount)
{
	return rtrim(rtrim(number_format($amount, 6), '0'), '.');
}

function currency($amount, $rate)
{
	$token = $amount / $rate;
	if ($token > 1) {
		return $token . ' tokens';
	}
	return $token . ' token';
}

function currencyUnit($amount, $rate)
{
	$token = $amount / $rate;
	if ($token > 1) {
		return 'tokens';
	}
	return 'token';
}
