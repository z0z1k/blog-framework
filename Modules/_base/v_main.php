<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>
</head>
<body>
    <header class="header">
        Header
    </header>
    
    <main class="main">
        <hr>
        Menu
        <a href="<?=BASE_URL?>">Home</a>
        <a href="<?=BASE_URL?>article/1">Art 1</a>
        <a href="<?=BASE_URL?>article/2">Art 2</a>
        <hr>
        <?=$content?>
    </main>

    <footer class="footer">
        Footer
    </footer>
</body>
</html>