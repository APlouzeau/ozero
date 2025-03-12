// Pour les boutons d'ajout
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".add-one").forEach((addOneBtn) => {
        addOneBtn.addEventListener("click", function () {
            const row = this.closest("tr");
            const productId = row.querySelector(".productId").value;
            const product = row.querySelector(".product").value;
            const price = row.querySelector(".price").value;

            const quantityDisplayP = this.parentElement.querySelector(".quantityShow");
            const quantityInput = row.querySelector(".quantity");

            let currentQuantity = parseInt(quantityInput.value);
            let newQuantity = currentQuantity + 1;

            quantityInput.value = newQuantity;
            quantityDisplayP.textContent = newQuantity;

            addProduct(product, productId, price, newQuantity);
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".remove-one").forEach((removeOneBtn) => {
        removeOneBtn.addEventListener("click", function () {
            const row = this.closest("tr");
            const productId = row.querySelector(".productId").value;
            const product = row.querySelector(".product").value;
            const price = row.querySelector(".price").value;

            const quantityDisplayP = this.parentElement.querySelector(".quantityShow");
            const quantityInput = row.querySelector(".quantity");

            let currentQuantity = parseInt(quantityInput.value);
            let newQuantity = currentQuantity - 1;

            quantityInput.value = newQuantity;

            quantityDisplayP.textContent = newQuantity;

            removeOneProduct(product, productId, price, newQuantity);
        });
    });
});

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
        console.log(data);
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
        console.log(data);
    } catch (error) {
        console.error("Error:", error);
    }
}
