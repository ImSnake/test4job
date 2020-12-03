<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/styles/normalize.css">
    <link rel="stylesheet" href="/styles/style-main.css">
    <script type="text/javascript" src="/vendor/js/jq.js"></script>
    <script type="text/javascript" src="/js/js.js"></script>
</head>

<body>
<div class="container">

    <div class="content">  <!--!!! Начало документа с динамическим контентом -->

        <header class="header">
            <div class="content-box">
                <div class="header-right">BeeJee Company Task Manager</div>
            </div>
        </header>

      <?= $contentPHP ?>

    </div> <!--!!! Конец документа с динамическим контентом -->

    <footer class="footer">
        <div class="content-box">
            <div class="footer-left">
                <div><span> &copy;&nbsp;<?= date('Y')?> PULIKOVA YULIYA </span></div>
            </div>
        </div>
    </footer>

</div>
</body>
</html>
