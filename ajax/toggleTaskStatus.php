<?php
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
set_time_limit(0);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");


$el = new CIBlockElement;

$PROP = [];
$PROP[1] = $_POST['status'];

$arLoadProductArray = Array(
    "PROPERTY_VALUES"=> $PROP,
);

$res = $el->Update($_POST['id'], $arLoadProductArray);

echo json_encode($res);
