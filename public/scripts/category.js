class CategoryManager {
  constructor() {
    this.bindEvents();
  }

  bindEvents() {
    document.addEventListener('DOMContentLoaded', () => {
      this.initializeEditButtons();
      this.initializeDeleteButtons();
      this.initializeFormHandlers();
    });
  }
    // // Sélectionner tous les boutons de modification et de suppression
    // const editButtons = document.querySelectorAll('.btn-info');
    // const deleteButtons = document.querySelectorAll('.btn-error');
  
    // // Attacher l'événement de clic aux boutons "Modifier"
    // editButtons.forEach(button => {
    //   button.addEventListener('click', function() {
    //     populateEditForm(this);
    //   });
    // });
  
    // // Attacher l'événement de clic aux boutons "Supprimer"
    // deleteButtons.forEach(button => {
    //   button.addEventListener('click', function() {
    //     populateDeleteForm(this);
    //     document.getElementById('delete-category-modal').checked = true; // Ouvrir le modal de suppression
    //   });
    // });



  initializeEditButtons() {
    document.querySelectorAll('.btn-info').forEach(button => {
      button.addEventListener('click', () => this.handleEditCategory(button));
    });
  }

  initializeDeleteButtons() {
    document.querySelectorAll('.btn-error[data-category-id]').forEach(button => {
      button.addEventListener('click', () => this.handleDeleteModal(button));
    });
  }

  initializeFormHandlers() {
    const addForm = document.getElementById('category-form');
    const editForm = document.getElementById('edit-category-form');
    const deleteForm = document.getElementById('delete-form');

    if (addForm) {
      addForm.addEventListener('submit', (e) => this.handleAddCategory(e));
    }
    if (editForm) {
      editForm.addEventListener('submit', (e) => this.handleUpdateCategory(e));
    }
    if (deleteForm) {
      deleteForm.addEventListener('submit', (e) => this.handleDeleteCategory(e));
    }
  }

  handleEditCategory(button) {
    // const categoryData = {
    //   id: button.getAttribute('data-category-id'),
    //   name: button.getAttribute('data-name'),
    //   parentCategoryId: button.getAttribute('data-parent-category-id'),
    // };

    this.populateEditForm(button);
  }

  handleDeleteModal(button) {
    const categoryId = button.getAttribute('data-category-id');
    document.getElementById('delete-category-id').value = categoryId;
    document.getElementById('delete-category-modal').checked = true;
  }

  async handleAddCategory(event) {
    event.preventDefault();
    try {
      const formData = new FormData(event.target);
      const response = await ApiService.postFormData(API_ENDPOINTS.ADD_CATEGORY, formData);

      if (response.status === 'success') {
        closeAllModals();
        showFlashMessage(response);
        location.reload();
      } else {
        showFlashMessage({
          status: 'error',
          message: response.message || 'Une erreur est survenue lors de l\'ajout de la catégorie.'
        });
      }
    } catch (error) {
      showFlashMessage({
        status: 'error',
        message: error.message
      });
    }
  }

  async handleUpdateCategory(event) {
    event.preventDefault();
    try {
      const formData = new FormData(event.target);
      const response = await ApiService.postFormData(API_ENDPOINTS.UPDATE_CATEGORY, formData);

      if (response.status === 'success') {
        closeAllModals();
        showFlashMessage(response);
        location.reload();
      } else {
        showFlashMessage({
          status: 'error',
          message: response.message || 'Une erreur est survenue lors de la mise à jour de la catégorie.'
        });
      }
    } catch (error) {
      showFlashMessage({
        status: 'error',
        message: error.message
      });
    }
  }

  async handleDeleteCategory(event) {
    event.preventDefault();
    try {
      const categoryId = document.getElementById('delete-category-id').value;
      const response = await ApiService.fetchJson(API_ENDPOINTS.DELETE_CATEGORY, {
        method: 'POST',
        body: JSON.stringify({ categoryId })
      });

      if (response.status === 'success') {
        closeAllModals();
        showFlashMessage(response);
        location.reload();
      } else {
        showFlashMessage({
          status: 'error',
          message: response.message || 'Une erreur est survenue lors de la suppression de la catégorie.'
        });
      }
    } catch (error) {
      showFlashMessage({
        status: 'error',
        message: error.message
      });
    }
  }

  // Fonction pour remplir le formulaire d'édition avec les données de la catégorie
  populateEditForm(button) {
    const categoryId = button.getAttribute('data-category-id');
    const name = button.getAttribute('data-name');
    const parentCategoryId = button.getAttribute('data-parent-category-id');

    document.getElementById('edit-category-id').value = categoryId;
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-parent-category-id').value = parentCategoryId;
  }

  // Fonction pour remplir le formulaire de suppression avec l'ID de la catégorie
  populateDeleteForm(button) {
    const categoryId = button.getAttribute('data-category-id');
    document.getElementById('delete-category-id').value = categoryId;
  }
}

const categoryManager = new CategoryManager();