class ArticleManager {

    constructor() {
        this.bindEvents();
    }
    
    bindEvents() {
    document.addEventListener('DOMContentLoaded', () => {
        this.initializeDeleteButtons();
        this.initializeFormHandlers();
    //   this.initializeImageDeleteHandlers();
    });
    }

    initializeDeleteButtons() {
        document.querySelectorAll('.btn-error[data-article-id]').forEach(button => {
            button.addEventListener('click', () => this.handleDeleteModal(button));
        });
    }

    initializeFormHandlers() {
        const deleteForm = document.getElementById('delete-form');
        deleteForm.addEventListener('submit', (e) => this.handleDeleteProduct(e));
    }

    handleDeleteModal(button) {
        const articleId = button.getAttribute('data-article-id');
        document.getElementById('delete-article-id').value = articleId;
        document.getElementById('delete-article-modal').checked = true;
    }


    async handleDeleteProduct(event) {
        event.preventDefault();
        try {
          const articleId = document.getElementById('delete-article-id').value;
          const response = await ApiService.fetchJson(API_ENDPOINTS.DELETE_ARTICLE, {
            method: 'POST',
            body: JSON.stringify({ articleId })
          });
    
          if (response.status === 'success') {
            closeAllModals();
            showFlashMessage(response);
            location.reload();
          } else {
            showFlashMessage({
              status: 'error',
              message: response.message || 'Une erreur est survenue lors de la suppression de l\'article.'
            });
          }
        } catch (error) {
          showFlashMessage({
            status: 'error',
            message: error.message
          });
        }
    }
}

const articleManager = new ArticleManager();
