class ProductManager {
  editorAdd;
  editorEdit;

  constructor() {
    this.bindEvents();
    // this.initializeEditor();
  }

  async bindEvents() {
    document.addEventListener('DOMContentLoaded', async () => {
      this.initializeDeleteButtons();
      await this.initializeFormHandlers();
      this.initializeImageDeleteHandlers();

      const script = document.createElement('script');
      script.src = 'https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js';
      script.onload = () => {
        console.log('CKEditor loaded successfully');
        this.initializeEditor();
      };
      script.onerror = () => console.error('Failed to load CKEditor');
      document.head.appendChild(script);
      this.initializeEditButtons();
    });
  }

  initializeEditButtons() {
    document.querySelectorAll('.btn-info').forEach(button => {
      button.addEventListener('click', () => { 
        this.handleEditProduct(button);
        this.initializeEditorUpdate();
      });
    });
    document.getElementById("annuler-edit").addEventListener('click', () => {
      this.destroyEditor();
    });
  }

  initializeDeleteButtons() {
    document.querySelectorAll('.btn-error[data-product-id]').forEach(button => {
      button.addEventListener('click', () => this.handleDeleteModal(button));
    });
  }

  async initializeFormHandlers() {
    const addForm = document.getElementById('productForm');
    const editForm = document.getElementById('edit-product-form');
    const deleteForm = document.getElementById('delete-form');

    if (addForm) {
      addForm.addEventListener('submit', async (e) => this.handleAddProduct(e));
    }
    if (editForm) {
      editForm.addEventListener('submit', async (e) => this.handleUpdateProduct(e));
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
      const textarea = document.getElementById("description");
      const dataTextArea = this.editorAdd.getData();
      textarea.value = dataTextArea;
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

  destroyEditor() {
    if (this.editorEdit) {
      this.editorEdit.destroy()
        .then(() => {
          this.editorEdit = null;
          console.log('Editor destroyed');
        })
        .catch(error => {
          console.error('Error destroying editor', error);
        });
    }
  }

  async handleUpdateProduct(event) {
    event.preventDefault();
    try {
      const textarea = document.getElementById("edit-description");
      const dataTextArea = this.editorEdit.getData();
      textarea.value = dataTextArea;
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

  initializeEditor() {
    const addTextarea = document.getElementById("description");
    const editTextarea = document.getElementById("edit-description");

    if (addTextarea) {
      ClassicEditor.create(addTextarea, {
        image: {
          styles: {
            options: ["alignLeft", "alignCenter", "alignRight"],
          },
          toolbar: [
            "imageStyle:alignLeft",
            "imageStyle:alignCenter",
            "imageStyle:alignRight",
            "|",
            "imageTextAlternative",
          ],
        },
        toolbar: {
          items: [
            "heading",
            "|",
            "bold",
            "italic",
            "link",
            "|",
            "bulletedList",
            "numberedList",
            "|",
            "uploadImage",
            "blockQuote",
            "insertTable",
            "|",
            "undo",
            "redo",
          ],
          shouldNotGroupWhenFull: true,
        },
      })
        .then((editor) => {
          console.log("Éditeur initialisé avec succès", editor);
          this.editorAdd = editor;
        })
        .catch((error) => {
          console.error("Erreur lors de l'initialisation:", error);
        });
    }
  }

  initializeEditorUpdate() {
    const editTextarea = document.getElementById("edit-description");
    console.log(":" + editTextarea.value + ":");
    if (editTextarea && editTextarea.value !== '') {
      ClassicEditor.create(editTextarea, {
        image: {
          styles: {
            options: ["alignLeft", "alignCenter", "alignRight"],
          },
          toolbar: [
            "imageStyle:alignLeft",
            "imageStyle:alignCenter",
            "imageStyle:alignRight",
            "|",
            "imageTextAlternative",
          ],
        },
        toolbar: {
          items: [
            "heading",
            "|",
            "bold",
            "italic",
            "link",
            "|",
            "bulletedList",
            "numberedList",
            "|",
            "uploadImage",
            "blockQuote",
            "insertTable",
            "|",
            "undo",
            "redo",
          ],
          shouldNotGroupWhenFull: true,
        },
      })
        .then((editor) => {
          console.log("Éditeur initialisé avec succès", editor);
          this.editorEdit = editor;
        })
        .catch((error) => {
          console.error("Erreur lors de l'initialisation:", error);
        });
    }
  }
}

// Initialize the product manager
const productManager = new ProductManager();