<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $USER;
if ($USER->IsAuthorized()) {
include_once 'func.php';

$sbuser = SbGetUserInfo();
if (is_array($sbuser) && isset($sbuser['buyOnCreditMmb']) && $sbuser['buyOnCreditMmb'] == false) {
?>
<div class="b-popup">
	<div class="b-popup-shadow"></div>
	<div class="b-popup-content">
		Покупки в рассрочку не доступна для текущего аккаунта СберБизнес ID.<br>
		<button class="btn btn-primary">Принимаю</button>
	</div>
</div>
<style>
	.b-popup { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: 100000; display:none; justify-content: center; align-items: center; }
	.b-popup-shadow { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: 100000; background: rgba(0, 0, 0, .4) }
	.b-popup-content { background: #fff; padding: 25px; width: 300px; text-align: center; z-index: 100001; position: relative; }
	.b-popup-content .btn { display: block; margin: 15px auto 0; }
</style>
<?php
}
?>
<script>
	const sbUserB2b = <?= json_encode($sbuser)?>;
</script>
<script src="/sb/js/button.js"></script>
<link href="/sb/css/button.css" rel="stylesheet">
<?php if (preg_match('#^/orders/make/make.php$#', $_SERVER['REQUEST_URI'])){ ?>
<script>
	const sbUserOffersB2b = <?= json_encode(isset($sbuser['orgLawFormShort']) ? SbGetCreditOffers($user['orgLawFormShort']) : false)?>;
</script>
<script src="/sb/js/creditInBasket-sdk.js"></script>
<script src="/sb/js/make.js"></script>
<?php } ?>
<?php if (isset($_GET['ORDER_ID']) || preg_match('#^/orders/detail/(\d+)/#', $_SERVER['REQUEST_URI'], $m)) { ?>
<script>
	const sbUserOffersB2b = <?= json_encode(isset($sbuser['orgLawFormShort']) ? SbGetCreditOffers($user['orgLawFormShort']) : false)?>;
	const sbOrderId = <?=(isset($_GET['ORDER_ID']) ? $_GET['ORDER_ID'] :$m[1])?>;
</script>
<script src="/sb/js/creditInBasket-sdk.js"></script>
<script src="/sb/js/make_order.js"></script>
<?php } ?>
<?php if ($sbuser && $USER->IsAdmin()) { ?>
<script src="/sb/js/adminbtn.js"></script>
<?php } ?>

<?php } ?>
