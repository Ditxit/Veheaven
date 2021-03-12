<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php if (isset($PAGE_NAME) && in_array($PAGE_NAME, ['Login','Register'])) { ?>
    <!-- Handle the bugs caused by cached history pages in browser by reloading -->
    <script type="text/javascript" src="../js/Reload.js"></script>
    <script> Reload.ifPageLoadedFromHistory();</script>
<?php } ?>

<title>
    <?php if (isset($PAGE_NAME)) { ?>
        <?=$PAGE_NAME?> - Veheaven
    <?php } ?>
</title>

<!-- CSS Style Links -->
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/custom.css">

<!-- JS Script Links -->
<script type="text/javascript" src="../js/script.js"></script>
<script type="text/javascript" src="../js/Cookie.js"></script>
<script type="text/javascript" src="../js/LocalStorage.js"></script>