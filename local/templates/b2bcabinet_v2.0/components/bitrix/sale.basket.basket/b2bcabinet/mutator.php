<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Sale\PriceMaths;

/**
 *
 * This file modifies result for every request (including AJAX).
 * Use it to edit output result for "{{ mustache }}" templates.
 *
 * @var array $result
 */

$mobileColumns = isset($this->arParams['COLUMNS_LIST_MOBILE'])
	? $this->arParams['COLUMNS_LIST_MOBILE']
	: $this->arParams['COLUMNS_LIST'];
$mobileColumns = array_fill_keys($mobileColumns, true);

$result['BASKET_ITEM_RENDER_DATA'] = array();

$countProps = 0;
$countSku = 0;
$countColumsList = 0;
$countColums = 0;

foreach ($this->basketItems as $row) {
    if($row['DELAY'] === 'Y')
        continue;

    // count all colums PROPS
    if($countProps < count($row['PROPS']))
        $countProps = count($row['PROPS']);

    // count all colums SKU_DATA
    if(is_array($row['SKU_DATA']) && $countSku < count($row['SKU_DATA']))
        $countSku = count($row['SKU_DATA']);

    // count all colums COLUMN_LIST
    $countColumsList = [];
    $hideDetailPicture = false;
    if (empty($row['PREVIEW_PICTURE_SRC']) && !empty($row['DETAIL_PICTURE_SRC']))
    {
        $hideDetailPicture = true;
    }

    if (!empty($result['GRID']['HEADERS']) && is_array($result['GRID']['HEADERS']))
    {
        foreach ($result['GRID']['HEADERS'] as &$value)
        {
            if (
                $value['id'] === 'NAME' || $value['id'] === 'QUANTITY' || $value['id'] === 'PRICE'
                || $value['id'] === 'PREVIEW_PICTURE' || ($value['id'] === 'DETAIL_PICTURE' & $hideDetailPicture)
                || $value['id'] === 'SUM' || $value['id'] === 'PROPS' || $value['id'] === 'DELETE'
                || $value['id'] === 'DELAY'
            )
            {
                continue;
            }

            if ($value['id'] === 'DETAIL_PICTURE')
            {
                if (!empty($row['DETAIL_PICTURE_SRC']))
                {
                    $countColumsList[$value['id']] = Loc::getMessage('SBB_DETAIL_PICTURE_NAME');
                }
            }
            elseif ($value['id'] === 'PREVIEW_TEXT')
            {
                if ($row['PREVIEW_TEXT_TYPE'] === 'text' && !empty($row['PREVIEW_TEXT']))
                {
                    $countColumsList[$value['id']] = Loc::getMessage('SBB_PREVIEW_TEXT_NAME');
                }
            }
            elseif ($value['id'] === 'TYPE')
            {
               if (!empty($row['NOTES']))
                {
                    $countColumsList[$value['id']] = Loc::getMessage('SBB_PRICE_TYPE_NAME');
                }
            }
            elseif ($value['id'] === 'DISCOUNT')
            {
                if ($row['DISCOUNT_PRICE_PERCENT'] > 0 && !empty($row['DISCOUNT_PRICE_PERCENT_FORMATED']))
                {
                    $countColumsList[$value['id']] = Loc::getMessage('SBB_DISCOUNT_NAME');
                }
            }
            elseif ($value['id'] === 'WEIGHT')
            {
                if (!empty($row['WEIGHT_FORMATED']))
                {
                    $countColumsList[$value['id']] = Loc::getMessage('SBB_WEIGHT_NAME');
                }
            }
            elseif (!empty($row[$value['id'].'_SRC']))
            {
                $countColumsList[$value['id']] = $value['name'];
            }
            elseif (!empty($row[$value['id'].'_DISPLAY']))
            {
                $countColumsList[$value['id']] = $value['name'];
            }
            elseif (!empty($row[$value['id'].'_LINK']))
            {
                $countColumsList[$value['id']] = $value['name'];
            }
            elseif (!empty($row[$value['id']]))
            {
                $countColumsList[$value['id']] = $value['name'];
            }
        }
    }

    if ($countColums < count($countColumsList))
        $countColums = $countColumsList;
}



foreach ($this->basketItems as $key => $row)
{
	if (!is_array($row['SKU_DATA'])) {
		continue;
	}

	foreach ($row['SKU_DATA'] as $sky) {
		if ($sky['TYPE'] !== 'S') {
			continue;
		}
		foreach($row['PROPS'] as $propKey => $prop) {
			if ($sky['CODE'] !== $prop['CODE']) {
				continue;
			}

			$skuKey = array_search(
				$prop['VALUE'],
				array_combine(array_keys($sky['VALUES']), array_column($sky['VALUES'], 'XML_ID')),
			);
			$this->basketItems[$key]['PROPS'][$propKey]['VALUE'] = $sky['VALUES'][$skuKey]['NAME'];

		}
	}
}

foreach ($this->basketItems as $row)
{
	$rowData = array(
		'ID' => $row['ID'],
		'PRODUCT_ID' => $row['PRODUCT_ID'],
		'NAME' => TruncateText(isset($row['~NAME']) ? $row['~NAME'] : $row['NAME'], 45),
		'TITLE' => isset($row['~NAME']) ? $row['~NAME'] : $row['NAME'],
		'QUANTITY' => $row['QUANTITY'],
		'PROPS' => $row['PROPS'],
		'PROPS_ALL' => $row['PROPS_ALL'],
		'HASH' => $row['HASH'],
		'SORT' => $row['SORT'],
		'DETAIL_PAGE_URL' => $row['DETAIL_PAGE_URL'],
		'CURRENCY' => $row['CURRENCY'],
		'DISCOUNT_PRICE_PERCENT' => $row['DISCOUNT_PRICE_PERCENT'],
		'DISCOUNT_PRICE_PERCENT_FORMATED' => $row['DISCOUNT_PRICE_PERCENT_FORMATED'],
		'SHOW_DISCOUNT_PRICE' => (float)$row['DISCOUNT_PRICE'] > 0,
		'PRICE' => $row['PRICE'],
		'PRICE_FORMATED' => $row['PRICE_FORMATED'],
		'FULL_PRICE' => $row['FULL_PRICE'],
		'FULL_PRICE_FORMATED' => $row['FULL_PRICE_FORMATED'],
		'DISCOUNT_PRICE' => $row['DISCOUNT_PRICE'],
		'DISCOUNT_PRICE_FORMATED' => $row['DISCOUNT_PRICE_FORMATED'],
		'SUM_PRICE' => $row['SUM_VALUE'],
		'SUM_PRICE_FORMATED' => $row['SUM'],
		'SUM_FULL_PRICE' => $row['SUM_FULL_PRICE'],
		'SUM_FULL_PRICE_FORMATED' => $row['SUM_FULL_PRICE_FORMATED'],
		'SUM_DISCOUNT_PRICE' => $row['SUM_DISCOUNT_PRICE'],
		'SUM_DISCOUNT_PRICE_FORMATED' => $row['SUM_DISCOUNT_PRICE_FORMATED'],
		'MEASURE_RATIO' => isset($row['MEASURE_RATIO']) ? $row['MEASURE_RATIO'] : 1,
		'MEASURE_TEXT' => $row['MEASURE_TEXT'],
		'AVAILABLE_QUANTITY' => $row['AVAILABLE_QUANTITY'],
		'CHECK_MAX_QUANTITY' => $row['CHECK_MAX_QUANTITY'],
		'MODULE' => $row['MODULE'],
		'PRODUCT_PROVIDER_CLASS' => $row['PRODUCT_PROVIDER_CLASS'],
		'NOT_AVAILABLE' => $row['NOT_AVAILABLE'] === true,
		'DELAYED' => $row['DELAY'] === 'Y',
		'SKU_BLOCK_LIST' => array(),
		'COLUMN_LIST' => array(),
		'SHOW_LABEL' => false,
		'LABEL_VALUES' => array(),
		'BRAND' => isset($row[$this->arParams['BRAND_PROPERTY'].'_VALUE'])
			? $row[$this->arParams['BRAND_PROPERTY'].'_VALUE']
			: '',
	);

	// skip delayed products
	if($rowData['DELAYED']) {
	    continue;
    }

	// show price including ratio
	if ($rowData['MEASURE_RATIO'] != 1)
	{
		$price = PriceMaths::roundPrecision($rowData['PRICE'] * $rowData['MEASURE_RATIO']);
		if ($price != $rowData['PRICE'])
		{
			$rowData['PRICE'] = $price;
			$rowData['PRICE_FORMATED'] = CCurrencyLang::CurrencyFormat($price, $rowData['CURRENCY'], true);
		}

		$fullPrice = PriceMaths::roundPrecision($rowData['FULL_PRICE'] * $rowData['MEASURE_RATIO']);
		if ($fullPrice != $rowData['FULL_PRICE'])
		{
			$rowData['FULL_PRICE'] = $fullPrice;
			$rowData['FULL_PRICE_FORMATED'] = CCurrencyLang::CurrencyFormat($fullPrice, $rowData['CURRENCY'], true);
		}

		$discountPrice = PriceMaths::roundPrecision($rowData['DISCOUNT_PRICE'] * $rowData['MEASURE_RATIO']);
		if ($discountPrice != $rowData['DISCOUNT_PRICE'])
		{
			$rowData['DISCOUNT_PRICE'] = $discountPrice;
			$rowData['DISCOUNT_PRICE_FORMATED'] = CCurrencyLang::CurrencyFormat($discountPrice, $rowData['CURRENCY'], true);
		}
	}

	$rowData['SHOW_PRICE_FOR'] = (float)$rowData['QUANTITY'] !== (float)$rowData['MEASURE_RATIO'];

	$hideDetailPicture = false;

	if (!empty($row['PREVIEW_PICTURE_SRC']))
	{
		$rowData['IMAGE_URL'] = $row['PREVIEW_PICTURE_SRC'];
	}
	elseif (!empty($row['DETAIL_PICTURE_SRC']))
	{
		$hideDetailPicture = true;
		$rowData['IMAGE_URL'] = $row['DETAIL_PICTURE_SRC'];
	}

	if ($row['NOT_AVAILABLE'])
	{
		foreach ($rowData['SKU_BLOCK_LIST'] as $blockKey => $skuBlock)
		{
			if (!empty($skuBlock['SKU_VALUES_LIST']))
			{
				if ($notSelectable)
				{
					foreach ($skuBlock['SKU_VALUES_LIST'] as $valueKey => $skuValue)
					{
						$rowData['SKU_BLOCK_LIST'][$blockKey]['SKU_VALUES_LIST'][0]['NOT_AVAILABLE_OFFER'] = true;
					}
				}
				elseif (!isset($rowData['SKU_BLOCK_LIST'][$blockKey + 1]))
				{
					foreach ($skuBlock['SKU_VALUES_LIST'] as $valueKey => $skuValue)
					{
						if ($skuValue['SELECTED'])
						{
							$rowData['SKU_BLOCK_LIST'][$blockKey]['SKU_VALUES_LIST'][$valueKey]['NOT_AVAILABLE_OFFER'] = true;
						}
					}
				}
			}
		}
	}

	if (!empty($result['GRID']['HEADERS']) && is_array($result['GRID']['HEADERS']))
	{
		foreach ($result['GRID']['HEADERS'] as &$value)
		{
			if (
				$value['id'] === 'NAME' || $value['id'] === 'QUANTITY' || $value['id'] === 'PRICE'
				|| $value['id'] === 'PREVIEW_PICTURE' || ($value['id'] === 'DETAIL_PICTURE' & $hideDetailPicture)
				|| $value['id'] === 'SUM' || $value['id'] === 'PROPS' || $value['id'] === 'DELETE'
				|| $value['id'] === 'DELAY'
			)
			{
				continue;
			}

			if ($value['id'] === 'DETAIL_PICTURE')
			{
				$value['name'] = Loc::getMessage('SBB_DETAIL_PICTURE_NAME');

				if (!empty($row['DETAIL_PICTURE_SRC']))
				{
					$rowData['COLUMN_LIST'][] = array(
						'CODE' => $value['id'],
						'NAME' => $value['name'],
						'VALUE' => array(
							array(
								'IMAGE_SRC' => $row['DETAIL_PICTURE_SRC'],
								'IMAGE_SRC_2X' => $row['DETAIL_PICTURE_SRC_2X'],
								'IMAGE_SRC_ORIGINAL' => $row['DETAIL_PICTURE_SRC_ORIGINAL'],
								'INDEX' => 0
							)
						),
						'IS_IMAGE' => true,
						'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
					);
				}
			}
			elseif ($value['id'] === 'PREVIEW_TEXT')
			{
				$value['name'] = Loc::getMessage('SBB_PREVIEW_TEXT_NAME');

				if ($row['PREVIEW_TEXT_TYPE'] === 'text' && !empty($row['PREVIEW_TEXT']))
				{
					$rowData['COLUMN_LIST'][] = array(
						'CODE' => $value['id'],
						'NAME' => $value['name'],
						'VALUE' => $row['PREVIEW_TEXT'],
						'IS_TEXT' => true,
						'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
					);
				}
			}
			elseif ($value['id'] === 'TYPE')
			{
				$value['name'] = Loc::getMessage('SBB_PRICE_TYPE_NAME');

				if (!empty($row['NOTES']))
				{
					$rowData['COLUMN_LIST'][] = array(
						'CODE' => $value['id'],
						'NAME' => $value['name'],
						'VALUE' => isset($row['~NOTES']) ? $row['~NOTES'] : $row['NOTES'],
						'IS_TEXT' => true,
						'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
					);
				}
			}
			elseif ($value['id'] === 'DISCOUNT')
			{
				$value['name'] = Loc::getMessage('SBB_DISCOUNT_NAME');

				if ($row['DISCOUNT_PRICE_PERCENT'] > 0 && !empty($row['DISCOUNT_PRICE_PERCENT_FORMATED']))
				{
					$rowData['COLUMN_LIST'][] = array(
						'CODE' => $value['id'],
						'NAME' => $value['name'],
						'VALUE' => $row['DISCOUNT_PRICE_PERCENT_FORMATED'],
						'IS_TEXT' => true,
						'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
					);
				} else {
                    $rowData['COLUMN_LIST'][] = array(
                        'CODE' => $value['id'],
                        'NAME' => $value['name'],
                        'VALUE' => '',
                        'IS_TEXT' => true,
                        'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
                    );
                }
			}
			elseif ($value['id'] === 'WEIGHT')
			{
				$value['name'] = Loc::getMessage('SBB_WEIGHT_NAME');

				if (!empty($row['WEIGHT_FORMATED']))
				{
					$rowData['COLUMN_LIST'][] = array(
						'CODE' => $value['id'],
						'NAME' => $value['name'],
						'VALUE' => $row['WEIGHT_FORMATED'],
						'IS_TEXT' => true,
						'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
					);
				}
			}
			elseif (!empty($row[$value['id'].'_SRC']))
			{
				$i = 0;

				foreach ($row[$value['id'].'_SRC'] as &$image)
				{
					$image['INDEX'] = $i++;
				}

				$rowData['COLUMN_LIST'][] = array(
					'CODE' => $value['id'],
					'NAME' => $value['name'],
					'VALUE' => $row[$value['id'].'_SRC'],
					'IS_IMAGE' => true,
					'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
				);
			}
			elseif (!empty($row[$value['id'].'_DISPLAY']))
			{
				$rowData['COLUMN_LIST'][] = array(
					'CODE' => $value['id'],
					'NAME' => $value['name'],
					'VALUE' => $row[$value['id'].'_DISPLAY'],
					'IS_TEXT' => true,
					'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
				);
			}
			elseif (!empty($row[$value['id'].'_LINK']))
			{
				$linkValues = array();

				foreach ($row[$value['id'].'_LINK'] as $index => $link)
				{
					$linkValues[] = array(
						'LINK' => $link,
						'IS_LAST' => !isset($row[$value['id'].'_LINK'][$index + 1])
					);
				}

				$rowData['COLUMN_LIST'][] = array(
					'CODE' => $value['id'],
					'NAME' => $value['name'],
					'VALUE' => $linkValues,
					'IS_LINK' => true,
					'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
				);
			}
			elseif (!empty($row[$value['id']]))
			{
				$rawValue = isset($row['~'.$value['id']]) ? $row['~'.$value['id']] : $row[$value['id']];
				$isHtml = !empty($row[$value['id'].'_HTML']);

				$rowData['COLUMN_LIST'][] = array(
					'CODE' => $value['id'],
					'NAME' => $value['name'],
					'VALUE' => $rawValue,
					'IS_TEXT' => !$isHtml,
					'IS_HTML' => $isHtml,
					'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
				);
			}
            elseif (empty($row[$value['id']]))
            {
                $rawValue = isset($row['~'.$value['id']]) ? $row['~'.$value['id']] : $row[$value['id']];
                $isHtml = !empty($row[$value['id'].'_HTML']);

                $rowData['COLUMN_LIST'][] = array(
                    'CODE' => $value['id'],
                    'NAME' => $value['name'],
                    'VALUE' => '',
                    'IS_TEXT' => !$isHtml,
                    'IS_HTML' => $isHtml,
                    'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
                );
            }
		}
	}

	if (!empty($row['LABEL_ARRAY_VALUE']))
	{
		$labels = array();

		foreach ($row['LABEL_ARRAY_VALUE'] as $code => $value)
		{
			$labels[] = array(
				'NAME' => $value,
				'HIDE_MOBILE' => !isset($this->arParams['LABEL_PROP_MOBILE'][$code])
			);
		}

		$rowData['SHOW_LABEL'] = true;
		$rowData['LABEL_VALUES'] = $labels;
	}

    if(count($rowData['SKU_BLOCK_LIST']) < $countSku) {
        for($i = count($rowData['SKU_BLOCK_LIST']); $i < $countSku; $i++) {
            $rowData['SKU_BLOCK_LIST'][] = [];
        }
    }

    if(count($rowData['PROPS']) < $countProps) {
        for($i = count($rowData['PROPS']); $i < $countProps; $i++)
            $rowData['PROPS'][] = [];
    }

    if(count($rowData['COLUMN_LIST']) < $countColums) {
        $ar = [];
        foreach ($countColums as $codeCol => $va) {
            $iss = array_search($codeCol, array_column($rowData['COLUMN_LIST'], 'CODE'));
            if($iss !== false)
                $ar[] = $rowData['COLUMN_LIST'][$iss];
            else
                $ar[] = ['CODE' => $codeCol, 'NAME' =>$va];
        }
        $rowData['COLUMN_LIST'] = $ar;
    }

	$result['BASKET_ITEM_RENDER_DATA'][] = $rowData;
}

$totalData = array(
	'DISABLE_CHECKOUT' => (int)$result['ORDERABLE_BASKET_ITEMS_COUNT'] === 0,
	'PRICE' => $result['allSum'],
	'PRICE_FORMATED' => $result['allSum_FORMATED'],
	'PRICE_WITHOUT_DISCOUNT_FORMATED' => $result['PRICE_WITHOUT_DISCOUNT'],
	'CURRENCY' => $result['CURRENCY']
);

if ($result['DISCOUNT_PRICE_ALL'] > 0)
{
	$totalData['DISCOUNT_PRICE_FORMATED'] = $result['DISCOUNT_PRICE_FORMATED'];
}

if ($result['allWeight'] > 0)
{
	$totalData['WEIGHT_FORMATED'] = $result['allWeight_FORMATED'];
}

if ($this->priceVatShowValue === 'Y')
{
	$totalData['SHOW_VAT'] = true;
	$totalData['VAT_SUM_FORMATED'] = $result['allVATSum_FORMATED'];
	$totalData['SUM_WITHOUT_VAT_FORMATED'] = $result['allSum_wVAT_FORMATED'];
}

if ($this->hideCoupon !== 'Y' && !empty($result['COUPON_LIST']))
{
	$totalData['COUPON_LIST'] = $result['COUPON_LIST'];
	
	foreach ($totalData['COUPON_LIST'] as &$coupon)
	{
		if ($coupon['JS_STATUS'] === 'ENTERED')
		{
			$coupon['CLASS'] = 'validation-valid-label';
		}
		elseif ($coupon['JS_STATUS'] === 'APPLYED')
		{
			$coupon['CLASS'] = 'validation-valid-label';
		}
		else
		{
			$coupon['CLASS'] = '';
		}
	}
}

$result['TOTAL_RENDER_DATA'] = $totalData;
