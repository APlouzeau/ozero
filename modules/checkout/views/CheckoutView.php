<?php

class CheckoutView extends View
{
    public function show()
    {
        ob_start();
?>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Paiement sécurisé</h1>
            
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Informations de paiement</h2>
                </div>
                <div id="checkout" class="p-6">
                    <!-- Le formulaire Stripe sera injecté ici -->
                </div>
            </div>
        </div>

        <script src="https://js.stripe.com/v3/"></script>
        <script src="/scripts/checkout.js" defer></script>
<?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Paiement', "Paiement sécurisé", ['debug']))->show();
    }

    public function getCheckoutSuccess()
    {
        ob_start();
?>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-green-50 border-b border-green-200">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <h2 class="text-lg font-semibold text-green-900">Paiement réussi</h2>
                    </div>
                </div>
                
                <div class="p-6 space-y-4">
                    <div class="text-center">
                        <p class="text-gray-600 mb-4">
                            Merci pour votre commande ! Un email de confirmation sera envoyé à 
                            <span id="customer-email" class="font-medium text-gray-900"></span>
                        </p>
                        
                        <p class="text-sm text-gray-500">
                            Pour toute question, contactez notre service client à 
                            <a href="mailto:contact@ozero.fr" class="text-primary hover:text-primary-focus">
                                contact@ozero.fr
                            </a>
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
                        <a 
                            href="/" 
                            class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-primary hover:bg-primary/90 transition-colors"
                        >
                            Retour à l'accueil
                        </a>
                        <a 
                            href="/commandes" 
                            class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 rounded-lg shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors"
                        >
                            Voir mes commandes
                        </a>
                    </div>
                </div>
            </div>
        </div>
<?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Confirmation de commande', "Confirmation de commande", ['debug']))->show();
    }

    public function getCheckoutError()
    {
        ob_start();
?>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-red-50 border-b border-red-200">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h2 class="text-lg font-semibold text-red-900">Erreur de paiement</h2>
                    </div>
                </div>
                
                <div class="p-6 space-y-4">
                    <div class="text-center">
                        <p class="text-gray-600 mb-4">
                            Une erreur est survenue lors du traitement de votre paiement.
                            <br>
                            Veuillez réessayer ou contacter notre service client.
                        </p>
                        
                        <p class="text-sm text-gray-500">
                            Pour toute assistance, contactez-nous à 
                            <a href="mailto:contact@ozero.fr" class="text-primary hover:text-primary-focus">
                                contact@ozero.fr
                            </a>
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
                        <a 
                            href="/panier" 
                            class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-primary hover:bg-primary/90 transition-colors"
                        >
                            Retourner au panier
                        </a>
                        <button 
                            onclick="window.location.reload()" 
                            class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 rounded-lg shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors"
                        >
                            Réessayer
                        </button>
                    </div>
                </div>
            </div>
        </div>
<?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Erreur de paiement', "Erreur de paiement", ['debug']))->show();
    }
}
