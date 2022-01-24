const clearCreatePictureInputs = () => {
  const pictureFile = document.querySelector("#pictureFile");
  pictureFile.value = null;

  const title = document.querySelector("#title");
  title.value = "";

  const select = document.querySelector("#create-picture-category");
  select.value = "all";

  const description = document.querySelector("#description");
  description.value = "";
};
