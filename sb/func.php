<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader,
	Bitrix\Highloadblock as HL,
	Bitrix\Main\Entity;

use \Bitrix\Main,
	Bitrix\Main\Application,
	Bitrix\Sale,
	Bitrix\Sale\Order;

Loader::includeModule("highloadblock"); 

function SbGetHlTable(){
	static $hlblockData;

	if (!$hlblockData) {
		$hlblock = HL\HighloadBlockTable::getList([
		    'filter' => ['=NAME' => ['SbConfig', 'SbUser', 'SbPayto', 'SbOrders']]
		])->fetchAll();
		if(!$hlblock){
		    throw new \Exception('HL not found');
		}

		$hlblockData = [];
		foreach($hlblock as $v) {
			$entity = HL\HighloadBlockTable::compileEntity($v);
			$hlblockData[$v['NAME']] = $entity->getDataClass();
		}
	}
	return $hlblockData;
}

function SbGetConfig(){
	static $config;
	if (!$config) {
		$table = SbGetHlTable();
		$config = $table['SbConfig']::getList(array(
			"select" => array("*"),
			"order" => array("ID" => "DESC"),
			'limit' => 1
		))->fetchAll();
	}

	return isset($config[0]) ? $config[0] : false;
}

function SbGetUser($userId = null){
	global $USER;
	if ($userId === null) {
		$userId = $USER->GetID();
	}
	$table = SbGetHlTable();
	$user = $table['SbUser']::getList(array(
		"select" => array("*"),
		'filter' => ['UF_USER' => $userId],
		'limit' => 1
	))->fetchAll();

	if (!$user) {
		$table['SbUser']::add(['UF_USER' => $userId]);
		return SbGetUser();
	}

	return $user[0];
}

function SbSetUser($data, $userId = null){
	$table = SbGetHlTable();
	$user = SbGetUser($userId);
	$table['SbUser']::update($user['ID'], $data);
}

function SbSetUserError($error){
	$table = SbGetHlTable();
	$user = SbGetUser();
	$errors = $user['UF_ERRORS'];
	array_unshift($errors, date('d.m.Y h:i:s').' '.$error);
	$errors = array_slice($errors, 0, 25);

	$table['SbUser']::update($user['ID'], ['UF_ERRORS' => $errors]);
}

function SbGetAuthLink($return){
	$state = md5(uniqid('state_', true));
	$nonce = md5(uniqid('nonce_', true)).md5(uniqid('nonce_', true));
	SbSetUser([
		'UF_STATE' => $state,
		'UF_NONCE' => $nonce,
		'UF_RETURN_PAGE' => $return,
	]);
	$config = SbGetConfig();
	
	$sbLink  = $config['UF_AUTH_URL'];
	$sbLink .= '?redirect_uri=' . $config['UF_REDIRECT_URL'];
	$sbLink .= '&scope='.implode(' ', $config['UF_SCOPE_CONF']);
	$sbLink .= '&nonce='.$nonce;
	$sbLink .= '&state='.$state;
	$sbLink .= '&response_type=code';
	$sbLink .= '&client_id=' . $config['UF_CLIENT_ID_CONF'];
	return $sbLink;
}

function SbGetUserInfo($first = true){
	$user = SbGetUser();
	$config = SbGetConfig();

	if ($user['UF_ACCESS_TOKEN'] && $user['UF_REFRESH_TOKEN']) {

		$return = SbCurlCall(
			$config['UF_USERINFO_URL'],
			false,
			[],
			['Authorization: Bearer '.$user['UF_ACCESS_TOKEN']]
		);

		if ($return) {
			$return = explode('.', $return);
			if (count($return) == 3) {
				$r = json_decode(base64_decode(strtr($return[1], '-_', '+/')), true);
				return $r;
			}
		}

		if ($first) {
			SbGetAccessTokenByRefresh();
			return SbGetUserInfo(false);
		} else {
			SbSetUser([
				'UF_ACCESS_TOKEN' => false,
				'UF_REFRESH_TOKEN' => false,
				'UF_EXPIRES_IN' => false,
			]);
			return false;
		}
	}
	return false;
}

function SbGetAccessTokenByRefresh($userId = null){
	$user = SbGetUser($userId);
	if ($user['UF_REFRESH_TOKEN']) {
		$config = SbGetConfig();
		$data = [
			'grant_type' => 'refresh_token',
			'client_id' => $config['UF_CLIENT_ID_CONF'],
			'refresh_token' => $user['UF_REFRESH_TOKEN'],
			'client_secret' => $config['UF_CLIENT_SECRET_CONF'],
		];
		$r = SbCurlCall($config['UF_TOKEN_URL'], true, $data, ['Content-Type:application/x-www-form-urlencoded']);

		if (isset($r['access_token']) && isset($r['refresh_token']) && isset($r['expires_in'])) {
			SbSetUser([
				'UF_ACCESS_TOKEN' => $r['access_token'],
				'UF_REFRESH_TOKEN' => $r['refresh_token'],
				'UF_EXPIRES_IN' => $r['expires_in'],
			], $userId);
		}
	}
}

function SbGetAccessTokenByCode(){
	$user = SbGetUser();
	$config = SbGetConfig();
	$code = isset($_GET['code']) ? $_GET['code'] : false;
	$state = isset($_GET['state']) ? $_GET['state'] : false;
	$nonce = isset($_GET['nonce']) ? $_GET['nonce'] : false;

	if ($code && $user['UF_NONCE'] == $nonce && $user['UF_STATE'] == $state) {
		$data = [
			'grant_type' => 'authorization_code',
			'code' => $code,
			'client_id' => $config['UF_CLIENT_ID_CONF'],
			'redirect_uri' => $config['UF_REDIRECT_URL'],
			'client_secret' => $config['UF_CLIENT_SECRET_CONF'],
		];

		$r = SbCurlCall($config['UF_TOKEN_URL'], true, $data, ['Content-Type:application/x-www-form-urlencoded']);

		if (isset($r['access_token']) && isset($r['refresh_token']) && isset($r['expires_in'])) {
			SbSetUser([
				'UF_ACCESS_TOKEN' => $r['access_token'],
				'UF_REFRESH_TOKEN' => $r['refresh_token'],
				'UF_EXPIRES_IN' => $r['expires_in'],
				'UF_NONCE' => false,
				'UF_STATE' => false,
			]);
		}
	}
}

function SbCurlCall($url, $isPost = false, $data = [], $header = [], $addHeader = false, $isJson = false){
	$config = SbGetConfig();

	if (!$isPost && count($data)) {
		$url = $url . '?' . http_build_query($data);
	}

	$ch = curl_init($url);
	if ($isPost) {
		curl_setopt($ch, CURLOPT_POST, 1);
		if ($isJson) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		} else {
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));
		}
	}
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_VERBOSE, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, '1');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_CAINFO, $_SERVER['DOCUMENT_ROOT'].CFile::GetPath($config['UF_KEY_CONF']));
	curl_setopt($ch, CURLOPT_SSLCERT, $_SERVER['DOCUMENT_ROOT'].CFile::GetPath($config['UF_PEM_CONF']));
	curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $config['UF_KEY_PASS_CONF']);
	curl_setopt($ch, CURLOPT_HEADER, $addHeader);
	if (count($header)) {
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	}
	$return = curl_exec($ch);
	$curlError = curl_error($ch);
	
// 	if ($return != '{"error":"UNAUTHORIZED"}') {
// 	    var_dump($return, $url, $isPost, $data, $header, $addHeader, $isJson);
// 	    die;
// 	}
	curl_close($ch);

	if ($curlError) {
		// Сохраняем ошибку
		SbSetUserError($url.' !-! '.$curlError);
		return false;
	} else {
		$returnJs = json_decode($return, true);
		if (json_last_error() === JSON_ERROR_NONE) {
			if (isset($returnJs['error'])) {
				SbSetUserError($url.' !-! '.$returnJs['error'] . ' !-! ' . $returnJs['error_description']);
				return false;
			} else if (isset($returnJs['errorCode'])) {
				SbSetUserError($url.' !-! '.$returnJs['errorCode'] . ' !-! ' . $returnJs['errorMsg']);
				return false;
			}
			return $returnJs;
		} else {
			return $return;
		}
	}
}

function SbGetCreditOffers($form) {
	$user = SbGetUser();
	$config = SbGetConfig();
	$return = SbCurlCall(
		$config['UF_OFFERS_URL'],
		false,
		[
			'clientID' => $config['UF_CLIENT_ID_CONF'],
			'lawForm' => $form,
		],
		['Authorization: Bearer '.$user['UF_ACCESS_TOKEN']]
	);

	return $return;
}

function SbGetSiteCreditOffers() {
	$user = SbGetUser(0);
	$config = SbGetConfig();
	$return = SbCurlCall(
		$config['UF_OFFERS_URL'],
		false,
		[
			'clientID' => $config['UF_CLIENT_ID_CONF'],
			'lawForm' => $user['orgLawFormShort'],
		],
		['Authorization: Bearer '.$user['UF_ACCESS_TOKEN']]
	);

	return $return;
}

function SbGetBackLink() {
	$user = SbGetUser();
	return $user['UF_RETURN_PAGE'] ? $user['UF_RETURN_PAGE'] : '/';
}

function SbNeedUpdateSecret() {
	$config = SbGetConfig();
	$d = explode('.', (string) $config['UF_CLIENT_SECRET_UPDATE']);
	return date_diff(new DateTime(), new DateTime($d[2].'-'.$d[1].'-'.$d[0].' 00:00:01'))->days > 35;
}

function SbUpdateSecret($first = true) {
	$user = SbGetUser(0);
	$config = SbGetConfig();
	
// 	echo '<pre>';
// 	var_dump('$user', $user);
// 	var_dump('$config', $config);

	if ($user['UF_ACCESS_TOKEN'] && $user['UF_REFRESH_TOKEN']) {
		$newSecret = md5(uniqid());

		$return = SbCurlCall(
			$config['UF_CHANGE_CLIENT_SECRET_URL'],
			true,
			[
				'access_token' => $user['UF_ACCESS_TOKEN'],
				'client_id' => $config['UF_CLIENT_ID_CONF'],
				'client_secret' => $config['UF_CLIENT_SECRET_CONF'],
				'new_client_secret' => $newSecret
			],
			['Authorization: Bearer '.$user['UF_ACCESS_TOKEN']]
		);
	//var_dump('$return', $return);

		if ($return && isset($return['clientSecretExpiration'])) {
			$table = SbGetHlTable();
			$table['SbConfig']::update($config['ID'], [
				'client_secret' => $newSecret,
				'UF_CLIENT_SECRET_UPDATE' => date('Y.m.d')
			]);
	        //var_dump('$newSecret', $newSecret);
		}

	       // var_dump('$first', $first);
		if ($first) {
	       // var_dump('+++');
			SbGetAccessTokenByRefresh(0);
			return SbUpdateSecret(false);
		}
	}
	return false;
}

function SbSetCompanyAccess() {
	$user = SbGetUser();
	$data = [];
	$data['UF_ACCESS_TOKEN'] = $user['UF_ACCESS_TOKEN'];
	$data['UF_REFRESH_TOKEN'] = $user['UF_REFRESH_TOKEN'];
	SbSetUser($data, 0);
}

function SbCreateInvoice($post, $orderId, $min, $max) {
	$user = SbGetUser();
	$userInfo = SbGetUserInfo();
	$config = SbGetConfig();
	$table = SbGetHlTable();

	$data = [];
	$r = ['link' => ''];

	$type = isset($post['contractNumber']);

	$orderFromDb = $table['SbOrders']::getList(array(
		"select" => array("*"),
		'filter' => ['UF_ORDER' => $orderId],
		'limit' => 1
	))->fetchAll();
	if (isset($orderFromDb[0])) {
		$r['link'] = $config[
			$type
			? ($userInfo['userCryptoType'] == 'SMS' ? 'UF_INVOICE_LINK' : 'UF_INVOICE_APP_LINK')
			: ($userInfo['userCryptoType'] == 'SMS' ? 'UF_CREDIT_LINK' : 'UF_CREDIT_APP_LINK')
		];

		$r['link'] = str_replace('{ID}', $orderFromDb[0]['UF_EXT'], $r['link']);
		$r['link'] = str_replace('{BACK}', urlencode($uri.'orders/detail/'.$orderFromDb[0]['UF_ORDER'].'/?good'), $r['link']);
		return $r;
	}

	$extId = md5($orderId.uniqid());
	$extId = substr($extId, 0, 8) . '-' . substr($extId, 8, 4) . '-' . substr($extId, 12, 4) . '-' . substr($extId, 16, 4) . '-' . substr($extId, 20, 12);

	$table = SbGetHlTable();
	$payAcc = $table['SbPayto']::getList(array(
		"select" => array("*"),
		'limit' => 1
	))->fetchAll();

	$payAcc = $payAcc[0];

	$order = \Bitrix\Sale\Order::load($orderId);
	if ($order) {
		$basket = $order->getBasket();

		$uri = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . '://'.$_SERVER[HTTP_HOST].'/';
		$purpose = 'Оплата заказа №' . $orderId . ' от ' . $order->getDateInsert()->format("d.m.Y").'. ';
		if ($basket->getVatSum()) {
			$purpose .= 'В том числе НДС - '.$basket->getVatSum().' руб.';
		} else {
			$purpose .= 'НДС не облагается.';
		}
		$price = $order->getPrice();
		if ($max < $price) {
			return ['error' => 'Превышена максимальная сумма, пожалуйста измените Ваш заказ'];
		}
		if (isset($post['paymentAmount']) && $price != $post['paymentAmount']) {
			return ['error' => 'Оплата частями невозможна'];			
		}
		if ($type) {
			$data['amount'] = $price;
			$data['creditContractNumber'] = $post['contractNumber'];
			$data['date'] = date('Y-m-d');
			$data['externalId'] = $extId;
			$data['isPaidByCredit'] = 1;
			$data['payeeAccount'] = $payAcc['UF_ACCOUNT'];
			$data['payeeBankBic'] = $payAcc['UF_BIC'];
			$data['payeeBankCorrAccount'] = $payAcc['UF_CORRACCOUNT'];
			$data['payeeInn'] = $payAcc['UF_INN'];
			$data['payeeKpp'] = $payAcc['UF_KPP'];
			$data['payeeName'] = $payAcc['UF_NAME'];
			$data['orderNumber'] = $orderId;
			$data['purpose'] = $purpose;
			$data['vat'] = ['type' => 'NO_VAT'];
		} else {
			if ($max < $price) {
				return ['error' => 'Превышена максимальная сумма, пожалуйста измените Ваш заказ'];
			} elseif($min > $price) {
				$data['amount'] = $price;
				$data['creditAmount'] = $min;
			} else {
				$data['amount'] = $price;
				$data['creditAmount'] = $price;
			}
			$data['account'] = $payAcc['UF_ACCOUNT'];
			$data['negativeOrderUrl'] = $uri.'orders/detail/'.$orderId.'/?bad';
			$data['orderUrl'] = $uri.'orders/detail/'.$orderId.'/';
			$data['creditProductCode'] = $post['productCode'];
			$data['creditTerm'] = $post['creditTerm'];
			$data['externalId'] = $extId;
			$data['orderId'] = $orderId;
			$data['payeeInfo'] = [
			    'payeeBankBic' => $payAcc['UF_BIC'],
			    'payeeCorrAcc' => $payAcc['UF_CORRACCOUNT'],
			    'payeeInn' => $payAcc['UF_INN'],
			    'payeeKpp' => $payAcc['UF_KPP'],
			    'payeeName' => $payAcc['UF_NAME'],
			];
			$data['purpose'] = $purpose;
			$data['vat'] = ['type' => 'NO_VAT'];
		}
		$return = SbCurlCall(
			$type ? $config['UF_INVOICE_URL'] : $config['UF_CREDIT_URL'],
			true,
			json_encode($data),
			['Authorization: Bearer '.$user['UF_ACCESS_TOKEN'], 'Content-Type: application/json'],
			false,
			true
		);

		if (is_array($return) && isset($return['bankStatus']) && ($return['bankStatus'] == 'CREATED' || $return['bankStatus'] == 'RECEIVED')) {
			$table['SbOrders']::add([
				'UF_OPERATION' => $return['operationCode'],
				'UF_AMOUNT' => $return['amount'],
				'UF_EXT' => $extId,
				'UF_ORDER' => $orderId,
				'UF_CREATED' => time(),
				'UF_USER' => $user['ID'],
				'UF_STATUS' => 'CREATED'
			]);

			$r['link'] = $config[
				$type
				? ($userInfo['userCryptoType'] == 'SMS' ? 'UF_INVOICE_LINK' : 'UF_INVOICE_APP_LINK')
				: ($userInfo['userCryptoType'] == 'SMS' ? 'UF_CREDIT_LINK' : 'UF_CREDIT_APP_LINK')
			];

			$r['link'] = str_replace('{ID}', $extId, $r['link']);
			$r['link'] = str_replace('{BACK}', urlencode($uri.'orders/detail/'.$orderId.'/?good'), $r['link']);
		} else {
			return ['error' => 'Произошла ошибка, свяжитесь с администрацией, указав номер заказа'];
		}
	}
	return $r;
}

function SbCheckStatus(){
	$table = SbGetHlTable();
	$config = SbGetConfig();
	$orders = $table['SbOrders']::getList(array(
		"select" => array("*"),
		'filter' => ['UF_STATUS' => 'CREATED']
	))->fetchAll();
	Loader::includeModule("sale");
	foreach($orders as $order) {
		$setStatus = null;
		if ($config['UF_MAX_DAY_CHECK_STATUS'] * 86400 < time() - $order['UF_CREATED']) {
			$setStatus = false;
			$return = ['bankStatus' => 'TIME_END'];
		}

		if ($setStatus === null) {
			$user = $table['SbUser']::getList(array(
				"select" => array("*"),
				'filter' => ['ID' => $order['UF_USER']],
			))->fetchAll();
			if (isset($user[0])) {
				$return = SbCurlCall(
					str_replace('{ID}', $order['UF_EXT'], $config['UF_CHECKSTATUS_URL']),
					false,
					[],
					['Authorization: Bearer '.$user[0]['UF_ACCESS_TOKEN']]
				);
				if (isset($return['bankStatus'])) {
					if (in_array($return['bankStatus'], explode(',', $config['UF_GOOD_STATUS']))) {
						$setStatus = true;
					} else if (in_array($return['bankStatus'], explode(',', $config['UF_BAD_STATUS']))) {
						$setStatus = false;
					}
				}
			}
		}


		if ($setStatus === true || $setStatus === false) {
			$BXorder = Order::load($order['UF_ORDER']);
			$paymentCollection = $BXorder->getPaymentCollection();
			$onePayment = $paymentCollection[0];
			$onePayment->setPaid($setStatus === true ? 'Y' : 'N');
			$BXorder->setField("STATUS_ID", $config[$setStatus === true ? 'UF_ORDER_GOOD_STATUS' : 'UF_ORDER_BAD_STATUS']);
			$BXorder->save();
			$table['SbOrders']::update($order['ID'], ['UF_STATUS' => $return['bankStatus']]);
		}
	}
}

