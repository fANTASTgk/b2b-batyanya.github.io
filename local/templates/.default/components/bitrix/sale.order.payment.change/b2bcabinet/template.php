<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;
global $APPLICATION;
$APPLICATION->ShowAjaxHead();
Asset::getInstance()->addJs( $this->getFolder() . "/script.js");
Asset::getInstance()->addCss( $this->getFolder() . "/style.css");

if (!empty($arResult["errorMessage"]))
{
	if (!is_array($arResult["errorMessage"]))
	{
		ShowError($arResult["errorMessage"]);
	}
	else
	{
		foreach ($arResult["errorMessage"] as $errorMessage)
		{
			ShowError($errorMessage);
		}
	}
}
else
{
	$wrapperId = rand(0, 10000);
	?>
	<div class="bx-sopc" id="bx-sopc<?=$wrapperId?>">
		<div class="container-fluid">
			<div>
				<div class="sale-order-payment-change-pp">
					<div class="sale-order-payment-change-inner-row">
						<div class="sale-order-payment-change-inner-row-body">
							<div class="col-xs-12 sale-order-payment-change-payment">
								<div class="sale-order-payment-change-payment-price">
									<span class="sale-order-payment-change-payment-element"><?=Loc::getMessage('SOPC_TPL_SUM_TO_PAID')?>:</span>

									<span class="sale-order-payment-change-payment-number"><?=SaleFormatCurrency($arResult['PAYMENT']["SUM"], $arResult['PAYMENT']["CURRENCY"])?></span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12 sale-order-payment-change-pp-list">
						<?
						foreach ($arResult['PAYSYSTEMS_LIST'] as $key => $paySystem)
						{
							?>
							<div class="sale-order-payment-change-pp-company">
								<div class="sale-order-payment-change-pp-company-graf-container">
									<input type="hidden"
										class="sale-order-payment-change-pp-company-hidden"
										name="PAY_SYSTEM_ID"
										value="<?=$paySystem['ID']?>"
										<?= ($key == 0) ? "checked='checked'" :""?>
									>
									<?
									if (empty($paySystem['LOGOTIP']))
										$paySystem['LOGOTIP'] = '/bitrix/images/sale/nopaysystem.gif';

									?>
									<div class="sale-order-payment-change-pp-company-image"
										style="
											background-image: url(<?=htmlspecialcharsbx($paySystem['LOGOTIP'])?>);
											background-image: -webkit-image-set(url(<?=htmlspecialcharsbx($paySystem['LOGOTIP'])?>) 1x, url(<?=htmlspecialcharsbx($paySystem['LOGOTIP'])?>) 2x);
											">
									</div>
								</div>
                                <div class="sale-order-payment-change-pp-company-smalltitle">
                                    <?=CUtil::JSEscape(htmlspecialcharsbx($paySystem['NAME']))?>
                                </div>
							</div>
							<?
						}
						?>
					</div>
                    <button class="btn btn-light" onclick=" window.location.reload();"><?=Loc::getMessage("SOPC_TPL_BACK")?></button>
				</div>
			</div>
		</div>
	</div>
	<?
	$javascriptParams = array(
		"url" => CUtil::JSEscape($this->__component->GetPath().'/ajax.php'),
		"templateFolder" => CUtil::JSEscape($templateFolder),
		"accountNumber" => $arParams['ACCOUNT_NUMBER'],
		"paymentNumber" => $arParams['PAYMENT_NUMBER'],
		"inner" => $arParams['ALLOW_INNER'],
		"onlyInnerFull" => $arParams['ONLY_INNER_FULL'],
		"refreshPrices" => $arParams['REFRESH_PRICES'],
		"pathToPayment" => $arParams['PATH_TO_PAYMENT'],
		"wrapperId" => $wrapperId
	);
	$javascriptParams = CUtil::PhpToJSObject($javascriptParams);
	?>
	<script>
		var sc = new BX.Sale.OrderPaymentChange(<?=$javascriptParams?>);
	</script>
	<?
}

