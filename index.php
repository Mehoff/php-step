<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="./styles/style.css"> -->
    <link rel="stylesheet" href="./styles/style.css">
    <title>Hello, PHP Rest API!</title>
</head>

<body>
    <ul id="navigation-list">
        <li><span><b>Gallery-PHP</b></span>
        <li><a href="./about.php">About</a></li>
        <li><a href="./privacy.php">Privacy</a></li>
    </ul>

    <form method="GET">
        <button>GET</button>
    </form>


    <div class="utils">
        <div class="utils-item">
            <form method="POST">
                <span><b>Загрузка картинки</b></span><br />
                <label name="pictureFile">Выберите картинку для загрузки</label><br />
                <input type="file" accept="image/*" name="pictureFile" /><br />
                <br />
                <label name="description">Опишите картинку:</label><br />
                <input type="text" name="description" /><br />
                <button>Отправить</button>
            </form>
        </div>

        <div class="utils-item" id="gallery-filters">
            <span><b>Фильтры</b></span><br />
            <label for="sort-date">Дата</label><br />
            <select name="sort-date" id="sort-date">
                <option value="asc">Сначала старые</option>
                <option value="desc">Сначала новые</option>
            </select><br />
            <label for="sort-category">Категория</label><br />
            <select name="sort-category" id="sort-category">
                <option value="*">Любая</option>
                <option value="cats">Коты</option>
                <option value="food">Еда</option>
            </select>

        </div>
    </div>

    <div id="gallery">
        <section id="gallery-items">
            <article style="background-color: violet" class="gallery-item">
                <img src="./uploads/no-image.png">
                <h3>Dummy gallery item</h3>
                <h4>Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores ipsa architecto ut veniam modi harum provident illum non voluptatem magni fuga, quaerat blanditiis id aperiam eum vitae quo voluptatibus odio.</h4>
            </article>
            <article style="background-color: salmon" class="gallery-item">
                <img src="./uploads/no-image.png">
                <h3>Dummy gallery item</h3>
                <h4>Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores ipsa architecto ut veniam modi harum provident illum non voluptatem magni fuga, quaerat blanditiis id aperiam eum vitae quo voluptatibus odio.</h4>
            </article>
            <article style="background-color: wheat" class="gallery-item">
                <img src="./uploads/no-image.png">
                <h3>Dummy gallery item</h3>
                <h4>Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores ipsa architecto ut veniam modi harum provident illum non voluptatem magni fuga, quaerat blanditiis id aperiam eum vitae quo voluptatibus odio.</h4>
            </article>
            <article style="background-color: lightgreen" class="gallery-item">
                <img src="./uploads/no-image.png">
                <h3>Dummy gallery item</h3>
                <h4>Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores ipsa architecto ut veniam modi harum provident illum non voluptatem magni fuga, quaerat blanditiis id aperiam eum vitae quo voluptatibus odio.</h4>
            </article>
        </section>
    </div>

    <script src="index.js"></script>

    <p id="out"></p>

    <footer style="text-align: center">
        <?php
        echo "&copy; " . date("y");
        ?>
    </footer>

</body>


</html>