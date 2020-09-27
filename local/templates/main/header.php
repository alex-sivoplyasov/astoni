<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
use Bitrix\Main\Page\Asset;
?>
<!DOCTYPE html>
<html lang="<?= LANGUAGE_ID?>">
<head>
    <meta charset="UTF-8">
    <?$APPLICATION->ShowHead();?>
    <title><?$APPLICATION->ShowTitle()?></title>

    <?Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/normalize.css");?>
    <?Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/bootstrap.min.css");?>
    <?Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/main.css");?>

<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>-->
    <?Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/jquery-3.5.1.min.js");?>
<!--    --><?//Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/bootstrap.min.js");?>
</head>
<body>
<?$APPLICATION->ShowPanel()?>
<div id="app">
    <header class="header bg-primary">
        <div class="container">
            <nav class="navbar navbar-light">
                <a class="navbar-brand" href="/">
                    <img src="<?= SITE_TEMPLATE_PATH?>/images/icon.svg" width="30" height="30" class="d-inline-block align-top" alt="">
                    Таск менеджер
                </a>
            </nav>
        </div>

    </header>

