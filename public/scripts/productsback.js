document.addEventListener('DOMContentLoaded', () => {
  console.log("Script productsback.js chargé!");
  
  // Fonction pour créer une miniature d'image
  function createImageThumbnail(imagePath, productId) {
    console.log("Création d'une miniature pour l'image:", imagePath);
    const div = document.createElement('div');
    div.className = 'relative group';
    div.dataset.imagePath = imagePath;
    
    div.innerHTML = `
      <div class="relative overflow-hidden rounded-md">
        <img src="${imagePath}" alt="Image du produit" class="h-24 w-24 object-cover rounded-md border border-gray-200 transition-transform duration-300 group-hover:scale-105" />
        <button type="button" class="delete-image-btn absolute top-1 right-1 bg-white rounded-full p-1 shadow-sm cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity duration-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 hover:text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    `;
    
    // Ajouter un gestionnaire d'événements pour la suppression de l'image
    const deleteBtn = div.querySelector('.delete-image-btn');
    deleteBtn.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      
      // Extraire le nom du fichier pour un message plus clair
      const fileName = imagePath.split('/').pop();
      
      if (confirm(`Êtes-vous sûr de vouloir supprimer l'image "${fileName}" ? Cette action est irréversible.`)) {
        // Première approche : ajouter un champ caché au formulaire pour marquer l'image à supprimer
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'delete_images[]';
        hiddenInput.value = imagePath;

        const form = document.getElementById('edit-product-form');
        if (form) {
          form.appendChild(hiddenInput);
          console.log(`Image ${imagePath} marquée pour suppression via formulaire`);
          
          // Ajouter une animation de disparition
          div.style.transition = 'all 0.3s ease-out';
          div.style.transform = 'scale(0.8)';
          div.style.opacity = '0';
          
          setTimeout(() => {
            div.remove();
            // Vérifier s'il reste des images
            const imageContainer = document.getElementById('edit-image-container');
            if (imageContainer && imageContainer.children.length === 0) {
              imageContainer.innerHTML = '<p class="text-gray-500 text-center py-4">Aucune image disponible</p>';
            }
          }, 300);
        }
        
        // Seconde approche : essayer aussi de supprimer directement via XMLHttpRequest
        try {
          console.log('Tentative de suppression directe de l\'image:', imagePath, 'pour le produit:', productId);
          
          const xhr = new XMLHttpRequest();
          xhr.open('POST', '/admin/products/deleteimage', true);
          xhr.setRequestHeader('Content-Type', 'application/json');
          
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
              console.log('Statut de la réponse:', xhr.status);
              console.log('Réponse complète:', xhr.responseText);
              
              try {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                  console.log('Image supprimée avec succès via XHR');
                } else {
                  console.error('Erreur lors de la suppression via XHR:', response.message);
                }
              } catch (e) {
                console.error('Erreur de parsing JSON:', e);
              }
            }
          };
          
          xhr.send(JSON.stringify({
            productId: productId,
            image: imagePath
          }));
        } catch (error) {
          console.error('Erreur lors de la tentative de suppression directe:', error);
        }
      }
    });
    
    return div;
  }
  
  // Fonction pour afficher les images dans le conteneur
  function displayProductImages(images, productId) {
    console.log("Affichage des images pour le produit:", productId, images);
    const imageContainer = document.getElementById('edit-image-container');
    if (!imageContainer) {
      console.error("Le conteneur d'images n'existe pas");
      return;
    }
    
    // Vider le conteneur
    imageContainer.innerHTML = '';
    
    // Si aucune image, afficher un message
    if (!images || images.length === 0) {
      imageContainer.innerHTML = '<p class="text-gray-500 text-center py-4">Aucune image disponible</p>';
      return;
    }
    
    // Ajouter chaque image au conteneur
    images.forEach(imagePath => {
      if (imagePath) {
        const thumbnail = createImageThumbnail(imagePath, productId);
        imageContainer.appendChild(thumbnail);
      }
    });
  }
  
  // Fonction pure pour ouvrir uniquement la modal d'édition
  function openEditModal(productId, name, description, price, stock, categoryId, images) {
    console.log("Tentative d'ouverture de la modal d'édition pour le produit:", productId);
    
    // Fermer explicitement toutes les autres modals
    document.getElementById('delete-product-modal').checked = false;
    document.getElementById('add-product-modal').checked = false;
    
    // Remplir le formulaire
    document.getElementById('edit-product-id').value = productId;
    document.getElementById('edit-product').value = name;
    document.getElementById('edit-description').value = description;
    document.getElementById('edit-price').value = price;
    document.getElementById('edit-stock').value = stock;
    
    // Définir la catégorie si disponible
    if (categoryId) {
      document.getElementById('edit-category').value = categoryId;
    } else {
      document.getElementById('edit-category').value = ''; // Aucune catégorie
    }
    
    // Afficher les images du produit
    try {
      let imagesArray = [];
      if (typeof images === 'string') {
        // Si c'est une chaîne JSON, essayer de la parser
        try {
          imagesArray = JSON.parse(images);
        } catch (e) {
          console.error("Erreur lors du parsing des images:", e);
        }
      } else if (Array.isArray(images)) {
        // Si c'est déjà un tableau
        imagesArray = images;
      }
      
      displayProductImages(imagesArray, productId);
    } catch (e) {
      console.error("Erreur lors de l'affichage des images:", e);
    }
    
    // Désactiver toute redirection ou comportement supplémentaire
    // Arrêter la propagation des événements qui pourrait déclencher d'autres actions
    setTimeout(() => {
      // Ouvrir la modal d'édition avec un léger délai pour éviter les conflits
      document.getElementById('edit-product-modal').checked = true;
      // Force la fermeture de la modal de suppression
      document.getElementById('delete-product-modal').checked = false;
      console.log("La modal d'édition devrait être ouverte maintenant");
    }, 10);
  }
  
  // Fonction pure pour ouvrir uniquement la modal de suppression
  function openDeleteModal(productId) {
    console.log("Tentative d'ouverture de la modal de suppression pour le produit:", productId);
    
    // Fermer explicitement toutes les autres modals
    document.getElementById('edit-product-modal').checked = false;
    document.getElementById('add-product-modal').checked = false;
    
    // Remplir le formulaire
    document.getElementById('delete-product-id').value = productId;
    
    // Ouvrir la modal de suppression
    document.getElementById('delete-product-modal').checked = true;
    console.log("La modal de suppression devrait être ouverte maintenant");
  }
  
  // Sélectionne les labels pour l'édition avec l'attribut data-product-id
  const editButtons = document.querySelectorAll('label[for="edit-product-modal"][data-product-id]');
  console.log("Nombre de boutons d'édition trouvés:", editButtons.length);
  
  // Nous n'avons pas besoin de gérer les boutons de suppression ici car ils utilisent déjà onclick="confirmDelete"
  // qui est défini dans le HTML et/ou deleteProduct.js
  
  // On remplace tous les boutons par des clones pour supprimer tous les écouteurs
  editButtons.forEach(button => {
    const newButton = button.cloneNode(true);
    button.parentNode.replaceChild(newButton, button);
    
    // On ajoute un nouvel écouteur avec capture explicite de tous les attributs
    newButton.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      console.log("Bouton d'édition cliqué!");
      
      const productId = this.getAttribute('data-product-id');
      const name = this.getAttribute('data-product');
      const description = this.getAttribute('data-description');
      const price = this.getAttribute('data-price');
      const stock = this.getAttribute('data-stock');
      const categoryId = this.getAttribute('data-category-id');
      const images = this.getAttribute('data-images');
      
      console.log("Données récupérées:", { productId, name, description, price, stock, categoryId, images });
      
      // Appel direct à notre fonction pure
      openEditModal(productId, name, description, price, stock, categoryId, images);
      
      return false;
    }, true); // Capture phase pour priorité maximale
  });
  
  // Vérification supplémentaire sur les modals pour éviter qu'elles ne s'ouvrent simultanément
  document.getElementById('edit-product-modal').addEventListener('change', function() {
    if (this.checked) {
      console.log("Modal d'édition ouverte, fermeture des autres modals");
      document.getElementById('delete-product-modal').checked = false;
      document.getElementById('add-product-modal').checked = false;
    }
  });
  
  document.getElementById('delete-product-modal').addEventListener('change', function() {
    if (this.checked) {
      console.log("Modal de suppression ouverte, fermeture des autres modals");
      document.getElementById('edit-product-modal').checked = false;
      document.getElementById('add-product-modal').checked = false;
    }
  });
  
  // Gestion de la prévisualisation des images pour la modal d'ajout
  const addImagesInput = document.getElementById('add-images');
  if (addImagesInput) {
    addImagesInput.addEventListener('change', function() {
      const previewContainer = document.getElementById('add-image-preview-container');
      if (!previewContainer) {
        console.error("Le conteneur de prévisualisation n'existe pas");
        return;
      }
      
      // Vider le conteneur
      previewContainer.innerHTML = '';
      
      // Vérifier si des fichiers ont été sélectionnés
      if (this.files && this.files.length > 0) {
        previewContainer.classList.remove('hidden');
        
        // Afficher chaque image sélectionnée
        Array.from(this.files).forEach(file => {
          if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
              const div = document.createElement('div');
              div.className = 'relative group';
              
              div.innerHTML = `
                <div class="relative overflow-hidden rounded-md">
                  <img src="${e.target.result}" alt="Prévisualisation" class="h-24 w-24 object-cover rounded-md border border-gray-200 transition-transform duration-300 group-hover:scale-105" />
                </div>
              `;
              
              previewContainer.appendChild(div);
            };
            reader.readAsDataURL(file);
          }
        });
      } else {
        previewContainer.classList.add('hidden');
      }
    });
  }
  
  document.getElementById('add-product-modal').addEventListener('change', function() {
    if (this.checked) {
      console.log("Modal d'ajout ouverte, fermeture des autres modals");
      document.getElementById('edit-product-modal').checked = false;
      document.getElementById('delete-product-modal').checked = false;
    }
  });
  
  console.log("Configuration des écouteurs d'événements terminée!");
});
