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
