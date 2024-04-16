<?php
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("");

if (!Loader::includeModule('sotbit.b2bcabinet')) {
    header('Location: ' . SITE_DIR);
}

$APPLICATION->SetTitle(Loc::getMessage('CONTACTS'));
?>

<input class="custompoisk" type="text" id="cityfilter" placeholder="Фильтр по городам">

<div class="city card p-3 b2b-about_contacts">
	<h4 style="font-weight: bold; color: #383838;">Центральный офис</h4>
	<div class="table-responsive">
		<table height="228" cellspacing="0" cellpadding="0">
		<tbody>
		<tr>
			<td width="170" valign="top">
 <span style="font-size: 13px;">&nbsp;Адрес: </span>
			</td>
			<td valign="top">
				 г. Пятигорск, Черкесское шоссе, 23<br>
			</td>
		</tr>
		<tr>
			<td width="170" valign="top">
 <span style="font-size: 13px;">Телефоны: </span>
			</td>
			<td valign="top">
				 88007755989<br>
				 +7(962)028-40-44<br>
			</td>	
		</tr>
		<tr>
			<td colspan="1" width="170" valign="top">
 <span style="font-size: 13px;">Эл. почта: </span>
			</td>
			<td colspan="1" valign="top">
 <a href="mailto:marketing@batyanya.ru">marketing@batyanya.ru</a><br>
			</td>
		</tr>
		</tbody>
		</table>
	</div></div>

	<div class="city card p-3 b2b-about_contacts">
		<h4 style="font-weight: bold; color: #383838;">Владикавказ</h4>
		<div class="table-responsive">
			<table height="228" cellspacing="0" cellpadding="0">
			<tbody>
			<tr>
				<td width="170" valign="top">
 <span style="font-size: 13px;">&nbsp;Адрес: </span>
				</td>
				<td valign="top">
					 г. Владикавказ магазин строительных материалов Батяня, пер. Холодный, 2а<br>
				</td>
			</tr>
			<tr>
				<td width="170" valign="top">
 <span style="font-size: 13px;">Телефоны: </span>
				</td>
				<td valign="top">
					 88007755989<br>
					 +7(962)028-40-44<br>
				</td>
			</tr>
			<tr>
				<td colspan="1" width="170" valign="top">
 <span style="font-size: 13px;">Эл. почта: </span>
				</td>
				<td colspan="1" valign="top">
 <a href="mailto:marketing@batyanya.ru">marketing@batyanya.ru</a><br>
				</td>
			</tr>
			<tr>
				<td colspan="1" width="170" valign="top">
 <span style="font-size: 13px;">Режим работы: </span>
				</td>
				<td colspan="1" valign="top">
 <span style="font-size: 13px;">Понедельник–пятница, с 9:00 до 17:00</span><br>
 <span style="font-size: 13px;">
					Суббота, с 9:00 до 15:00</span><br>
 <span style="font-size: 13px;">
					Воскресенье — выходной </span>
				</td>
			</tr>
			</tbody>
			</table>
		</div></div>

<div class="city card p-3 b2b-about_contacts">
		<h4 style="font-weight: bold; color: #383838;">Ереван</h4>
		<div class="table-responsive">
			<table style="margin-bottom:25px;" height="228" cellspacing="0" cellpadding="4">
			<tbody>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">
					Адрес: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">
					г. Ереван магазин строительных материалов Батяня, ул.Аршакуняц, 55/1 </span>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Телефоны: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
					 +37433049400<br>
					 +37433059500<br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Эл. почта: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <a href="mailto:stoprocentov.am@gmail.com">stoprocentov.am@gmail.com</a><br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Режим работы: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">Понедельник–пятница, с 10:00 до 18:00</span><br>
 <span style="font-size: 13px;">
					Суббота, с 10:00 до 16:00</span><br>
 <span style="font-size: 13px;">
					Воскресенье — выходной </span>
				</td>
			</tr>
			</tbody>
			</table>
		</div></div>

<div class="city card p-3 b2b-about_contacts">
		<h4 style="font-weight: bold; color: #383838;">Ессентуки</h4>
		<div class="table-responsive">
			<table style="margin-bottom:25px;" height="228" cellspacing="0" cellpadding="4">
			<tbody>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">
					Адрес: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">
					г. Ессентуки магазин строительных материалов Батяня, Пятигорская, 129 </span>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Телефоны: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
					 88007755989<br>
					 +7(928)816-09-26<br>
					 +7(909)751-51-28<br>
					 +7(928)816-09-25<br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Эл. почта: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <a href="mailto:marketing@batyanya.ru">marketing@batyanya.ru</a><br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Режим работы: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">Понедельник–пятница, с 8:00 до 18:00</span><br>
 <span style="font-size: 13px;">
					Суббота, с 9:00 до 15:00</span><br>
 <span style="font-size: 13px;">
					Воскресенье, с 9:00 до 15:00</span>
				</td>
			</tr>
			</tbody>
			</table>
		</div></div>

<div class="city card p-3 b2b-about_contacts">
		<h4 style="font-weight: bold; color: #383838;">Изобильный</h4>
		<div class="table-responsive">
			<table style="margin-bottom:25px;" height="228" cellspacing="0" cellpadding="4">
			<tbody>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">
					Адрес: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">
					г. Изобильный магазин строительных материалов Батяня, ул. Промышленная, 26б</span>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Телефоны: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
					 88007755989<br>
					 +7(988)104-62-26<br>
					 +7(961)466-90-59<br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Эл. почта: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <a href="mailto:marketing@batyanya.ru">marketing@batyanya.ru</a><br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Режим работы: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">Пн.-Пт. с 8.00 до 18.00</span><br>
 <span style="font-size: 13px;">
					Сб.-Вс. с 9.00 до 15.00</span>
				</td>
			</tr>
			</tbody>
			</table>
		</div></div>


<div class="city card p-3 b2b-about_contacts">
		<h4 style="font-weight: bold; color: #383838;">Кисловодск</h4>
		<div class="table-responsive">
			<table style="margin-bottom:25px;" height="228" cellspacing="0" cellpadding="4">
			<tbody>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">
					Адрес: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">
					г. Кисловодск магазин строительных материалов Батяня, ул. Промышленная, 13</span>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Телефоны: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
					 88007755989<br>
					 +7(928)816-09-08<br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Эл. почта: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <a href="mailto:marketing@batyanya.ru">marketing@batyanya.ru</a><br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Режим работы: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">Пн.-Пт. 9.00-17.00</span><br>
 <span style="font-size: 13px;">Сб. 9.00-15.00</span><br>
 <span style="font-size: 13px;">Вс. выходной</span>
				</td>
			</tr>
			</tbody>
			</table>
		</div></div>

<div class="city card p-3 b2b-about_contacts">
		<h4 style="font-weight: bold; color: #383838;">Краснодар</h4>
		<div class="table-responsive">
			<table style="margin-bottom:25px;" height="228" cellspacing="0" cellpadding="4">
			<tbody>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">
					Адрес: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">
					г. Краснодар строительный магазин Батяня, ул. Григория Булгакова, 10</span>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Телефоны: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
					 88007755989<br>
					 +7(961)481-36-22<br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Эл. почта: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <a href="mailto:marketing@batyanya.ru">marketing@batyanya.ru</a><br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Режим работы: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">Пн.-Пт. с 9.00 до 18.00</span><br>
 <span style="font-size: 13px;">Сб.,Вс. выходной</span><br>
				</td>
			</tr>
			</tbody>
			</table>
		</div>

		<div class="table-responsive">
			<table style="margin-bottom:25px;" height="228" cellspacing="0" cellpadding="4">
			<tbody>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">
					Адрес: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">
					г. Краснодар магазин строительных материалов Батяня, ул. Круговая, 28</span>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Телефоны: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
					 88007755989<br>
					 +7(905)417-96-33<br>
					 +7(905)416-54-66<br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Эл. почта: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <a href="mailto:marketing@batyanya.ru">marketing@batyanya.ru</a><br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Режим работы: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">Пн.-Пт. с 9.00 до 17.00</span><br>
 <span style="font-size: 13px;">Сб.,Вс. выходной</span><br>
				</td>
			</tr>
			</tbody>
			</table>
		</div></div>

<div class="city card p-3 b2b-about_contacts">
		<h4 style="font-weight: bold; color: #383838;">Минеральные воды</h4>
		<div class="table-responsive">
			<table style="margin-bottom:25px;" height="228" cellspacing="0" cellpadding="4">
			<tbody>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">
					Адрес: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">
					г. Минеральные Воды магазин строительных материалов Батяня, ул. 50 лет Октября, 67 а/1</span>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Телефоны: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
					 88007755989<br>
					 +7(928)816-09-01<br>
					 +7(906)471-44-38<br>
					 +7(906)471-44-31<br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Эл. почта: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <a href="mailto:marketing@batyanya.ru">marketing@batyanya.ru</a><br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Режим работы: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">Пн.-Пт. с 8.30 до 18.00</span><br>
 <span style="font-size: 13px;">Сб.,Вс. с 9.00 до 15.00</span><br>
				</td>
			</tr>
			</tbody>
			</table>
		</div></div>


<div class="city card p-3 b2b-about_contacts">
		<h4 style="font-weight: bold; color: #383838;">Невинномысск</h4>
		<div class="table-responsive">
			<table style="margin-bottom:25px;" height="228" cellspacing="0" cellpadding="4">
			<tbody>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">
					Адрес: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">
					г. Невинномысск магазин строительных материалов Батяня, ул. Краснопартизанская, д. 1</span>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Телефоны: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
					 88007755989<br>
					 +7(928)816-08-84<br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Эл. почта: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <a href="mailto:marketing@batyanya.ru">marketing@batyanya.ru</a><br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Режим работы: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">Пн.-Пт. с 9.00 до 17.00</span><br>
 <span style="font-size: 13px;">Сб. с 9.00 до 15.00</span><br>
 <span style="font-size: 13px;">Вс. выходной</span><br>
				</td>
			</tr>
			</tbody>
			</table>
		</div></div>


<div class="city card p-3 b2b-about_contacts">
		<h4 style="font-weight: bold; color: #383838;">Пятигорск</h4>
		<div class="table-responsive">
			<table style="margin-bottom:25px;" height="228" cellspacing="0" cellpadding="4">
			<tbody>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">
					Адрес: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">
					г. Пятигорск магазин строительных материалов Батяня , Кисловодское шоссе, 11</span>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Телефоны: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
					 88007755989<br>
					 +7(928)285-00-82<br>
					 +7(928)285-00-62<br>
					 +7(963)380-88-52<br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Эл. почта: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <a href="mailto:marketing@batyanya.ru">marketing@batyanya.ru</a><br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Режим работы: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">Пн.-Пт. с 9.00 до 17.00</span><br>
 <span style="font-size: 13px;">Сб. с 9.00 до 16.00</span><br>
 <span style="font-size: 13px;">Вс. выходной</span><br>
				</td>
			</tr>
			</tbody>
			</table>
		</div>
		<div class="table-responsive">
			<table style="margin-bottom:25px;" height="228" cellspacing="0" cellpadding="4">
			<tbody>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">
					Адрес: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">
					с.Вин-Сады магазин строительных материалов Батяня, ул. Асфальтная, 4</span>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Телефоны: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
					 88007755989<br>
					 +7(961)458-80-30<br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Эл. почта: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <a href="mailto:marketing@batyanya.ru">marketing@batyanya.ru</a><br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Режим работы: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">Пн.-Пт. с 9.00 до 17.00</span><br>
 <span style="font-size: 13px;">Сб. с 9.00 до 14.00</span><br>
 <span style="font-size: 13px;">Вс. выходной</span><br>
				</td>
			</tr>
			</tbody>
			</table>
		</div>
		<div class="table-responsive">
			<table style="margin-bottom:25px;" height="228" cellspacing="0" cellpadding="4">
			<tbody>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">
					Адрес: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">
					г. Пятигорск строительный магазин Батяня, ул.Беговая, 29, Промзона-2</span>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Телефоны: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
					 88007755989<br>
					 +7(928)357-09-12<br>
					 +7(918)802-19-90<br>
					 +7(905)418-21-77<br>
					 +7(961)482-29-08<br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Эл. почта: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <a href="mailto:marketing@batyanya.ru">marketing@batyanya.ru</a><br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Режим работы: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">Пн.-Пт. с 8.30 до 17.00</span><br>
 <span style="font-size: 13px;">Сб. с 9.00 до 15.00</span><br>
 <span style="font-size: 13px;">Вс. выходной</span><br>
				</td>
			</tr>
			</tbody>
			</table>
		</div></div>

<div class="city card p-3 b2b-about_contacts">
		<h4 style="font-weight: bold; color: #383838;">Ставрополь</h4>
		<div class="table-responsive">
			<table style="margin-bottom:25px;" height="228" cellspacing="0" cellpadding="4">
			<tbody>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">
					Адрес: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">
					г. Ставрополь магазин строительных магазинов Батяня, пр. Кулакова, 50 а</span>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Телефоны: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
					 88007755989<br>
					 +7(961)443-89-59<br>
					 +7(961)443-89-73<br>
					 +7(961)468-12-28<br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Эл. почта: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <a href="mailto:marketing@batyanya.ru">marketing@batyanya.ru</a><br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Режим работы: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">Пн.-Пт. 8:30-17.00</span><br>
 <span style="font-size: 13px;">Сб., Вс. Выходной</span><br>
				</td>
			</tr>
			</tbody>
			</table>
		</div>
		<div class="table-responsive">
			<table style="margin-bottom:25px;" height="228" cellspacing="0" cellpadding="4">
			<tbody>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">
					Адрес: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">
					г. Ставрополь магазин Батяня Механизация , ул. Селекционная 4</span>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Телефоны: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
					 +7(909)750-84-96<br>
					 +7(909)750-87-96<br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Эл. почта: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <a href="mailto:marketing@batyanya.ru">marketing@batyanya.ru</a><br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Режим работы: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">Пн.-Пт. 8:30-17.00</span><br>
 <span style="font-size: 13px;">Сб., Вс. Выходной</span><br>
				</td>
			</tr>
			</tbody>
			</table>
		</div>
		<div class="table-responsive">
			<table style="margin-bottom:25px;" height="228" cellspacing="0" cellpadding="4">
			<tbody>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">
					Адрес: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">
					г. Ставрополь строительный магазин Батяня, ул.Пирогова, 25</span>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Телефоны: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
					 88007755989<br>
					 +7(909)772-13-34<br>
					 +7(909)772-13-37<br>
					 +7(961)440-02-71<br>
					 +7(963)468-12-28<br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Эл. почта: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <a href="mailto:marketing@batyanya.ru">marketing@batyanya.ru</a><br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Режим работы: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">Пн.-Пт. 8.30-18.00</span><br>
 <span style="font-size: 13px;">Сб., Вс. 9.00-15.00</span><br>
				</td>
			</tr>
			</tbody>
			</table>
		</div>
		<div class="table-responsive">
			<table style="margin-bottom:25px;" height="228" cellspacing="0" cellpadding="4">
			<tbody>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">
					Адрес: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">
					г. Ставрополь магазин строительных материалов Батяня, ул. Селекционная, 4</span>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Телефоны: </span>
				</td>
				<td style="padding-bottom:7px;" valign="top">
					 88007755989<br>
					 +7(961)466-90-19<br>
					 +7(918)862-30-86<br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Эл. почта: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <a href="mailto:marketing@batyanya.ru">marketing@batyanya.ru</a><br>
				</td>
			</tr>
			<tr>
				<td colspan="1" style="padding-bottom:7px;" width="170" valign="top">
 <span style="font-size: 13px;">Режим работы: </span>
				</td>
				<td colspan="1" style="padding-bottom:7px;" valign="top">
 <span style="font-size: 13px;">Пн.-Пт. с 8.30 до 17.00</span><br>
 <span style="font-size: 13px;">Сб. с 9.00 до 15.00</span><br>
 <span style="font-size: 13px;">Вс. выходной</span><br>
				</td>
			</tr>
			</tbody>
			</table>
		</div>
 <br>
 <br>
	</div>
	<style>
    .b2b-about_contacts .bx-yandex-view-layout {
        max-width: 100% !important;
    }


    .custompoisk{
    width: 258px;
    margin-bottom: 25px;
	}

</style>
</div>
<br><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
