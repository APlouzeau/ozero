// Pour les boutons d'ajout
document.addEventListener("DOMContentLoaded", function () {
    // Initialiser le total au chargement
    updateCartTotals();

    document.querySelectorAll(".add-one").forEach((addOneBtn) => {
        addOneBtn.addEventListener("click", function () {
            const row = this.closest("tr");
            const productId = row.querySelector(".productId").value;
            const product = row.querySelector(".product").value;
            const price = parseFloat(row.querySelector(".price").value);

            const quantityDisplayP = this.parentElement.querySelector(".quantityShow");
            const quantityInput = row.querySelector(".quantity");

            let currentQuantity = parseInt(quantityInput.value);
            let newQuantity = currentQuantity + 1;

            quantityInput.value = newQuantity;
            quantityDisplayP.textContent = newQuantity;

            addProduct(product, productId, price, newQuantity);
        });
    });

    document.querySelectorAll(".remove-one").forEach((removeOneBtn) => {
        removeOneBtn.addEventListener("click", function () {
            const row = this.closest("tr");
            const productId = row.querySelector(".productId").value;
            const product = row.querySelector(".product").value;
            const price = parseFloat(row.querySelector(".price").value);

            const quantityDisplayP = this.parentElement.querySelector(".quantityShow");
            const quantityInput = row.querySelector(".quantity");

            let currentQuantity = parseInt(quantityInput.value);
            let newQuantity = currentQuantity - 1;

            if (newQuantity <= 0) {
                row.remove();
                const remainingRows = document.querySelectorAll("tbody tr").length;
                if (remainingRows === 0) {
                    showEmptyCart();
                }
            } else {
                quantityInput.value = newQuantity;
                quantityDisplayP.textContent = newQuantity;
            }

            removeOneProduct(product, productId, price, newQuantity);
        });
    });
});

function showEmptyCart() {
    const tableContainer = document.querySelector(".bg-white.shadow-sm");
    if (tableContainer) {
        tableContainer.innerHTML = `
            <div class="text-center py-12">
                <p class="text-gray-500 text-xl">Votre panier est vide</p>
                <a href="/" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-focus">
                    Continuer vos achats
                </a>
            </div>
        `;
    }
    
    // Cacher la section du total
    const totalSection = document.querySelector('.bg-white.px-4.sm\\:px-6.py-6.sm\\:py-8');
    if (totalSection) {
        totalSection.style.display = 'none';
    }
}

async function addProduct(product, productId, price, setQuantity) {
    try {
        const response = await fetch("/panier/addOne", {
            method: "POST",
            body: JSON.stringify({
                productId: productId,
                product: product,
                price: price,
                quantity: setQuantity,
            }),
            headers: {
                "Content-Type": "application/json",
            },
        });
        const data = await response.json();
        if (data.success && data.totalAmount !== undefined) {
            updateCartTotals();
        }
    } catch (error) {
        console.error("Error:", error);
    }
}

async function removeOneProduct(product, productId, price, setQuantity) {
    try {
        const response = await fetch("/panier/removeOne", {
            method: "POST",
            body: JSON.stringify({
                productId: productId,
                product: product,
                price: price,
                quantity: setQuantity,
            }),
            headers: {
                "Content-Type": "application/json",
            },
        });
        const data = await response.json();
        
        if (data.success && data.totalAmount !== undefined) {
            updateCartTotals();
        }
    } catch (error) {
        console.error("Error:", error);
    }
}

function updateCartTotals() {
    // Calculer le total à partir des lignes du panier
    let totalAmount = 0;
    document.querySelectorAll("tbody tr").forEach(row => {
        const price = parseFloat(row.querySelector(".price").value);
        const quantity = parseInt(row.querySelector(".quantity").value);
        totalAmount += price * quantity;
    });

    const formattedTotal = new Intl.NumberFormat('fr-FR', { 
        minimumFractionDigits: 2, 
        maximumFractionDigits: 2 
    }).format(totalAmount);
    
    // Mettre à jour le sous-total
    const subTotalElement = document.querySelector('.text-lg.font-medium.text-gray-900');
    if (subTotalElement) {
        subTotalElement.textContent = formattedTotal + ' €';
    }
    
    // Mettre à jour le total TTC
    const totalElement = document.querySelector('.text-2xl.font-bold.text-primary');
    if (totalElement) {
        totalElement.textContent = formattedTotal + ' €';
    }
    
    // Mettre à jour l'input hidden
    const totalInput = document.querySelector('#totalAmount');
    if (totalInput) {
        totalInput.value = totalAmount;
    }

    // Afficher/masquer la section du total en fonction du montant
    const totalSection = document.querySelector('.bg-white.px-4.sm\\:px-6.py-6.sm\\:py-8');
    if (totalSection) {
        totalSection.style.display = totalAmount > 0 ? 'block' : 'none';
    }
}
