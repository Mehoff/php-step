let out;
document.addEventListener("DOMContentLoaded", (e) => {
  out = document.querySelector("#out");
  if (!out) alert("out is undefined!");
});

document.addEventListener("submit", (e) => submitHandler(e));

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
