class ProductManager {
  constructor() {
    this.bindEvents();
  }

  bindEvents() {
    document.addEventListener('DOMContentLoaded', () => {
      this.initializeEditButtons();
      this.initializeDeleteButtons();
      this.initializeFormHandlers();
      this.initializeImageDeleteHandlers();
    });
  }

  initializeEditButtons() {
    document.querySelectorAll('.btn-info').forEach(button => {
      button.addEventListener('click', () => this.handleEditProduct(button));
    });
  }

  initializeDeleteButtons() {
    document.querySelectorAll('.btn-error[data-product-id]').forEach(button => {
      button.addEventListener('click', () => this.handleDeleteModal(button));
    });
  }

  initializeFormHandlers() {
    const addForm = document.getElementById('productForm');
    const editForm = document.getElementById('edit-product-form');
    const deleteForm = document.getElementById('delete-form');

    if (addForm) {
      addForm.addEventListener('submit', (e) => this.handleAddProduct(e));
    }
    if (editForm) {
      editForm.addEventListener('submit', (e) => this.handleUpdateProduct(e));
    }
    if (deleteForm) {
      deleteForm.addEventListener('submit', (e) => this.handleDeleteProduct(e));
    }
  }

  initializeImageDeleteHandlers() {
    document.getElementById('edit-image-container')?.addEventListener('click',
      (e) => this.handleImageDelete(e));
  }

  handleEditProduct(button) {
    const productData = {
      id: button.getAttribute('data-product-id'),
      name: button.getAttribute('data-product'),
      description: button.getAttribute('data-description'),
      price: button.getAttribute('data-price'),
      stock: button.getAttribute('data-stock'),
      images: button.getAttribute('data-images'),
      category: button.getAttribute('data-category')
    };
    console.log(button.getAttribute('data-category'));
    
    this.populateEditForm(productData);
  }

  populateEditForm(productData) {
    const formFields = {
      'edit-product-id': productData.id,
      'edit-product': productData.name,
      'edit-description': productData.description,
      'edit-price': productData.price,
      'edit-stock': productData.stock,
      'edit-category': productData.category
    };

    Object.entries(formFields).forEach(([id, value]) => {
      document.getElementById(id).value = value;
    });

    this.updateImageContainer(productData);
  }

  updateImageContainer(productData) {
    const imageContainer = document.getElementById('edit-image-container');
    if (!imageContainer) return;

    imageContainer.innerHTML = '';

    if (productData.images) {
      const images = JSON.parse(productData.images);
      images.forEach(image => {
        const imageElement = this.createImageThumbnail(image, productData.id);
        imageContainer.appendChild(imageElement);
      });
    }
  }

  createImageThumbnail(imageUrl, productId) {
    const div = document.createElement('div');
    div.classList.add('image-thumbnail');
    div.style.position = 'relative';

    div.innerHTML = `
      <img src="${imageUrl}" alt="Product Image" class="object-cover" style="height:4rem;"/>
      <button type="button" class="btn btn-sm btn-error delete-image" 
        data-product-id="${productId}" data-image="${imageUrl}" 
        style="position: absolute; top: 0; right: 0; background: none; border: none; color: red; font-size: 1.5rem; padding: 0;">
        ×
      </button>
    `;

    return div;
  }

  async handleAddProduct(event) {
    event.preventDefault();
    try {
      const formData = new FormData(event.target);
      const response = await ApiService.postFormData(API_ENDPOINTS.ADD_PRODUCT, formData);

      if (response.status === 'success') {
        closeAllModals();
        showFlashMessage(response);
        location.reload();
      } else {
        showFlashMessage({
          status: 'error',
          message: response.message || 'Une erreur est survenue lors de l\'ajout du produit.'
        });
      }
    } catch (error) {
      showFlashMessage({
        status: 'error',
        message: error.message
      });
    }
  }

  async handleUpdateProduct(event) {
    event.preventDefault();
    try {
      const formData = new FormData(event.target);
      const response = await ApiService.postFormData(API_ENDPOINTS.UPDATE_PRODUCT, formData);

      if (response.status === 'success') {
        closeAllModals();
        showFlashMessage(response);
        location.reload();
      } else {
        showFlashMessage({
          status: 'error',
          message: response.message || 'Une erreur est survenue lors de la mise à jour du produit.'
        });
      }
    } catch (error) {
      showFlashMessage({
        status: 'error',
        message: error.message
      });
    }
  }

  async handleDeleteProduct(event) {
    event.preventDefault();
    try {
      const productId = document.getElementById('delete-product-id').value;
      const response = await ApiService.fetchJson(API_ENDPOINTS.DELETE_PRODUCT, {
        method: 'POST',
        body: JSON.stringify({ productId })
      });

      if (response.status === 'success') {
        closeAllModals();
        showFlashMessage(response);
        location.reload();
      } else {
        showFlashMessage({
          status: 'error',
          message: response.message || 'Une erreur est survenue lors de la suppression du produit.'
        });
      }
    } catch (error) {
      showFlashMessage({
        status: 'error',
        message: error.message
      });
    }
  }

  async handleImageDelete(event) {
    if (!event.target.classList.contains('delete-image')) return;

    try {
      const imageToDelete = event.target.getAttribute('data-image');
      const productId = event.target.getAttribute('data-product-id');

      const response = await ApiService.fetchJson(API_ENDPOINTS.DELETE_IMAGE, {
        method: 'POST',
        body: JSON.stringify({ productId, image: imageToDelete })
      });

      if (response.status === 'success') {
        event.target.closest('.image-thumbnail').remove();
        showFlashMessage(response);
      } else {
        showFlashMessage({
          status: 'error',
          message: response.message || 'Une erreur est survenue lors de la suppression de l\'image.'
        });
      }
    } catch (error) {
      showFlashMessage({
        status: 'error',
        message: error.message
      });
    }
  }

  handleDeleteModal(button) {
    const productId = button.getAttribute('data-product-id');
    document.getElementById('delete-product-id').value = productId;
    document.getElementById('delete-product-modal').checked = true;
  }
}

// Initialize the product manager
const productManager = new ProductManager();
