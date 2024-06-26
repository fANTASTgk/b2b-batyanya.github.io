<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
if ($arParams["ALLOW_UPLOAD"] == "N" && empty($arResult['FILES'])) {
    return "";
}

CJSCore::Init(array('fx', 'ajax', 'dd'));
$APPLICATION->AddHeadScript('/bitrix/js/main/file_upload_agent.js');
$uid = $arParams['CONTROL_ID'] . '_' . $arParams['TAB_ID'];
$controller = "BX('file-selectdialog-" . $uid . "')";
$switcher = "BX('file-selectdialogswitcher-" . $uid . "')";
$controlName = $arParams['INPUT_NAME'];
//$controlNameFull = $controlName . (($arParams['MULTIPLE'] == 'Y') ? '[]' : '');
$arValue = $arResult['FILES'];
$addClass = ((strpos($_SERVER['HTTP_USER_AGENT'], 'Mac OS') !== false) ? 'file-filemacos' : '');
$controlNameFull = htmlspecialcharsbx($controlName);
$delOnclick = "window['BfileFD{$uid}'].agent.StopUpload(BX('wd-doc#element_id#'));";
$thumb = <<<HTML
<tr class="file-inline-file" id="wd-doc#element_id#">
	<td class="files-name">
		<span class="files-text">
			<span class="f-wrap">#name#</span>
		</span>
	</td>
	<td class="files-size">#size#</td>
	<td class="files-storage">
		<div class="files-storage-block">&nbsp;
			<span class="del-but" onclick="{$delOnclick}"></span>
			<span class="files-placement">&nbsp;</span>
			<input id="file-doc#element_id#" type="hidden" name="{$controlNameFull}" value="#element_id#" />
		</div>
	</td>
</tr>
HTML;

if ($arParams["ALLOW_UPLOAD"] != "N") {
    ?>
    <div id="file-selectdialog-<?= $uid ?>" class="file-selectdialog1 form-group file-area" style="display:none;">
        <table id="file-file-template" style='display:none;'>
            <tr class="file-inline-file" id="file-doc">
                <td class="files-name">
				<span class="files-text">
					<span class="f-wrap" data-role='name'>#name#</span>
				</span>
                </td>
                <td class="files-size" data-role='size'>#size#</td>
                <td class="files-storage">
                    <div class="files-storage-block">
                        <span class="files-placement">&nbsp;</span>
                    </div>
                </td>
            </tr>
        </table>
        <div id="file-image-template" style='display:none;'>
            <span class="feed-add-photo-block">
                <span class="feed-add-img-wrap">
                    <img width="90" height="90" border="0" data-role='image'>
                </span>
                <span class="feed-add-img-title" data-role='name'>#name#</span>
                <span class="feed-add-post-del-but"></span>
            </span>
        </div>
        <div class="file-extended file-dummy">
            <div class="file-placeholder">
                <table class="files-list" cellspacing="0">
                    <tbody class="file-placeholder-tbody">
                    <? if (is_array($arValue) && sizeof($arValue) > 0) {
                        foreach ($arValue as $arElement) {
                            ?><?= str_replace(
                                array("#element_id#", "#name#", "#size#"),
                                array(
                                    intval($arElement['ID']),
                                    htmlspecialcharsEx($arElement['ORIGINAL_NAME']),
                                    CFile::FormatSize($arElement["FILE_SIZE"])
                                ),
                                $thumb
                            );
                        }
                    } ?>
                    </tbody>
                </table>
            </div>
            <div class="file-selector">
                <?= GetMessage('BFDND_DROPHERE'); ?><br/>
                <span class="file-uploader">
                    <input class="file-fileUploader <?= $addClass ?>"
                           id="file-fileUploader-<?= $uid ?>"
                           type="file"
                           <?=$arParams["MULTIPLE"] == "Y" ? "multiple='multiple'" : ""?>
                            required
                           size='1'
                    />
                </span>
            </div>
        </div>
        <div class="file-simple" style='padding:0; margin:0;'>
            <span class="file-label"><?= GetMessage('BFDND_FILES') ?></span>
            <div class="file-placeholder">
                <table class="files-list" cellspacing="0">
                    <tbody class="file-placeholder-tbody">
                    <tr style='display: none;'>
                        <td colspan='3'></td>
                    </tr><?
                    if (is_array($arValue) && sizeof($arValue) > 0) {
                        foreach ($arValue as $arElement) {
                            ?><?= str_replace(
                                array("#element_id#", "#name#", "#size#"),
                                array(
                                    intval($arElement['ID']),
                                    htmlspecialcharsEx($arElement['ORIGINAL_NAME']),
                                    CFile::FormatSize($arElement["FILE_SIZE"])
                                ),
                                $thumb
                            );
                        }
                    } ?>
                    </tbody>
                </table>
            </div>
            <div class="file-selector"><span class="file-uploader"><span class="file-uploader-left"></span><span
                            class="file-but-text"><?= GetMessage('BFDND_SELECT_LOCAL'); ?></span><span
                            class="file-uploader-right"></span><input class="file-fileUploader <?= $addClass ?>"
                                                                      id="file-fileUploader-<?= $uid ?>"
                                                                      type="file" <? /*multiple='multiple'*/
                    ?> size='1'/></span></div>
        </div>
        <script>
            BX.ready(function () {
                BX.message({
                    'loading': "<?=(GetMessageJS('BFDND_FILE_LOADING'))?>",
                    'file_exists': "<?=(GetMessageJS('BFDND_FILE_EXISTS'))?>",
                    'upload_error': "<?=(GetMessageJS('BFDND_UPLOAD_ERROR'))?>",
                    'access_denied': "<p style='margin-top:0;'><?=(GetMessageJS('BFDND_ACCESS_DENIED'))?></p>"
                });
                BX.addCustomEvent(<?=$controller?>.parentNode, "BFileDLoadFormController", function (status) {
                    MFIDD({
                        uid: '<?=$uid?>',
                        controller: <?=$controller?>,
                        switcher: <?=$switcher?>,
                        CID: "<?=$arResult['CONTROL_UID']?>",
                        id: "<?=$arParams['CONTROL_ID']?>",
                        upload_path: "<?=CUtil::JSEscape(htmlspecialcharsback(POST_FORM_ACTION_URI))?>",
                        multiple: <?=($arParams['MULTIPLE'] == 'N' ? 'false' : 'true')?>,
                        inputName: "<?=CUtil::JSEscape($controlNameFull)?>",
                        status: status
                    });
                });
                BX.onCustomEvent(<?=$controller?>, "BFileDLoadFormControllerWasBound", [{id: "<?=$arParams['CONTROL_ID']?>"}]);
                <?
                if (sizeof($arValue) >= 1) {
                ?>
                BX.onCustomEvent(<?=$controller?>.parentNode, "BFileDLoadFormController", ['show']);
                <?
                } else {
                ?>
                BX.onCustomEvent(<?=$controller?>.parentNode, 'BFileDLoadFormController');
                if (!BX.browser.IsIE()) {
                    window['bfDisp<?=$uid?>'] = new BlogBFileDialogDispatcher(<?=$controller?>);
                    window['BfileUnbindDispatcher<?=$uid?>'] = function () {
                        BX.onCustomEvent(<?=$controller?>.parentNode.parentNode, 'UnbindDndDispatcher');
                    }
                }
                <?
                }
                ?>
            });
        </script>
    </div>
    <?
} else {
    if (!empty($arValue)) {
        ?>
        <div id="file-selectdialog-<?= $uid ?>" class="file-selectdialog form-group file-area">
            <div class="file-extended file-dummy">
                <span class="file-label"><?= GetMessage('BFDND_FILES') ?></span>
                <div class="file-placeholder">
                    <table class="files-list" cellspacing="0">
                        <tbody class="file-placeholder-tbody">
                        <? if (is_array($arValue) && sizeof($arValue) > 0) {
                            foreach ($arValue as $arElement) {
                                ?><?= str_replace(
                                    array("#element_id#", "#name#", "#size#"),
                                    array(
                                        intval($arElement['ID']),
                                        htmlspecialcharsEx($arElement['ORIGINAL_NAME']),
                                        CFile::FormatSize($arElement["FILE_SIZE"])
                                    ),
                                    $thumb
                                );
                            }

                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <script>
                BX.ready(function () {
                    BX.addCustomEvent(<?=$controller?>.parentNode, "BFileDLoadFormController", function (status) {
                        MFIS({
                            uid: '<?=$uid?>',
                            controller: <?=$controller?>,
                            CID: "<?=$arResult['CONTROL_UID']?>",
                            id: "<?=$arParams['CONTROL_ID']?>",
                            upload_path: "<?=CUtil::JSEscape(htmlspecialcharsback(POST_FORM_ACTION_URI))?>",
                            status: status
                        });
                    });
                    BX.onCustomEvent(<?=$controller?>, "BFileDLoadFormControllerWasBound", [{id: "<?=$arParams['CONTROL_ID']?>"}]);
                    BX.onCustomEvent(<?=$controller?>.parentNode, "BFileDLoadFormController");
                });
            </script>
        </div>
    <? }
} ?>