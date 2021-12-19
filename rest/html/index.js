let out;
document.addEventListener("DOMContentLoaded", (e) => {
  out = document.querySelector("#out");
  if (!out) alert("out is undefined!");
});

document.addEventListener("submit", (e) => submitHandler(e));

const sendPOST = () => {
  fetch("/api", {
    method: "POST",
    body: JSON.stringify({ x: 10, y: 20 }),
    headers: {
      "content-type": "application/x-www-form-urlencoded",
    },
  })
    .then((r) => r.text())
    .then((data) => (out.innerText = data));
};

const sendGET = () => {
  fetch("/api?x=10&y=20", {
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
      sendPOST();
      break;
    case "GET":
      sendGET();
      break;

    default:
      throw "Unrecognized request method";
  }
};
