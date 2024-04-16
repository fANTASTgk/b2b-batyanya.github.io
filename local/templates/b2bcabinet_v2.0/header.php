<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Config\Option,
    Bitrix\Main\Loader,
    Bitrix\Main\Page\Asset,
    Bitrix\Main\Localization\Loc,
    Sotbit\B2bCabinet\Helper\Config,
    Sotbit\Multibasket\Helpers;

global $APPLICATION, $USER;

if (defined("NEED_AUTH") && NEED_AUTH === true && !$USER->IsAuthorized()) {
    include_once "auth_header.php";
    return;
}

$userGroupRights = CUser::GetUserGroup($USER->GetID());
$b2bGroupRights = unserialize(Option::get('sotbit.b2bcabinet', 'OPT_BLANK_GROUPS')) ?: [];

if (!array_intersect($userGroupRights, $b2bGroupRights)) {
    $_SESSION['USER_ID_RIGHTS_DENIED'] = $USER->GetID();
    $_GET['ACCESS_RIGHTS_DENIED'] = "Y";
    $USER->Logout();
    define("NEED_AUTH", true);
    include_once "auth_header.php";
    return;
}

$multibasketModuleIs = Loader::includeModule('sotbit.multibasket')
    && Helpers\Config::moduleIsEnabled(SITE_ID);

$methodInstall = Config::getMethodInstall(SITE_ID);
?>
<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>">

<head>
    <meta charset="<?=LANG_CHARSET?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><? $APPLICATION->ShowTitle() ?></title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">

    <?
    CJSCore::Init();
    $APPLICATION->ShowHead();

    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/bootstrap.min.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/bootstrap_limitless.min.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/components.min.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/layout.min.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/icons/phosphor/styles.min.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/constants.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/custom.css");

    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/plugins/jquery/jquery.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/plugins/bootstrap/bootstrap.bundle.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/plugins/notifications/sweet_alert.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/plugins/pickers/anytime.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/plugins/pickers/pickadate/picker.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/plugins/pickers/pickadate/picker.date.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/plugins/pickers/pickadate/picker.time.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/plugins/pickers/pickadate/legacy.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/plugins/forms/selects/select2.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/plugins/forms/selects/select2.langRu.js");

    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/app.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/dashboard.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/pages/sweet-alert.js");
    ?>
</head>

<body>
    <? $APPLICATION->ShowPanel() ?>

    <!-- Page content -->
    <div class="page-content">
        <? $APPLICATION->IncludeComponent(
            "sotbit:sotbit.b2bcabinet.notifications",
            "b2bcabinet",
            array(),
            false,
            [
                "HIDE_ICONS" => "Y"
            ]
        );

        include "header/content_header.php";
        ?>
        <script>
            BX.message({
                'SWEETALERT_DEFAULT_QUESTION': '<?=Loc::getMessage('SWEETALERT_DEFAULT_QUESTION')?>',
                'SWEETALERT_CONFIRM_BUTTON': '<?=Loc::getMessage('SWEETALERT_CONFIRM_BUTTON')?>',
                'SWEETALERT_CANCEL_BUTTON': '<?=Loc::getMessage('SWEETALERT_CANCEL_BUTTON')?>',
            })
        </script>

