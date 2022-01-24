const addCategoriesToCategoryList = (categories, clear = false) => {
  const sortCategoriesElement = document.querySelector("#sort-category");
  if (!sortCategoriesElement)
    throw new Error("Failed to get sort categories element");

  const createPictureCategoriesElement = document.querySelector(
    "#create-picture-category"
  );
  if (!createPictureCategoriesElement)
    throw new Error("Failed to get create picture categories element");

  if (clear) {
    sortCategoriesElement.innerHTML = "";
    createPictureCategoriesElement = "";
  }

  for (const category of categories) {
    const sortCategoryElement = createCategoryElement(category);
    const createPictureCategoryElement = createCategoryElement(category);

    sortCategoriesElement.appendChild(sortCategoryElement);
    createPictureCategoriesElement.appendChild(createPictureCategoryElement);
  }
};
