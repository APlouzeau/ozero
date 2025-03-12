<?php

class FooterView extends View {

    public function show() {
        ob_start();
        ?>

        <div class="flex flex-row px-5 justify-center items-center">
            <footer class="footer w-[95%] p-8 bg-primary shadow-lg shadow-black-950 text-base-content rounded-tl-[10px] rounded-tr-[10px] flex justify-between items-center font-supreme">
                <aside class="flex items-center gap-5">
                    <img src="/assets/png/Logo1.png" alt="Logo Ozero Footer" width="150" height="150">
                </aside>
                <nav class="flex gap-10 items-center justify-center flex-grow text-center">
                    <a id="contact-link" class="footer-link link link-hover font-supreme font-semibold cursor-pointer">Contact</a>
                    <a class="footer-link link link-hover font-supreme font-semibold">À propos</a>
                </nav>
            </footer>
        </div>

        <!-- Modal de contact -->
        <div id="contact-modal" class="fixed inset-0 bg-black bg-opacity-0 z-50 flex items-center justify-center hidden transition-all duration-300 ease-in-out">
            <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4 relative transform scale-95 opacity-0 transition-all duration-300 ease-in-out">
                <button id="close-modal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
                <h2 class="text-xl font-semibold mb-4 font-supreme text-primary">Contactez-nous</h2>
                <form id="contact-form" class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 font-supreme">Nom</label>
                        <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" required>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 font-supreme">Email</label>
                        <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" required>
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 font-supreme">Message</label>
                        <textarea id="message" name="message" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" required></textarea>
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded-md hover:bg-opacity-90 transition-colors font-supreme">Envoyer</button>
                    </div>
                </form>
                <div id="form-success" class="hidden mt-4 p-3 bg-green-100 text-green-700 rounded-md font-supreme">
                    Votre message a été envoyé avec succès !
                </div>
                <div id="form-error" class="hidden mt-4 p-3 bg-red-100 text-red-700 rounded-md font-supreme">
                    Une erreur s'est produite. Veuillez réessayer.
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const contactLink = document.getElementById('contact-link');
                const contactModal = document.getElementById('contact-modal');
                const modalContent = contactModal.querySelector('div');
                const closeModal = document.getElementById('close-modal');
                const contactForm = document.getElementById('contact-form');
                const formSuccess = document.getElementById('form-success');
                const formError = document.getElementById('form-error');

                // Ouvrir la modal avec animation
                contactLink.addEventListener('click', function() {
                    // Afficher d'abord la modal
                    contactModal.classList.remove('hidden');
                    
                    // Attendre un tick pour que le navigateur traite l'affichage
                    setTimeout(() => {
                        // Animer le fond
                        contactModal.classList.add('bg-opacity-70');
                        // Animer le contenu
                        modalContent.classList.add('scale-100', 'opacity-100');
                        modalContent.classList.remove('scale-95', 'opacity-0');
                    }, 10);
                    
                    document.body.style.overflow = 'hidden'; // Empêcher le défilement
                });

                // Fermer la modal avec animation
                function closeModalWithAnimation() {
                    // Animer le fond
                    contactModal.classList.remove('bg-opacity-70');
                    contactModal.classList.add('bg-opacity-0');
                    
                    // Animer le contenu
                    modalContent.classList.remove('scale-100', 'opacity-100');
                    modalContent.classList.add('scale-95', 'opacity-0');
                    
                    // Attendre la fin de l'animation avant de cacher la modal
                    setTimeout(() => {
                        contactModal.classList.add('hidden');
                        document.body.style.overflow = ''; // Réactiver le défilement
                    }, 300);
                }

                // Fermer la modal avec le bouton
                closeModal.addEventListener('click', closeModalWithAnimation);

                // Fermer la modal en cliquant à l'extérieur
                contactModal.addEventListener('click', function(e) {
                    if (e.target === contactModal) {
                        closeModalWithAnimation();
                    }
                });

                // Soumettre le formulaire
                contactForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Récupérer les données du formulaire
                    const formData = new FormData(contactForm);
                    const data = {
                        name: formData.get('name'),
                        email: formData.get('email'),
                        message: formData.get('message'),
                        to: 'egaube0494@gmail.com'
                    };

                    // Envoyer les données par AJAX
                    fetch('/api/contact', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            formSuccess.classList.remove('hidden');
                            formError.classList.add('hidden');
                            contactForm.reset();
                            
                            // Fermer la modal après 3 secondes
                            setTimeout(() => {
                                closeModalWithAnimation();
                                setTimeout(() => {
                                    formSuccess.classList.add('hidden');
                                }, 300);
                            }, 3000);
                        } else {
                            formError.classList.remove('hidden');
                            formSuccess.classList.add('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        formError.classList.remove('hidden');
                        formSuccess.classList.add('hidden');
                    });
                });
            });
        </script>

        <?php
        return ob_get_clean();
    }
}