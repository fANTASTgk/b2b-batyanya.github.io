<?
define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_CHECK", true);
define('PUBLIC_AJAX_MODE', true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$_SESSION["SESS_SHOW_INCLUDE_TIME_EXEC"]="N";
$APPLICATION->ShowIncludeStat = false;

header('Content-Type: application/json; charset=utf-8');

$r = [];

global $USER;
if ($USER->IsAuthorized()) {
	include dirname(__FILE__).'/func.php';
	$action = isset($_POST['action']) ? $_POST['action'] : '';
	if ($action == 'authlink') {
		$r['link'] = SbGetAuthLink(isset($_POST['loc']) ? $_POST['loc'] : '/');
	} elseif ($action == 'offers') {
		$r = SbGetCreditOffers(isset($_POST['form']) ? $_POST['form'] : 0);
	} elseif ($action == 'orderprice') {
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$order = \Bitrix\Sale\Order::load($id);
		if ($order && $order->getUserId() == $USER->GetId()) {
			$r['price'] = $order->getPrice();
		}
	} elseif ($action == 'makeorder') {
		$data = isset($_POST['data']) ? $_POST['data'] : '';
		$data = json_decode($data, true);
		$r = SbCreateInvoice(
			$data,
			isset($_POST['id']) ? $_POST['id'] : 0,
			isset($_POST['min']) ? $_POST['min'] : 0,
			isset($_POST['max']) ? $_POST['max'] : 0
		);
	} elseif (isset($_GET['updatesecret'])) {
		if (SbNeedUpdateSecret()) {
			SbUpdateSecret();
		}
	} elseif (isset($_GET['checkstatus'])) {
		SbCheckStatus();
	} elseif ($action == 'setcompanyaccess') {
		SbSetCompanyAccess($action);
	}
}



echo json_encode($r);


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");