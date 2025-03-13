const products = document.querySelectorAll("[data-category]");
const filters = document.querySelectorAll(".category-filter");

filters.forEach((filter) => {
    filter.addEventListener("click", () => {
        const category = filter.value;
        console.log(category);
        products.forEach((product) => {
            if (product.dataset.category === category) {
                product.classList.remove("hidden");
            } else {
                product.classList.add("hidden");
            }
        });
    });
});
