const createCategoryElement = (category) => {
    const option = document.createElement('option');
    option.setAttribute('value', category.id);
    option.textContent = category.name;

    return option;
}