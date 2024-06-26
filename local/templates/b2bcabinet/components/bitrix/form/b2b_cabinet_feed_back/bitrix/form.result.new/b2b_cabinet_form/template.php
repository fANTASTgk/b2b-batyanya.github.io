<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<?

use Sotbit\B2bCabinet\Helper\Config;

CJSCore::Init(['masked_input']);
?>

<?= $arResult["FORM_HEADER"] ?>
<!-- modal manager -->
<div id="modal_manager" class="modal fade modal_manager" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-main text-white">
                <h6 class="modal-title"><?= $arResult["FORM_TITLE"] ?></h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                <? if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y") {
                    if ($arResult["isFormImage"] == "Y") {
                        ?>
                        <a href="<?= $arResult["FORM_IMAGE"]["URL"] ?>" target="_blank"
                           alt="<?= GetMessage("FORM_ENLARGE") ?>"><img
                                    src="<?= $arResult["FORM_IMAGE"]["URL"] ?>"
                                    <? if ($arResult["FORM_IMAGE"]["WIDTH"] > 300): ?>width="300"
                                    <? elseif ($arResult["FORM_IMAGE"]["HEIGHT"] > 200): ?>height="200"<? else: ?><?= $arResult["FORM_IMAGE"]["ATTR"] ?><? endif;
                            ?> hspace="3" vscape="3" border="0"/></a>
                        <?
                    }
                    ?>
                    <p><?= $arResult["FORM_DESCRIPTION"] ?></p>
                    <?
                }
                foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) {
                    ?>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">
                            <? if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID,
                                    $arResult['FORM_ERRORS'])): ?>
                                <span class="error-fld"
                                      title="<?= htmlspecialcharsbx($arResult["FORM_ERRORS"][$FIELD_SID]) ?>">
                                    </span>
                            <? endif; ?>
                            <?= $arQuestion["CAPTION"] ?><? if ($arQuestion["REQUIRED"] == "Y"): ?><?= $arResult["REQUIRED_SIGN"]; ?><? endif; ?>
                            <?= $arQuestion["IS_INPUT_CAPTION_IMAGE"] == "Y" ? "<br />" . $arQuestion["IMAGE"]["HTML_CODE"] : "" ?>
                        </label>
                        <div class="col-lg-9">
                            <!--                                <input type="text" class="form-control">-->
                            <?= $arQuestion["HTML_CODE"] ?>
                        </div>
                    </div>
                    <?
                } //endwhile
                if ($arResult["isUseCaptcha"] == "Y") {
                    ?>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">
                            <?= GetMessage("FORM_CAPTCHA_FIELD_TITLE") ?><?= $arResult["REQUIRED_SIGN"]; ?>
                        </label>

                        <div class="col-lg-9">
                            <div>
                                <input type="text" name="captcha_word" size="30" maxlength="50" value=""
                                       class="inputtext"/>
                            </div>
                            <div class="modal-manager-image">
                                <input type="hidden" name="captcha_sid"
                                       value="<?= htmlspecialcharsbx($arResult["CAPTCHACode"]); ?>"/>
                                <img src="/bitrix/tools/captcha.php?captcha_sid=<?= htmlspecialcharsbx($arResult["CAPTCHACode"]); ?>"
                                     width="180" height="40"/>
                            </div>
                        </div>
                    </div>
                    <?
                }
                ?>
                <p>
                    <?= $arResult["REQUIRED_SIGN"]; ?> - <?= GetMessage("FORM_REQUIRED_FIELDS") ?>
                </p>
                <!-- errors -->
                <div>
                    <? if ($arResult["isFormErrors"] == "Y"): ?><?= $arResult["FORM_ERRORS_TEXT"]; ?><? endif; ?>
                </div>
                <!--/ errors -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-link btn-light"
                        data-dismiss="modal"
                        type="reset">
                    <?= GetMessage("FORM_MANAGER_RESET"); ?>
                </button>
                <input <?= (intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : ""); ?>
                        type="submit"
                        class="btn btn_b2b"
                        name="web_form_submit"
                        value="<?= htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0
                            ? GetMessage("FORM_ADD")
                            : mb_convert_case($arResult["arForm"]["BUTTON"], MB_CASE_TITLE)) ?>"
                />
            </div>
        </div>
    </div>
</div>
<!-- /modal manager -->
<?= $arResult["FORM_FOOTER"] ?>

<? if ($arResult["FORM_NOTE"]): ?>
    <script>
        SweetAlert.showSuccess(`<?=$arResult["FORM_NOTE"]?>`);
        document.querySelector(".modal-backdrop.fade.show").remove();
    </script>
<? endif; ?>

<script>
    BX.ready(function () {
        var mask = '<?=Config::get('INPUT_MASK', SITE_ID) ?: '+7 999 999 99 99'?>';
        let input = document.getElementById('tel');

        if (!input) {
            return;
        }

        var result = new BX.MaskedInput({
            mask: mask,
            input: input,
            placeholder: '_'
        });

        result.setValue('');
    });
</script>