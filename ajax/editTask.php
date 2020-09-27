<?php
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
set_time_limit(0);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $USER;
CModule::IncludeModule("iblock");

$el = new CIBlockElement;

$PROP = [];
$PROP[1] = 2;
$PROP[2] = $USER->GetID();

$arLoadProductArray = [
    "IBLOCK_ID" => 1,
    "MODIFIED_BY" => $USER->GetID(),
    "NAME" => $_POST['name'],
    "PREVIEW_TEXT" => $_POST['comment'],
    "PROPERTY_VALUES"=> $PROP
];

$id = $el->Update($_POST['id'], $arLoadProductArray);

?>


<?
$APPLICATION->ShowAjaxHead();
$APPLICATION->IncludeComponent(
    "alex:tasks",
    "main",
    [
        "CACHE_TYPE" => "Y",
        "CACHE_TIME" => "86400"
    ],
    false
);?>
