function confirmDelete(categoryId) {
    document.getElementById('delete-category-id').value = categoryId;
    document.getElementById('delete-category-modal').checked = true;
}

document.addEventListener('DOMContentLoaded', function() {
    // Ajouter des écouteurs d'événements à tous les boutons de suppression
    const deleteButtons = document.querySelectorAll('[data-category-id]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-category-id');
            confirmDelete(categoryId);
        });
    });
}); 