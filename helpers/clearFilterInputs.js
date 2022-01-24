const clearFilterInputs = () => {
  const sortDate = document.querySelector("#sort-date");
  sortDate.value = "asc";

  const sortCategory = document.querySelector("#sort-category");
  sortCategory.value = "all";
};
