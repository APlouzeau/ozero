const view = document.querySelector(".view");
const grid = document.querySelector(".gridButton");
const list = document.querySelector(".listButton");
let selectedCategory = [];
const category = document.querySelectorAll(".category");
let productsByCategory = document.querySelectorAll(".categoryId");
let filterCategory = document.querySelectorAll(".filters");

grid.addEventListener("click", () => {
    view.classList.add("grid");
    view.classList.remove("list");
});

list.addEventListener("click", () => {
    view.classList.add("list");
    view.classList.remove("grid");
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
