function confirmDelete(productId) {
    document.getElementById('delete-product-id').value = productId;
    document.getElementById('delete-product-modal').checked = true;
}

document.addEventListener('DOMContentLoaded', function() {
    // Ajouter des écouteurs d'événements uniquement aux boutons de suppression (classe btn-error)
    const deleteButtons = document.querySelectorAll('.btn-error[data-product-id]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            confirmDelete(productId);
        });
    });
}); 