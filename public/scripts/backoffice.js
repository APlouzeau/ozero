// Utils
// Constants
const API_ENDPOINTS = {
  //PRODUCTS
  ADD_PRODUCT: '/admin/products/add',
  UPDATE_PRODUCT: '/admin/products/update',
  DELETE_PRODUCT: '/admin/products/delete',
  DELETE_IMAGE: '/admin/products/deleteimage',

  //CATEGORY
  ADD_CATEGORY: '/admin/categories/add',
  UPDATE_CATEGORY: '/admin/categories/update',
  DELETE_CATEGORY: '/admin/categories/delete',

  //ARTICLE
  DELETE_ARTICLE: '/admin/articles/delete',
};

// Utility functions
const ApiService = {
  async fetchJson(url, options) {
    try {
      const response = await fetch(url, {
        ...options,
        headers: {
          'Content-Type': 'application/json',
          ...options?.headers
        }
      });
      const data = await response.json();
      return data;
    } catch (error) {
      console.error('API Error:', error);
      throw new Error('Une erreur de communication est survenue avec le serveur.');
    }
  },

  async postFormData(url, formData) {
    try {
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return await response.json();
    } catch (error) {
      console.error('Form Submit Error:', error);
      throw new Error('Une erreur est survenue lors de l\'envoi du formulaire.');
    }
  }
};
function closeAllModals() {
  const modals = document.querySelectorAll('.modal');
  modals.forEach(modal => {
    modal.style.display = 'none'; // Si le modal est géré par CSS (affichage/masquage)
    modal.classList.remove('show'); // Pour Bootstrap ou modals CSS de ce genre
  });
}

// Sidebar
document.addEventListener('DOMContentLoaded', () => {

  document.getElementById('sidebarToggle').addEventListener('click', function() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('open');
  });
})


