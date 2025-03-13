const view = document.querySelector(".view");
const grid = document.querySelector(".gridButton");
const list = document.querySelector(".listButton");
const rangePrice = document.querySelector("#rangePrice");
let selectedCategory = [];
const category = document.querySelectorAll(".category");
let productsByCategory = document.querySelectorAll(".categoryId");
let filterCategory = document.querySelectorAll(".filters");
const fullCategoryBtn = document.querySelector(".fullCategoryBtn");

grid.addEventListener("click", () => {
    view.classList.add("grid");
    view.classList.remove("list");
});

list.addEventListener("click", () => {
    view.classList.add("list");
    view.classList.remove("grid");
});

rangePrice.addEventListener("input", () => {
    const value = rangePrice.value;
    const price = document.querySelector(".price");
    console.log(value);
});

category.forEach((item) => {
    item.addEventListener("click", () => {
        filterCategory.forEach((product) => {
            if (product.classList.contains("filteredCategory" + item.id)) {
                product.classList.remove("hidden");
            } else product.classList.add("hidden");
        });
    });
});

fullCategoryBtn.addEventListener("click", () => {
    filterCategory.forEach((product) => {
        product.classList.remove("hidden");
    });
});
