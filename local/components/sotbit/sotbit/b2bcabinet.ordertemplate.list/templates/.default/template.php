<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

?>
<div class="ordertemplates-list-wrap" id="ordertemplates-list-wrap">
    <div class="ordertemplates-filter-wrap">
        <div class="main-ui-filter-search-wrapper">
            <?
            $APPLICATION->IncludeComponent(
                "bitrix:main.ui.filter",
                "b2bcabinet",
                array(
                    "FILTER_ID" => "TEMPLATE_LIST",
                    "GRID_ID" => "TEMPLATE_LIST",
                    'FILTER' => [
                        ['id' => 'ID', 'name' => GetMessage("SOTBIT_B2BCABINET_ORDERTEMPLATES_HEADER_ID"), 'type' => 'string'],
                        ['id' => 'NAME', 'name' => GetMessage("SOTBIT_B2BCABINET_ORDERTEMPLATES_HEADER_NAME"), 'type' => 'string'],
                        ['id' => 'DATE_CREATE', 'name' => GetMessage("SOTBIT_B2BCABINET_ORDERTEMPLATES_HEADER_DATE_CREATE"), 'type' => 'date'],
                    ],
                    "ENABLE_LIVE_SEARCH" => true,
                    "ENABLE_LABEL" => true,
                    "COMPONENT_TEMPLATE" => "b2bcabinet"
                ),
                false
            );
            ?>
        </div>
    </div>
    <?
    $APPLICATION->IncludeComponent(
        'bitrix:main.ui.grid',
        '',
        array(
            'GRID_ID' => 'TEMPLATE_LIST',
            'HEADERS' => array(
                array("id" => "ID", "name" => GetMessage("SOTBIT_B2BCABINET_ORDERTEMPLATES_HEADER_ID"), "sort" => "ID", "default" => false, "editable" => false),
                array("id" => "NAME", "name" => GetMessage("SOTBIT_B2BCABINET_ORDERTEMPLATES_HEADER_NAME"), "sort" => "NAME", "default" => true, "editable" => false),
                array("id" => "DATE_CREATE", "name" => GetMessage("SOTBIT_B2BCABINET_ORDERTEMPLATES_HEADER_DATE_CREATE"), "sort"=>"DATE_CREATE", "default" => true, "editable" => false),
                array("id" => "USER", "name" => GetMessage("SOTBIT_B2BCABINET_ORDERTEMPLATES_HEADER_USER"), "default" => true, "editable" => false),
            ),
            'ROWS' => $arResult['ROWS'],
            'AJAX_MODE' => 'Y',

            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "N",
            "AJAX_OPTION_HISTORY" => "N",

            "ALLOW_COLUMNS_SORT" => true,
            "ALLOW_ROWS_SORT" => ['NAME'],
            "ALLOW_COLUMNS_RESIZE" => true,
            "ALLOW_HORIZONTAL_SCROLL" => true,
            "ALLOW_SORT" => true,
            "ALLOW_PIN_HEADER" => true,
            "ACTION_PANEL" => [],

            "SHOW_CHECK_ALL_CHECKBOXES" => false,
            "SHOW_ROW_CHECKBOXES" => false,
            "SHOW_ROW_ACTIONS_MENU" => true,
            "SHOW_GRID_SETTINGS_MENU" => true,
            "SHOW_NAVIGATION_PANEL" => true,
            "SHOW_PAGINATION" => true,
            "SHOW_SELECTED_COUNTER" => false,
            "SHOW_TOTAL_COUNTER" => true,
            "SHOW_PAGESIZE" => true,
            "SHOW_ACTION_PANEL" => true,

            "ENABLE_COLLAPSIBLE_ROWS" => true,
            'ALLOW_SAVE_ROWS_STATE' => true,

            "SHOW_MORE_BUTTON" => false,
            '~NAV_PARAMS' => $arResult['GET_LIST_PARAMS']['NAV_PARAMS'],
            'NAV_OBJECT' => $arResult['NAV_OBJECT'],
            'NAV_STRING' => $arResult['NAV_STRING'],
            "TOTAL_ROWS_COUNT" => $arResult['TOTAL_ROWS_COUNT'],
            "CURRENT_PAGE" => $arResult['CURRENT_PAGE'],
            "PAGE_SIZES" => $arParams['ORDERS_PER_PAGE'],
            "DEFAULT_PAGE_SIZE" => 50,
        ),
        $component,
        array('HIDE_ICONS' => 'Y')
    );
    ?>

    <section class="catalog__footer">
        <div class="catalog__footer-wrapper">
            <div class="catalog__actions">
                <button class="catalog__actions-toggler">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                        <g clip-path="url(#clip0)">
                            <path d="M9.41421 1.16513C10.1953 1.94618 10.1953 3.21251 9.41421 3.99355C8.63316 4.7746 7.36683 4.7746 6.58578 3.99355C5.80474 3.21251 5.80474 1.94618 6.58578 1.16513C7.3668 0.384084 8.63313 0.384084 9.41421 1.16513Z" fill="#565667"/>
                            <path d="M9.41421 7.1651C10.1953 7.94615 10.1953 9.21248 9.41421 9.99352C8.63316 10.7746 7.36683 10.7746 6.58578 9.99352C5.80474 9.21248 5.80474 7.94615 6.58578 7.1651C7.3668 6.38405 8.63313 6.38405 9.41421 7.1651Z" fill="#565667"/>
                            <path d="M9.41421 13.1652C10.1953 13.9462 10.1953 15.2125 9.41421 15.9936C8.63316 16.7746 7.36683 16.7746 6.58578 15.9936C5.80474 15.2125 5.80474 13.9462 6.58578 13.1652C7.3668 12.3841 8.63313 12.3841 9.41421 13.1652Z" fill="#565667"/>
                        </g>
                        <defs>
                            <clipPath id="clip0">
                                <rect width="16" height="16" fill="white" transform="translate(0 0.579346)"/>
                            </clipPath>
                        </defs>
                    </svg>
                    <span><?=Loc::getMessage("CT_BZ_ACTION_BUTTON")?></span>
                </button>
                <div id="catalog__actions-container" class="catalog__actions-container">
                    <ul class="catalog__actions-list">
                        <li class="catalog__actions-item">
                            <?php
                            $APPLICATION->IncludeComponent(
                                "sotbit:b2bcabinet.ordertemplate.add",
                                "",
                                [
                                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                    "LIST_PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                                    "PRICE_CODE" => $arParams["PRICE_CODE"],
                                    "SEF_URL_TEMPLATES" => $arParams["SEF_URL_TEMPLATES"],
                                ],
                                false
                            );
                                ?>
                        </li>
                        <li class="catalog__actions-item">
                            <?
                            $APPLICATION->IncludeComponent(
                                "sotbit:b2bcabinet.excel.export",
                                ".default",
                                array(
                                    "COMPONENT_TEMPLATE" => ".default",
		                            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                    "MODEL_OF_WORK" => "default",
                                    "PRICE_CODE" => array(
                                        0 => "BASE",
                                        1 => "OPT",
                                        2 => "SMALL_OPT",
                                        3 => "Base",
                                        4 => "",
                                        5 => "",
                                    ),
                                    "HEADERS_COLUMN" => array(
                                        0 => "NAME",
                                        1 => "DETAIL_PICTURE",
                                        2 => "DATE_CREATE",
                                        3 => "",
                                    ),
                                    "PROPERTY_CODE" => array(
                                        0 => "",
                                        1 => "BRAND_REF",
                                        2 => "MATERIAL",
                                        3 => "COLOR",
                                        4 => "",
                                    ),
                                    "OFFERS_PROPERTY_CODE" => array(
                                        0 => "ARTNUMBER",
                                        1 => "COLOR_REF",
                                        2 => "SIZES_CLOTHES",
                                        3 => "",
                                    ),
                                    "SORT_BY" => "NAME",
                                    "SORT_ORDER" => "asc",
                                    "ONLY_AVAILABLE" => "Y",
                                    "FILTER_NAME" => $arParams["FILTER_NAME"],
                                    "BTN_TITLE" => Loc::getMessage('SOTBIT_B2BCABINET_ORDERTEMPLATES_BTN_IMPORT')
                                ),
                                false
                            );
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="wrap-popup-window popup-order-add-basket" style="display: none;">
    <div class="modal-popup-bg" onclick="closeModal();">&nbsp;</div>
    <div class="popup-window">
        <div class="popup-close" onclick="closeModal();"></div>
        <div class="popup-content">
            <div id="ordertemplates-addbasket-block">
                <p class="form-title">
                    <?=GetMessage("SOTBIT_B2BCABINET_ORDERTEMPLATES_FORM_ADD_BASKET_TITLE")?>
                </p>
                <div class="form-description">

                </div>
                <div class="confirm__row">
                    <button type="button" class="btn btn-light btn-no" onclick="closeModal();">
                        <?=GetMessage("SOTBIT_B2BCABINET_ORDERTEMPLATES_FORM_RESET")?>
                    </button>
                    <button type="button" class="btn btn-light btn_b2b" onclick="addToBasket()">
                        <?=GetMessage("SOTBIT_B2BCABINET_ORDERTEMPLATES_FORM_ADD_BASKET_CREATE_ORDER")?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wrap-popup-window popup-order-remove" style="display: none;">
    <div class="modal-popup-bg" onclick="closeModal();">&nbsp;</div>
    <div class="popup-window">
        <div class="popup-close" onclick="closeModal();"></div>
        <div class="popup-content">
            <div id="ordertemplates-remove-block">
                <p class="form-title">
                    <?=GetMessage("SOTBIT_B2BCABINET_ORDERTEMPLATES_FORM_TITLE")?>
                </p>
                <div class="form-description">
                </div>
                <div class="confirm__row">
                    <button type="button" class="btn btn-light btn-no" onclick="closeModal();">
                        <?=GetMessage("SOTBIT_B2BCABINET_ORDERTEMPLATES_FORM_RESET")?>
                    </button>
                    <button type="button" class="btn btn-light btn_b2b" onclick="removeTemplate()">
                        <?=GetMessage("SOTBIT_B2BCABINET_ORDERTEMPLATES_FORM_DELETE")?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wrap-popup-window popup-order-remove-success" style="display: none;">
    <div class="modal-popup-bg" onclick="closeModal();">&nbsp;</div>
    <div class="popup-window">
        <div class="popup-close" onclick="closeModal();"></div>
        <div class="popup-content">
            <p class="form-title">
                <?=GetMessage("SOTBIT_B2BCABINET_ORDERTEMPLATES_FORM_REMOVE_TITLE")?>
            </p>
            <div class="form-description">
            </div>
            <div class="confirm__row">
                <button type="button" class="btn btn-light btn_b2b" onclick="closeModal();">
                    <?=GetMessage("SOTBIT_B2BCABINET_ORDERTEMPLATES_FORM_OK")?>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    var site_path = '<?=SITE_DIR?>';
    var path_to_detail = '<?=$arParams["PATH_TO_DETAIL"]?>';
    var tableHeader = <?=CUtil::PhpToJSObject($arResult["TABLE_HEADER"])?>;
    var filterProps = <?=CUtil::PhpToJSObject($arResult["FILTER_DOCUMENT"])?>;
    var priceCodes = <?=CUtil::PhpToJSObject($arParams['PRICE_CODE'])?>;
    var id_products = <?=CUtil::PhpToJSObject($arResult["PRODUCTS"])?>;
    var quantity = <?=CUtil::PhpToJSObject($arResult["QUANTITY"])?>;
    var baseCurrency = '<?=CCurrency::GetBaseCurrency()?>';
    var add_basket_descr = '<?=GetMessage("SOTBIT_B2BCABINET_ORDERTEMPLATES_FORM_DESCRIPTION_ORDER")?>';
    var remove_descr = '<?=GetMessage("SOTBIT_B2BCABINET_ORDERTEMPLATES_FORM_DESCRIPTION_REMOVE")?>';
    var success_descr = '<?=GetMessage("SOTBIT_B2BCABINET_ORDERTEMPLATES_FORM_DESCRIPTION_REMOVE_SUCCESS")?>';
    var path_to_basket = '<?=\Bitrix\Main\Config\Option::get('sotbit.b2bcabinet', 'BASKET_URL', '', SITE_ID)?>';
</script>