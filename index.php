<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css">
    <title>Hello, PHP Rest API!</title>
</head>

<body>
    <ul id="navigation-list">
        <li><span><b>Gallery-PHP</b></span>
        <li><a href="./about.php">About</a></li>
        <li><a href="./privacy.php">Privacy</a></li>
    </ul>

    <div class="utils">
        <div class="utils-item">
            <form method="POST" enctype="multipart/form-data">
                <span><b>Загрузка картинки</b></span><br />
                <label name="pictureFile">Выбрать картинку</label><br />
                <input type="file" accept="image/*" id="pictureFile" name="pictureFile" required /><br />
                <br />

                <label name="title">Дайте выбранной картинке название</label><br />
                <input type="text" id="title" name="title" required /><br />
                <br />

                <label name="description">Опишите что изображено на картинке</label><br />
                <input type="text" id="description" name="description" required /><br />
                <button id="btn-submit">Отправить</button>
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
            <!-- Загружать категории сюда -->
            <select name="sort-category" id="sort-category">
                <option value="all">Все</option>
            </select>
            <div id="add-category-container">
                <span id="add-close-category-button">Добавить категорию</span>
            </div>
        </div>
    </div>

    <div id="gallery">
        <section id="gallery-items"></section>
    </div>

    <p id="out"></p>

    <footer style="text-align: center">
        <?php
        echo "Mehoff &copy; " . date("y");
        ?>
    </footer>

    <script src="helpers/toggleAddCloseCategory.js"></script>
    <script src="helpers/createCategoryElement.js"></script>
    <script src="helpers/addCategoriesToCategoryList.js"></script>
    <script src="helpers/createPictureElement.js"></script>
    <script src="helpers/addPictureToGallery.js"></script>
    <script src="helpers/getArticleBackgroundColor.js"></script>
    <script src="index.js"></script>
</body>


</html>