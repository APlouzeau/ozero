class ArticleCreateEditdManager {

    constructor() {
        this.bindEvents();
      }
    
      bindEvents() {
        document.addEventListener('DOMContentLoaded', () => {
          this.initializeProductsListButton();
          this.handleSubmitForm();
        //   this.initializeFormHandlers();
        //   this.initializeImageDeleteHandlers();
        });
      }

    async initializeProductsListButton() {
        const productsContainer = document.getElementById("productsContainer");
        // Charger la liste de produits
        await fetch('/products/search')
        .then(response => response.json())
        .then(data => {
            const productsList = document.getElementById('productsList');
            const products = data.data;
            products.forEach(product => {
                const option = document.createElement('option');
                option.value = product.product;
                option.dataset.id = product.productId;
                option.dataset.img = product.img;
                productsList.appendChild(option);
            });
        })
        .catch(error => console.error('Erreur lors du chargement des produits:', error));
        // Gérer l'ajout d'un produit sélectionné
        document.getElementById('addSelectedProduct').addEventListener('click', function() {
        const productSearch = document.getElementById('productSearch');
        const productsContainer = document.getElementById('productContainer');
        const productName = productSearch.value;
    
        // Trouver l'ID du produit correspondant au nom saisi
        const option = Array.from(document.getElementById('productsList').options)
            .find(opt => opt.value === productName);
            
        if (option) {
            const productId = option.dataset.id;
            const productImg = option.dataset.img;
            
            // Vérifier si le produit n'est pas déjà ajouté
            if (!document.querySelector(`input[value="${productId}"]`)) {
                // Créer un élément pour afficher le produit sélectionné
                const productElement = document.createElement('div');
                productElement.className = 'flex flex-col w-1/4 items-center justify-center p-2 border rounded mb-1';
                productElement.innerHTML = `
                    <img src="${productImg}" alt="${productName}" class="w-16 h-16 rounded-md mr-2">
                    <span>${productName}</span>
                    <input type="hidden" name="selectedProducts[]" value="${productId}">
                    <button type="button" class="remove-product btn btn-sm btn-error">×</button>
                `;
                
                // Ajouter l'élément à la liste des produits sélectionnés
                productsContainer.appendChild(productElement);
                
                // Réinitialiser le champ de recherche
                productSearch.value = '';
            }
        }
        });
    
        // Gérer la suppression des produits sélectionnés
        document.getElementById('productContainer').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-product')) {
            e.target.closest('div').remove();
        }
        });
    }
    
    async handleSubmitForm() {
        const form = document.querySelector("form");
        form.addEventListener("submit", async function (event) {
            event.preventDefault(); // Empêcher l'envoi traditionnel du formulaire
            const selectedProducts = document.querySelectorAll('input[name="selectedProducts[]"]');
            const formData = new FormData(form);
            let products = [];
            selectedProducts.forEach(product => {
                products.push(product.value);
            });
            formData.append('selectedProducts', JSON.stringify(products));
            console.log(formData);
            console.log(products);
            // Effectuer la requête Ajax
            await fetch(form.action, {
                method: "POST",
                body: formData,
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then((data) => {
                    console.log(data);
                    if (data.status === "success") {
                        // Show success message using showFlashMessage function
                        showFlashMessage({
                            status: "success",
                            message: data.message || "Article enregistré avec succès!",
                        });
                        // Redirect to articles page
                        setTimeout(() => {
                            window.location.href = "/admin/articles";
                        }, 1000);
                    } else {
                        // Show error message
                        showFlashMessage({
                            status: "error",
                            message: data.message || "Une erreur est survenue",
                        });
                    }
                })
                .catch((error) => {
                    console.error("Erreur:", error);
                    showFlashMessage({
                        status: "error",
                        message: `Erreur: ${error.message}`,
                    });
                });
        });
    }
}

const manager = new ArticleCreateEditdManager();

class MyUploadAdapter {
    constructor(loader) {
        this.loader = loader;
    }

    upload() {
        return this.loader.file.then(
            (file) =>
                new Promise((resolve, reject) => {
                    const formData = new FormData();
                    formData.append("upload", file);

                    fetch("/admin/articles/uploadimage", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || "",
                        },
                        body: formData,
                    })
                        .then((response) => response.json())
                        .then((response) => {
                            if (response.error) {
                                reject(response.error);
                            } else {
                                resolve({
                                    default: response.url,
                                });
                            }
                        })
                        .catch((error) => {
                            reject(error);
                        });
                })
        );
    }

    abort() {
        // Abort upload if needed
    }
}

function MyUploadAdapterPlugin(editor) {
    editor.plugins.get("FileRepository").createUploadAdapter = (loader) => {
        return new MyUploadAdapter(loader);
    };
}

ClassicEditor.create(document.querySelector("#content"), {
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
    extraPlugins: [MyUploadAdapterPlugin],
})
    .then((editor) => {
        console.log("Éditeur initialisé avec succès", editor);

        // Ajouter un gestionnaire d'événements pour les images
        editor.editing.view.document.on("click", (evt, data) => {
            if (data.domTarget.tagName === "IMG") {
                console.log("Image cliquée:", data.domTarget);
            }
        });
    })
    .catch((error) => {
        console.error("Erreur lors de l'initialisation:", error);
    });

// Styles pour les images
const style = document.createElement("style");
style.textContent = `
    .ck-content .image {
        margin: 1em 0;
        max-width: 100%;
    }
    
    .ck-content .image img {
        display: block;
        margin: 0 auto;
        max-width: 100%;
        height: auto;
    }

    .ck-content .image-style-align-left {
        float: left;
        margin-right: 1em;
    }

    .ck-content .image-style-align-right {
        float: right;
        margin-left: 1em;
    }

    .ck-content .image-style-align-center {
        margin-left: auto;
        margin-right: auto;
    }
`;
document.head.appendChild(style);
