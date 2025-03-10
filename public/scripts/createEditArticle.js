document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Empêcher l'envoi traditionnel du formulaire

        const formData = new FormData(form);
        console.log(formData);
        // Effectuer la requête Ajax
        fetch(form.action, {
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
});

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
