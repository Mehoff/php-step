// currentState (state of util in the moment of click)
const toggleAddCloseCategory = (currentState) => {
  currentState ? closeAddCategory() : showAddCategory();
};

const showAddCategory = () => {
  ADD_CLOSE_CATEGORY_SHOWN = true;

  const addCategoryContainer = document.querySelector(
    "#add-category-container"
  );

  const addCloseCategoryButton = document.querySelector(
    "#add-close-category-button"
  );

  const popupContainer = document.createElement("div");
  popupContainer.setAttribute("id", "popup-container");

  const br1 = document.createElement("br");
  const br2 = document.createElement("br");
  const br3 = document.createElement("br");

  const categoryNameInputLabel = document.createElement("label");
  categoryNameInputLabel.setAttribute("id", "categoryNameLabel");
  categoryNameInputLabel.setAttribute("name", "categoryNameLabel");
  categoryNameInputLabel.setAttribute("for", "categoryName");
  categoryNameInputLabel.textContent = "Имя новой категории";

  const categoryNameInput = document.createElement("input");
  categoryNameInput.setAttribute("id", "categoryName");
  categoryNameInput.setAttribute("name", "categoryName");
  categoryNameInput.setAttribute("type", "text");

  const addNewCategoryButton = document.createElement("button");
  addNewCategoryButton.setAttribute("id", "addCategory");
  addNewCategoryButton.setAttribute("name", "addCategory");
  addNewCategoryButton.textContent = "Добавить категорию";
  addNewCategoryButton.addEventListener("click", addCategory);

  popupContainer.appendChild(categoryNameInputLabel);
  popupContainer.appendChild(br1);
  popupContainer.appendChild(categoryNameInput);
  popupContainer.appendChild(br2);
  popupContainer.appendChild(addNewCategoryButton);
  popupContainer.appendChild(br3);

  addCategoryContainer.insertBefore(popupContainer, addCloseCategoryButton);

  addCloseCategoryButton.textContent = "Закрыть";
};

const closeAddCategory = () => {
  ADD_CLOSE_CATEGORY_SHOWN = false;

  const popupContainerToDelete = document.querySelector("#popup-container");
  if (!popupContainerToDelete) throw new Error("Failed to get popup container");

  popupContainerToDelete.remove();

  addCloseCategoryButton.textContent = "Добавить категорию";
};

const addCategory = (e) => {
  // Try add new category

  // Parse input
  // Check if category with such name exists
  // Insert if not
  // closeAddCategory()

  const name = document.querySelector("#categoryName").value.trim();
  if (!name) throw new Error(`Name is incorrect to make a request: '${name}'`);

  // Returns data.exists = true/false
  fetch(`./api/gallery/categories?name=${name}`, {
    method: "GET",
  })
    .then((r) => r.json())
    .then((res) => {
      console.log(res);
      if (res.error) {
        alert(res.error);
        return;
      }
      //   if (res.data.exists) {
      //     // POST to create new category
      //     const formData = new FormData();
      //     formData.append(name);

      //     fetch("./api/gallery/categories", {
      //       method: "POST",
      //       body: formData,
      //     })
      //       .then((r) => r.json())
      //       .then((res) => {
      //         if (res.error) {
      //           alert(res.error);
      //           return;
      //         }

      //         addCategoriesToCategoryList(res.data.categories);
      //         closeAddCategory();
      //       });
      //   }
    });
};
