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

    <form method="POST">
        <button>POST</button>
    </form>

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