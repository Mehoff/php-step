const addCategoriesToCategoryList = (categories) => {
  const categoriesElement = document.querySelector("#sort-category");
  if (!categoriesElement) throw new Error("Failed to get categories element");

  for (const category of categories) {
    const categoryElement = createCategoryElement(category);
    categoriesElement.appendChild(categoryElement);
  }
};
