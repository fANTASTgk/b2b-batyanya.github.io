<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");

if(!Loader::includeModule('sotbit.b2bcabinet'))
{
    header('Location: '.SITE_DIR);
}

$APPLICATION->SetTitle(Loc::getMessage('PAYMENT'));
?><h2>Способ оплаты любого заказа Вы выбираете при его оформлении.</h2>
<p>
	 Оплата в Интернет-магазине производится только в рублях. После подтверждения заказа оператором Интернет-магазина способ оплаты изменен быть не может.
</p>
<p>
 <span style="font-weight: 600;">Возможные способы оплаты:</span>
</p>
<p>
</p>
<ul>
	<li>
	<p>
		 Наличный расчет
	</p>
 </li>
	<li>
	<p>
		 Банковская карта
	</p>
 </li>
	<li>
	<p>
		 СберБанк Онлайн
	</p>
 </li>
	<li>
	<p>
		 Банковский перевод
	</p>
 </li>
</ul>
<p>
</p>
<p>
</p>
<h3>
<p>
	 Наличный расчет
</p>
 </h3>
<p>
	 Самый распространенный и удобный способ оплаты покупок. Вы отдаете сотруднику Службы доставки деньги при получении заказа.
</p>
<h3>Банковская карта</h3>
<p>
	 Мы принимаем онлайн-платежи по следующим платежным системам:
</p>
<p>
</p>
<ul>
	<li>
	<p>
		 Visa
	</p>
 </li>
	<li>
	<p>
		 MasterCard
	</p>
 </li>
	<li>
	<p>
		 МИР
	</p>
 </li>
</ul>
<p>
</p>
<p>
	 К оплате не принимаются банковские карты Visa, MasterCard и МИР без кода CVV2 / CVC2.
</p>
<p>
	 Оплата заказа производится через интернет непосредственно после его оформления.
</p>
<p>
	 Минимальная сумма платежа составляет<span style="font-weight: 600;">&nbsp;1000 рублей.</span>
</p>
<p>
	 В случае, если Вы оплатили заказ банковской картой и затем отказались от него, возврат переведенных средств производится на Ваш банковский (карточный) счет.
</p>
<h3>Сбербанк Онлайн</h3>
<p>
	 Для оплаты понадобится приложение СберБанка. Введите номер телефона, который к нему привязан, вам придёт пуш-уведомление или смс.
</p>
<h3>Банковский перевод</h3>
<p>
	 При выборе данного способа оплаты вместе с заказом выдаются счет, счет-фактура и накладная.
</p>
<p>
	 При получении заказа необходимо иметь при себе доверенность от организации-заказчика и удостоверение личности.&nbsp;
</p>
<p>
</p>
 <br>
<div class="card p-3">
	<div>
	</div>
</div>
 <br><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>