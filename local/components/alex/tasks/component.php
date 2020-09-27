<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$this->setFrameMode(true);

global $USER;
echo $USER->GetID();

if(CModule::IncludeModule('iblock')) {
    $arFilter = [
        'IBLOCK_ID' => 1,
        'ACTIVE' => 'Y',
        'PROPERTY_USER_ID_VALUE' => $USER->GetID()
    ];

    $arOrder = [
        'SORT' => 'ASC'
    ];

    $arSelect = ['ID', 'NAME', 'PREVIEW_TEXT', 'DATE_CREATE', 'PROPERTY_USER_ID', 'PROPERTY_STATUS'];
//    $arSelect = [];
    $rsTasks = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);

    $arTasks = [];
    $count = 0;
    while ($arTask = $rsTasks->Fetch()) {
        $count += 1;
        $arTasks[$arTask['ID']] = $arTask;
        $arTasks[$arTask['ID']]['COUNT'] = $count;
    }

    $arResult['ITEMS'] = $arTasks;

//    echo '<pre>';
//    print_r($arTasks);
//    echo '</pre>';
}

$this->IncludeComponentTemplate();

//if ($this->startResultCache($arParams['CACHE_TIME'], $arParams))
//{
//    if(CModule::IncludeModule('iblock'))
//    {
//        global $arrPriceIDs;
//
//        $brand_code         = strip_tags($arParams['BRAND_CODE']);
//        $porp_id            = 0;
//        $porp_val           = '';
//        $tmp_header         = '';
//        $show_items_falg    = false;
//        $url_filter_params  = '';
//
//        $property_enums = CIBlockPropertyEnum::GetList(Array('VALUE'=>'ASC'), Array('IBLOCK_ID'=>CATALOG_IBLOCK, 'VALUE'=>trim($brand_code), '!PROPERTY_ID'=>1385));
//        while($enum_fields = $property_enums->GetNext())
//            $url_filter_params .= '&arrFilter_catalog_'.$enum_fields['PROPERTY_ID'].'_'.abs(crc32($enum_fields['ID'])).'=Y';
//
//        $property_enums = CIBlockPropertyEnum::GetList(Array('VALUE'=>'ASC'), Array('IBLOCK_ID'=>CATALOG_IBLOCK, 'PROPERTY_ID'=>1385));
//        while($enum_fields = $property_enums->GetNext())
//        {
//            $tmp_code = Cutil::translit($enum_fields['VALUE'], 'ru', array('replace_space'=>'-','replace_other'=>'-'));
//            if($tmp_code==$brand_code)
//            {
//                $arResult['BRAND_PROP_VALUE'] = abs(crc32($enum_fields['ID']));
//                $porp_id    = $enum_fields['ID'];
//                $porp_val   = $enum_fields['VALUE'];
//                break;
//            }
//        }
//
//        $brandSelect = Array('IBLOCK_ID', 'ID', 'NAME', 'CODE', 'PROPERTY_BINDED_GOODS', 'PREVIEW_PICTURE','DETAIL_TEXT','PROPERTY_RUS_NAME','PROPERTY_BANNER','PROPERTY_SUBTITLE','PROPERTY_TEXT1_TOP','PROPERTY_TEXT2_IMG','PROPERTY_IMG1_UNDERTEXT','PROPERTY_TEXT3_MID_LEFT','PROPERTY_TEXT4_MID_RIGHT','PROPERTY_IMG2_BOT','PROPERTY_TEXT5_BOT','PROPERTY_YOUTUBE_LINK',);
//        $res_brand = CIBlockElement::GetList(Array('ID'=>'ASC'), Array('IBLOCK_ID'=>BRANDS_IBLOCK_ID,'ACTIVE'=>'Y','CODE'=>$brand_code), false, Array('nPageSize'=>1), $brandSelect);
//
//        // если бренда не существует, то показываем 404
//        if(intval($res_brand->SelectedRowsCount()) <= 0)
//        {
//            $this->AbortResultCache();
//            EventTools::My404PageInSiteStyle(true, true);
//            return;
//        }
//
//        while($ob_brand = $res_brand->GetNextElement())
//        {
//            $ar_brand = $ob_brand->GetFields();
//            $ar_brand_props = $ob_brand->GetProperties();
//            $tmp_brand   = $ar_brand['NAME'];
//            $tmp_header  = $ar_brand['NAME'];
//            $arResult['BRAND_ID'] = $ar_brand['ID'];
//        }
//
//        $arCollection   = array();
//        $arGroups       = array();
//        $arSections     = array();
//
//        $arFilter = Array(
//            'IBLOCK_ID'=>CATALOG_IBLOCK,
//            'GLOBAL_ACTIVE'=>'Y',
//            'ACTIVE'=>'Y',
//            'PROPERTY_1385_VALUE_ID'=>$porp_id,
//            '!PROPERTY_NE_POKAZYVAT_NIGDE'=>'Y',
//            '!ID' => \CIBlockElement::SubQuery('ID', array('IBLOCK_ID' => CATALOG_IBLOCK, 'PROPERTY_NE_POKAZYVAT_V_GORODE_VALUE' => $_SESSION['G_PRICE_ID'])), // не показывать в городе
//            '!DETAIL_PICTURE'=>false
//        );
//        if (IS_OPT_CLIENT)
//            $arFilter['PROPERTY_KATEGORIYA_TOVARA_DLYA_OPT'] = $_SESSION['OPT_CLIENT_SETTINGS']['PRODUCTS_GROUPS'];
//
//        $res_col = CIBlockElement::GetList(Array('ID'=>'ASC'), $arFilter, false, false, Array('ID', 'NAME', 'PROPERTY_1455','IBLOCK_SECTION_ID','PREVIEW_PICTURE'));
//        while($ob_col = $res_col->GetNextElement())
//        {
//            $ar_col = $ob_col->GetFields();
//            $tmpCollection = trim($ar_col['PROPERTY_1455_VALUE']);
//            if($tmpCollection!='')
//            {
//                $arCollection[$tmpCollection][] = $ar_col['ID'];
//                if ($ar_col['IBLOCK_SECTION_ID'] != '')
//                    $arGroups[$ar_col['IBLOCK_SECTION_ID']] += 1;
//            }
//        }
//
//        ksort($arCollection);
//
//        foreach($arGroups as $sid => $qty)
//        {
//            $tmpGroupName = reset(CatalogTools::g_get_name_by_section_id($sid));
//            $tmpGroupName['QTY'] = $qty;
//            $arSections[ $tmpGroupName['NAME'] ] = $tmpGroupName;
//        }
//
//        ksort($arSections);
//
//        $res_collection = CIBlockElement::GetList(Array('ID'=>'ASC'), array('IBLOCK_ID'=>COLLECTIONS_IBLOCK_ID, 'ACTIVE'=>'Y', 'NAME'=>$arParams['COLLECTION']), false,false, array());
//        if($ar_collection = $res_collection->GetNext())
//            $DETAIL_TEXT = $ar_collection['DETAIL_TEXT'];
//
//        $arResult['url_filter_params'] = $url_filter_params;
//        $arResult['ar_brand'] = $ar_brand;
//        $arResult['ar_brand_props'] = $ar_brand_props;
//        $arResult['arCollection'] = $arCollection;
//        $arResult['tmp_header'] = $tmp_header;
//        $arResult['DETAIL_TEXT'] = $DETAIL_TEXT;
//        $arResult['show_items_falg'] = $show_items_falg;
//        $arResult['arSections'] = $arSections;
//        $arResult['brand_products_ids'] = array();
//        $arResult['collection_products_ids'] = array();
//        $arResult['COLLECTIONS'] = array();
//
//        // находим разделы комплектующих
//        $accessoriesSections = array();
//        $sectionsDB = $DB->Query('select ID from b_iblock_section where IBLOCK_SECTION_ID = 1102');
//        while ($record = $sectionsDB->fetch())
//            $accessoriesSections[] = $record['ID'];
//
//        // находим подразделы комплектующих
//        $sectionsDB = $DB->Query('select ID from b_iblock_section where IBLOCK_SECTION_ID in (' . implode(',', $accessoriesSections) . ')');
//        while ($record = $sectionsDB->fetch())
//            $accessoriesSections[] = $record['ID'];
//
//        // получаем товары этого бренда
//        $arFilter = array(
//            'ACTIVE' => 'Y',
//            'IBLOCK_ID' => CATALOG_IBLOCK,
//            '!IBLOCK_SECTION_ID' => $accessoriesSections,
//            '!PROPERTY_NE_POKAZYVAT_NIGDE' => 'Y',
//            '!ID' => \CIBlockElement::SubQuery('ID', array('IBLOCK_ID' => CATALOG_IBLOCK, 'PROPERTY_NE_POKAZYVAT_V_GORODE_VALUE' => $_SESSION['G_PRICE_ID'])), // не показывать в городе
//            '>CATALOG_PRICE_'.$_SESSION['ar_site_info']['PRICE_ID'] => 0,
//            array(
//                'LOGIC' => 'OR',
//                array('PROPERTY_1385_VALUE' => trim($arResult['ar_brand']['NAME'])),
//                array('PROPERTY_1385_VALUE' => trim($arResult['ar_brand_props']['RUS_NAME']['VALUE']))
//            ),
//            '!DETAIL_PICTURE' => false,
//        );
//        if (IS_OPT_CLIENT)
//            $arFilter['PROPERTY_KATEGORIYA_TOVARA_DLYA_OPT'] = $_SESSION['OPT_CLIENT_SETTINGS']['PRODUCTS_GROUPS'];
//
//        $brandProducts = array();
//        $collectionProducts = array();
//
//        if ($arParams['SLIDE_PRODUCTS_COUNT'] == '' || $arParams['SLIDE_PRODUCTS_COUNT'] <= 0)
//            $arParams['SLIDE_PRODUCTS_COUNT'] = 5;
//
//        $res = CIBlockElement::GetList(array(), $arFilter, false, false, array('ID', 'IBLOCK_ID', 'NAME', 'IBLOCK_SECTION_ID', 'IBLOCK_SECTION_CODE', 'SECTION_CODE', 'PROPERTY_1385', 'PROPERTY_1455'));
//        while ($row = $res->fetch())
//        {
//            if (count($brandProducts[$row['IBLOCK_SECTION_ID']]) < $arParams['SLIDE_PRODUCTS_COUNT'])
//            {
//                $brandProducts[$row['IBLOCK_SECTION_ID']][] = true;
//                $arResult['brand_products_ids'][] = $row['ID'];
//                $arResult['BRAND_PROP_ID'] = abs(crc32($row['PROPERTY_1385_ENUM_ID']));
//            }
//
//            if ($row['PROPERTY_1455_VALUE'] != '' && count($collectionProducts[$row['PROPERTY_1455_VALUE']]) < $arParams['SLIDE_PRODUCTS_COUNT'])
//            {
//                $collectionProducts[$row['PROPERTY_1455_VALUE']][] = true;
//                $arResult['collection_products_ids'][] = $row['ID'];
//                $arResult['COLLECTION_PROP_ID'] = abs(crc32($row['PROPERTY_1455_ENUM_ID']));
//            }
//        }
//        unset($brandProducts, $collectionProducts);
//
//        $arFilter = array(
//            'ACTIVE' => 'Y',
//            'IBLOCK_ID' => COLLECTIONS_IBLOCK_ID,
//            'PROPERTY_BRAND' => $arResult['BRAND_ID'],
//            '!PROPERTY_NE_POKAZYVAT_NIGDE' => 'Y',
//        );
//        if (IS_OPT_CLIENT)
//            $arFilter['PROPERTY_KATEGORIYA_TOVARA_DLYA_OPT'] = $_SESSION['OPT_CLIENT_SETTINGS']['PRODUCTS_GROUPS'];
//        $res = CIBlockElement::GetList(array('NAME' => 'ASC'), $arFilter, false, false, array('ID', 'NAME', 'CODE', 'PREVIEW_TEXT'));
//        while ($row = $res->fetch()) {
//            $arResult['COLLECTIONS'][$row['NAME']] = $row;
//            $arResult['COLLECTIONS_NAMES'][] = $row['NAME'];
//
//        }
//
//        // находим разделы комплектующих
//        $accessoriesSections = array();
//        $sectionsDB = $DB->Query('select ID from b_iblock_section where IBLOCK_SECTION_ID = 1102');
//        while ($record = $sectionsDB->fetch())
//            $accessoriesSections[] = $record['ID'];
//
//        // находим подразделы комплектующих
//        $sectionsDB = $DB->Query('select ID from b_iblock_section where IBLOCK_SECTION_ID in (' . implode(',', $accessoriesSections) . ')');
//        while ($record = $sectionsDB->fetch())
//            $accessoriesSections[] = $record['ID'];
//
//        //Получение продуктов коллекции
//        $arFilter = Array(
//            'IBLOCK_ID' => CATALOG_IBLOCK,
//            'ACTIVE' => 'Y',
//            'PROPERTY_KOLLEKTSIYA_MNOZHESTVENNOE_OBSHCHEE_DLYA_VSEKH_VALUE' => $arResult['COLLECTIONS_NAMES'],
//            'PROPERTY_PROIZVODITEL_OBSHCHEE_DLYA_VSEKH_VALUE' => $arResult['ar_brand']['NAME'],
//            '!PROPERTY_NE_POKAZYVAT_NIGDE' => 'Y',
//            '!IBLOCK_SECTION_ID' => $accessoriesSections,
//        );
//        $arOrder = Array('SORT' => 'ASC');
//        $arSelect = Array('ID', 'NAME', 'PROPERTY_KOLLEKTSIYA_MNOZHESTVENNOE_OBSHCHEE_DLYA_VSEKH', 'PROPERTY_PROIZVODITEL_OBSHCHEE_DLYA_VSEKH');
//        $rsCollectionProducts = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
//        while ($arCollectionProduct = $rsCollectionProducts->Fetch()) {
//            $arCollectionProducts[] = $arCollectionProduct;
//        }
//
//        foreach ($arCollectionProducts as $arProduct) {
//            if(isset($arResult['COLLECTIONS'][$arProduct['PROPERTY_KOLLEKTSIYA_MNOZHESTVENNOE_OBSHCHEE_DLYA_VSEKH_VALUE']])) {
//                $arResult['COLLECTIONS'][$arProduct['PROPERTY_KOLLEKTSIYA_MNOZHESTVENNOE_OBSHCHEE_DLYA_VSEKH_VALUE']]['PRODUCTS'][] = $arProduct['NAME'];
//            }
//        }
//
//
//    }
//
//    $this->setResultCacheKeys(array('ar_brand'));
//    $this->IncludeComponentTemplate();
//}
