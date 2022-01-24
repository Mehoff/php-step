let ADD_CLOSE_CATEGORY_SHOWN = false;
let PAGE = 0;
let out;

const pageNumberElement = document.querySelector("#page-num");
if (!pageNumberElement) throw new Error("Page number element is not defined");

const pagePrevElement = document.querySelector("#page-prev");
if (!pagePrevElement) throw new Error("Page number element is not defined");

const pageNextElement = document.querySelector("#page-next");
if (!pageNextElement) throw new Error("Page number element is not defined");

const sortCategory = document.querySelector("#sort-category");
if (!sortCategory) throw new Error("Sort category select is undefined");

const sortDate = document.querySelector("#sort-date");
if (!sortDate) throw new Error("Sort date select is undefined");

const submitButton = document.querySelector("#btn-submit");
if (!submitButton) throw new Error("Submit button is undefined");

document.addEventListener("DOMContentLoaded", (e) => {
  out = document.querySelector("#out");
  if (!out) alert("out is undefined!");

  getPictures();
  getCategories();
});

submitButton.addEventListener("click", (e) => {
  e.preventDefault();

  const fileInput = document.querySelector("#pictureFile");
  if (!fileInput) throw new Error("FileInput is undefined");

  const title = document.querySelector("#title").value;
  const description = document.querySelector("#description").value;
  const category = document.querySelector("#create-picture-category").value;

  if (!title) throw new Error("Title is undefined");
  if (!description) throw new Error("Description is undefined");
  if (!category) throw new Error("Category is undefined");

  const file = fileInput.files[0];
  if (!file) throw new Error("File is undefined");

  const formData = new FormData();
  formData.append("pictureFile", file);
  formData.append("title", title.trim());
  formData.append("description", description.trim());
  formData.append("category", category);

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
        clearCreatePictureInputs();
      } else {
        alert(data.message);
      }
    });
});

const addCloseCategoryButton = document.querySelector(
  "#add-close-category-button"
);
if (!addCloseCategoryButton)
  throw new Error("Add/Close category button is undefined");

addCloseCategoryButton.addEventListener("click", (e) => {
  e.preventDefault(); // ?
  toggleAddCloseCategory(ADD_CLOSE_CATEGORY_SHOWN);
});

const getPicturesIncludeFilters = (e) => {
  const categoryValue = sortCategory.value;
  if (!categoryValue) throw new Error("Category value is not defined");

  const dateValue = sortDate.value;
  if (!dateValue) throw new Error("Date value is not defined");

  getPictures({ category: categoryValue, date: dateValue, page: PAGE }, true);
};

const getPictures = (
  filters = { category: "all", date: "asc", page: PAGE },
  clear = false
) => {
  fetch(
    `./api/gallery?page=${filters.page}&category=${filters.category}&date=${filters.date}`,
    {
      method: "GET",
    }
  )
    .then((r) => r.json())
    .then((res) => {
      if (res.error) {
        console.error(res.error);
        return;
      }

      if (clear) clearGallery();

      if (res.data.pictures.length === 0 || !res.data.pictures) {
        alert("Данных подходящих под ваш запрос - нет");
        setPageNumber(0);
        clearFilterInputs();
        getPicturesIncludeFilters();
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

const changeToPrevPage = (e) => {
  if (PAGE === 0) throw new Error("Can`t change page number below 0");
  decrementPageNumber();
  getPicturesIncludeFilters();
};

// If next page returns empty -> change page back
const changeToNextPage = (e) => {
  incrementPageNumber();
  getPicturesIncludeFilters();
};

const clearGallery = () => {
  const galleryItems = document.querySelector("#gallery-items");
  if (!galleryItems) throw new Error("Gallery items is not defined");

  galleryItems.innerHTML = "";
};

const outputError = (message = "Undefined error") => (out.innerText = message);

const incrementPageNumber = () => {
  PAGE += 1;
  pageNumberElement.textContent = PAGE;
};
const decrementPageNumber = () => {
  PAGE -= 1;
  pageNumberElement.textContent = PAGE;
};

const setPageNumber = (num = 1) => {
  PAGE = num;
  pageNumberElement.textContent = PAGE;
};

sortCategory.addEventListener("change", (e) => {
  setPageNumber(0);
  getPicturesIncludeFilters();
});
sortDate.addEventListener("change", (e) => {
  setPageNumber(0);
  getPicturesIncludeFilters();
});

pagePrevElement.addEventListener("click", changeToPrevPage);
pageNextElement.addEventListener("click", changeToNextPage);
