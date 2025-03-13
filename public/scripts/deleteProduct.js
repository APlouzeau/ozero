function confirmDelete(productId) {
    document.getElementById('delete-product-id').value = productId;
    document.getElementById('delete-product-modal').checked = true;
}

document.addEventListener('DOMContentLoaded', function() {
    // Ajouter des écouteurs d'événements à tous les boutons de suppression
    const deleteButtons = document.querySelectorAll('[data-product-id]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            confirmDelete(productId);
        });
    });
}); 