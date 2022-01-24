const addCategoriesToCategoryList = (categories, clear = false) => {
  const categoriesElement = document.querySelector("#sort-category");
  if (!categoriesElement) throw new Error("Failed to get categories element");

  if (clear) categoriesElement.innerHTML = "";

  for (const category of categories) {
    const categoryElement = createCategoryElement(category);
    categoriesElement.appendChild(categoryElement);
  }
};
