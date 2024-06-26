<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

?>
<div class="index_cart-empty">
    <!-- Horizontal form options -->
    <div class="row">
        <div class="col-md-12">
            <!-- Static mode -->
            <div class="card mb-0">

                <div class="card-header">
                    <h6 class="card-title"><span><?= Loc::getMessage("SBB_EMPTY_BASKET_TITLE") ?></span></h6>
                    <? if (!empty($arParams['EMPTY_BASKET_HINT_PATH'])): ?>
                        <div>
                            <h6 class="card-title">
                                <span>
                                    <?= Loc::getMessage(
                                        'SBB_EMPTY_BASKET_HINT',
                                        [
                                            '#A1#' => '<a href="'.$arParams['EMPTY_BASKET_HINT_PATH'].'">',
                                            '#A2#' => '</a>',
                                        ]
                                    ) ?>
                                </span>
                            </h6>
                        </div>
                    <? endif; ?>
                </div>
            </div>
            <!-- /static mode -->
        </div>
    </div>

    <!-- /Horizontal form options -->
</div>