let out;
document.addEventListener("DOMContentLoaded", (e) => {
  out = document.querySelector("#out");
  if (!out) alert("out is undefined!");

  getPictures();
  // Make a request to database and get raw pictures data
  // Convert raw pictures data to html elements and put it in 'gallery' section
});

document.addEventListener("submit", (e) => submitHandler(e));

const getPictures = (filters = { category: "any", date: "asc" }) => {
  fetch(`./api/gallery?category=${filters.category}&date=${filters.date}`, {
    method: "GET",
  })
    .then((r) => r.json())
    .then((res) => {
      if (res.error) {
        console.error(res.error);
        return;
      }

      console.log("API Response: ", res);

      for (const picture of res.data.pictures) {
        addPictureToGallery(picture);
      }
    });
};

const addPictureToGallery = (picture) => {
  const gallery = document.querySelector("#gallery-items");
  if (!gallery) throw new Error("Gallery element is not defined");
  try {
    const pictureElement = createPictureElement(picture);
    gallery.appendChild(pictureElement);
  } catch (err) {
    console.error(err);
    return;
  }
};

const createPictureElement = (picture) => {
  const article = document.createElement("article");
  article.className = "gallery-item";
  article.style.backgroundColor = getBackgroundColor();

  const image = document.createElement("img");
  image.src = `./uploads/${picture.filename}`;

  const title = document.createElement("h3");
  title.innerText = picture.title;

  const description = document.createElement("h4");
  description.innerText = picture.description;

  article.appendChild(image);
  article.appendChild(title);
  article.appendChild(description);

  return article;
};

const getBackgroundColor = () => {
  const colors = [
    "violet",
    "salmon",
    "pink",
    "wheat",
    "lightblue",
    "lightgreen",
    "orange",
  ];

  return colors[Math.floor(Math.random() * colors.length)];
};

const sendPOST = (files, description) => {
  var data = new FormData();
  data.append("pictureFile", files);
  data.append("description", description);

  fetch("./api/gallery", {
    method: "POST",
    body: data,
  })
    .then((r) => r.text())
    .then((data) => (out.innerText = data));
};

const sendGET = () => {
  fetch("./api/gallery", {
    method: "GET",
  })
    .then((r) => r.text())
    .then((data) => (out.innerText = data));
};

const submitHandler = (e) => {
  e.preventDefault();
  const reqMethod = e.target.getAttribute("method");

  if (!reqMethod) throw "Unknown request method!";

  switch (reqMethod.toUpperCase()) {
    case "POST":
      const files = e.target[0].files;
      const description = e.target[1].value;
      if (files.length < 1 && description.length < 1) {
        outputError("Input data validation failed!");
        return;
      }
      sendPOST(files, description);
      break;
    case "GET":
      sendGET();
      break;
    default:
      throw "Unrecognized request method";
  }
};

const outputError = (message = "Error") => (out.innerText = message);
