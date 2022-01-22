const createPictureElement = (picture) => {
  const article = document.createElement("article");
  article.className = "gallery-item";
  article.style.backgroundColor = getArticleBackgroundColor();

  const image = document.createElement("img");
  const imageUrl = `./uploads/${picture.filename}`;
  image.src = imageUrl;

  const title = document.createElement("h3");
  title.innerText = picture.title;

  const description = document.createElement("p");
  description.innerText = picture.description;

  article.appendChild(image);
  article.appendChild(title);
  article.appendChild(description);

  article.onclick = () => {
    window.open(imageUrl, "_blank").focus();
  };

  return article;
};
