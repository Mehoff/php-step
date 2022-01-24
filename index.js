let out;
document.addEventListener("DOMContentLoaded", (e) => {
  out = document.querySelector("#out");
  if (!out) alert("out is undefined!");

  getPictures();
  getCategories();
});

// uncomment
// document.addEventListener("submit", (e) => submitHandler(e));

const submitButton = document.querySelector("#btn-submit");
if (!submitButton) throw new Error("Submit button is undefined");

submitButton.addEventListener("click", (e) => {
  // Trying not reloading page
  e.preventDefault();

  const fileInput = document.querySelector("#pictureFile");
  if (!fileInput) throw new Error("FileInput is undefined");

  const title = document.querySelector("#title").value;
  const description = document.querySelector("#description").value;

  if (!title) throw new Error("Title is undefined");
  if (!description) throw new Error("Description is undefined");

  const file = fileInput.files[0];
  if (!file) throw new Error("File is undefined");

  const formData = new FormData();
  formData.append("pictureFile", file);
  formData.append("title", title.trim());
  formData.append("description", description.trim());

  const url = "./gallery_api.php";
  const request = new Request(url, {
    method: "POST",
    body: formData,
  });

  fetch(request)
    .then((res) => res.json())
    .then((data) => {
      if (data.code === 200) {
        addPictureToGallery(data);
      } else {
        alert(data.message);
      }
    });
});

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

const getCategories = () => {
  fetch("./api/gallery/categories", { method: "GET" })
    .then((r) => r.json())
    .then((res) => {
      if (res.error) {
        alert(res.error);
        return;
      }

      if (res.data.categories) addCategoriesToCategoryList(res.data.categories);
      else throw new Error("Failed to load categories");
    });
};

const postPicture = (files, title, description) => {
  var data = new FormData();

  data.append("pictureFile", files);
  data.append("title", title);
  data.append("description", description);

  // fetch("./api/gallery", {
  fetch("./gallery_api.php", {
    method: "POST",
    headers: {},
    body: data,
  })
    .then((r) => r.text())
    .then((data) => {
      console.log(data);
      //console.log(text);

      //const pictureFilename = generateUniqueFilename(picture);
      //console.log("pictureFilename", pictureFilename);
      // out.innerText = JSON.stringify(pictureData);
    })
    .catch((err) => console.error("[ERROR] postPicture", err));
};

// const submitHandler = (e) => {
//   //e.preventDefault();
//   const reqMethod = e.target.getAttribute("method");

//   if (!reqMethod) throw "Unknown request method!";

//   // Added title field - refactor
//   switch (reqMethod.toUpperCase()) {
//     case "POST":
//       const files = e.target[0].files;
//       const title = e.target[1].value;
//       const description = e.target[2].value;

//       if (files.length < 1 || description.length < 1 || title.length < 1) {
//         outputError("Введите данные во все обязательные поля!");
//         return;
//       }
//       postPicture(files, title, description);
//       break;
//     case "GET":
//       sendGET();
//       break;
//     default:
//       throw "Unknown request method!";
//   }
// };

const outputError = (message = "Undefined error") => (out.innerText = message);
