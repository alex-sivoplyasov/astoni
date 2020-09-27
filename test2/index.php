<?
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
set_time_limit(0);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;

if($_REQUEST["ADD_TO_COMPARE"] == "Y") {
    if (isset($_REQUEST["ID"])) {
        CModule::IncludeModule('iblock');
        global $DB;
        $arFilter = Array(
            "IBLOCK_ID" => CATALOG_IBLOCK,
            "ID" => $_REQUEST["ID"],
        );
        $arOrder = Array();
        $arSelect = Array("ID", "NAME", "IBLOCK_SECTION_ID");

        $arProduct = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect)->Fetch();
        //$_SESSION["CATALOG_COMPARE_LIST"][20]['ITEMS'][$_REQUEST["ID"]] = $arProduct;

        //Добавление товаров сравнения в куки
        $application = Application::getInstance();
        $context = $application->getContext();

        //Получение  товаров в сравнении
        $compareProducts = unserialize(Application::getInstance()->getContext()->getRequest()->getCookie("COMPARE_ITEMS"));

        //Добавление текущего товара в список сравнения
        $compareProducts[$arProduct["ID"]] = $arProduct;
        // unset($compareProducts);

        //Сериализуем массив и добавляем в куки
        $compareCookie  = serialize($compareProducts);
        $cookie = new Cookie("COMPARE_ITEMS", $compareCookie, time() + 60*60*24*60);
        $cookie->setDomain($context->getServer()->getHttpHost());
        $cookie->setHttpOnly(false);

        $context->getResponse()->addCookie($cookie);
        $context->getResponse()->flush("");

        //Готовим запрос к бд
        $product_id = intval($arProduct["ID"]);
        $product_name = $arProduct["NAME"];

        //Получаем товар с таким id
        $query = "SELECT * FROM rms_compare_items WHERE PRODUCT_ID = '$product_id'";
        $res = $DB->Query($query)->GetNext();

        //Если такого товара нет, то добавляем, а если есть - увеличиваем счетчик
        if( !empty($res["COUNTER"]) ) {
            $newCount = $res["COUNTER"] + 1;
            $query = "UPDATE rms_compare_items SET COUNTER = '$newCount' WHERE PRODUCT_ID = '$product_id'";
            $DB->Query($query);

        } else {
            $query = "INSERT INTO rms_compare_items (PRODUCT_ID, NAME, COUNTER) VALUES ('$product_id',  '$product_name', 1)";
            $DB->Query($query);
        }

    }
    echo json_encode("success");
}

if( $_REQUEST["RUN_COMPONENT"] == "Y") {
    $APPLICATION->ShowAjaxHead();
    $APPLICATION->IncludeComponent(
        "rms:catalog.compare",
        "main",
        array(
            "NAME" => $_SESSION[$_REQUEST["COMPARE_LIST"]],	// Уникальное имя для списка сравнения
            "IBLOCK_TYPE" => "1c_catalog",	// Тип инфоблока
            "IBLOCK_ID" => CATALOG_IBLOCK,	// Инфоблок
            "PRICE_CODE" => array(
                0 => "nirvanna_".$_SESSION["G_PRICE_ID"],
            ),	//
            "CONVERT_CURRENCY" => "N",
            "PRICE_VAT_INCLUDE" => "Y",
            "CACHE_TIME" => "86400",

        ),
        false
    );
}

if( $_REQUEST["REMOVE_FROM_COMPARE"] == "Y") {
    if (isset($_REQUEST["ID"])) {
        $compareProducts = unserialize(Application::getInstance()->getContext()->getRequest()->getCookie("COMPARE_ITEMS"));
        unset($compareProducts[$_REQUEST["ID"]]);

        $application = Application::getInstance();
        $context = $application->getContext();

        //Сериализуем массив и добавляем в куки
        $compareCookie = serialize($compareProducts);
        $cookie = new Cookie("COMPARE_ITEMS", $compareCookie, time() + 60*60*24*60);
        $cookie->setDomain($context->getServer()->getHttpHost());
        $cookie->setHttpOnly(false);

        $context->getResponse()->addCookie($cookie);
        $context->getResponse()->flush("");
    }

    echo json_encode($compareProducts);
}

if($_REQUEST["GET_COMPARE_ITEMS"] == "Y") {
    $compareItems = unserialize(Application::getInstance()->getContext()->getRequest()->getCookie("COMPARE_ITEMS"));

    if(!empty($compareItems)) {
        foreach ($compareItems as $arItem) {
            $arItemsIDs[] = $arItem["ID"];
        }
    } else {
        $arItemsIDs = Array();
    }

    echo json_encode($arItemsIDs);
}
