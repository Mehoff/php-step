let out;
document.addEventListener("DOMContentLoaded", (e) => {
  out = document.querySelector("#out");
  if (!out) alert("out is undefined!");

  getPictures();
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

      for (const picture of res.data.pictures) addPictureToGallery(picture);
    });
};

// Creates new picture, and returns raw picture data
// Convert it to picture html element and add to gallery-items without reloading
const sendPOST = (files, title, description) => {
  var data = new FormData();
  data.append("pictureFile", files);
  data.append("title", title);
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
