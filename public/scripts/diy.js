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

document.addEventListener("DOMContentLoaded", function () {
    // Éléments DOM
    const productsContainer = document.getElementById("products-container");
    const productCards = document.querySelectorAll(".product-card");
    const categoryFilters = document.querySelectorAll('input[name="category"]');
    const applyFiltersButton = document.getElementById("apply-filters");
    const noProductsMessage = document.getElementById("no-products-message");
    const resetFiltersButton = document.getElementById("reset-filters");
    const sortOptions = document.getElementById("sort-options");

    // Mise en page (grid/list)
    const gridViewButton = document.getElementById("grid-view");
    const listViewButton = document.getElementById("list-view");

    if (gridViewButton) {
        gridViewButton.addEventListener("click", () => {
            productsContainer.classList.remove("flex", "flex-col");
            productsContainer.classList.add("grid", "grid-cols-1", "md:grid-cols-2", "lg:grid-cols-3", "gap-6");
        });
    }

    if (listViewButton) {
        listViewButton.addEventListener("click", () => {
            productsContainer.classList.remove("grid", "grid-cols-1", "md:grid-cols-2", "lg:grid-cols-3", "gap-6");
            productsContainer.classList.add("flex", "flex-col", "gap-4");
        });
    }

    // Fonction pour appliquer les filtres
    function applyFilters() {
        let selectedCategory = document.querySelector('input[name="category"]:checked').value;
        let visibleCount = 0;

        productCards.forEach((card) => {
            const cardCategory = card.dataset.category;
            let shouldShow = selectedCategory === "all" || cardCategory.includes(selectedCategory);

            if (shouldShow) {
                card.classList.remove("hidden");
                visibleCount++;
            } else {
                card.classList.add("hidden");
            }
        });

        // Afficher un message si aucun produit ne correspond
        if (visibleCount === 0) {
            noProductsMessage.classList.remove("hidden");
        } else {
            noProductsMessage.classList.add("hidden");
        }
    }

    // Écouter le clic sur le bouton de filtre
    if (applyFiltersButton) {
        applyFiltersButton.addEventListener("click", applyFilters);
    }

    // Réinitialiser les filtres
    if (resetFiltersButton) {
        resetFiltersButton.addEventListener("click", () => {
            document.getElementById("category-all").checked = true;
            applyFilters();
        });
    }

    // Tri des produits
    if (sortOptions) {
        sortOptions.addEventListener("change", () => {
            const sortValue = sortOptions.value;
            const productsArray = Array.from(productCards);

            productsArray.sort((a, b) => {
                switch (sortValue) {
                    case "price-asc":
                        return parseFloat(a.dataset.price || 0) - parseFloat(b.dataset.price || 0);
                    case "price-desc":
                        return parseFloat(b.dataset.price || 0) - parseFloat(a.dataset.price || 0);
                    case "name-asc":
                        return a.dataset.name.localeCompare(b.dataset.name);
                    case "name-desc":
                        return b.dataset.name.localeCompare(a.dataset.name);
                    default:
                        return 0;
                }
            });

            // Réordonner les produits dans le container
            productsArray.forEach((card) => {
                productsContainer.appendChild(card);
            });
        });
    }
});
