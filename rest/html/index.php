<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello, PHP Rest API!</title>
</head>

<body>
    <ul>
        <li><a href="./about.php">About</a></li>
        <li><a href="./privacy.php">Privacy</a></li>
    </ul>

    <form method="GET">
        <button>GET</button>
    </form>

    <div style="padding: 10px; border: 1px solid black">
        <form method="POST">
            <label name="pictureFile">Выберите картинку для загрузки</label><br />
            <input type="file" name="pictureFile" /><br />
            <br />
            <label name="description">Опишите картинку:</label><br />
            <input type="text" name="description" /><br />
            <button>Отправить</button>
        </form>
    </div>

    <form method="PATCH">
        <button>PATCH</button>
    </form>

    <form method="DELETE">
        <button>DELETE</button>
    </form>

    <script src="index.js"></script>


    <p id="out"></p>


    <footer>
        <?php
        echo "&copy; " . date("y");
        ?>
    </footer>

</body>


</html>