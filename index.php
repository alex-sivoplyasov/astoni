<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $USER;
?>

<main class="content">
    <?$APPLICATION->IncludeComponent(
        "alex:tasks",
        "main",
        [
            "CACHE_TYPE" => "Y",
            "CACHE_TIME" => "86400"
        ],
        false
    );?>
</main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
