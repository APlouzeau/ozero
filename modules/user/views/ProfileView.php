<?php

class ProfileView extends View
{
    public function show($user, $role, $addresse)
    {
        ob_start();
?>

        <div class="min-h-screen  py-12 px-4 sm:px-6 lg:px-8 mt-10">
            <div class="max-w-4xl mx-auto rounded-2xl shadow-xl overflow-hidden">
                <!-- En-tête du profil avec bannière -->
                <div class="relative h-32 bg-gradient-to-r from-green-500 to-emerald-500">
                    <!-- Suppression de l'avatar -->
                </div>
                
                <!-- Contenu principal -->
                <div class="pt-8 pb-12 px-8">
                    <div class="flex flex-col md:flex-row justify-between">
                        <!-- Informations personnelles -->
                        <div class="w-full md:w-1/2 mb-8 md:mb-0">
                            <h1 class="text-3xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($user->getFirstName()) ?> <?= htmlspecialchars($user->getLastName()) ?></h1>
                            <p class="text-lg text-green-600 mb-6">@<?= htmlspecialchars($user->getNickName()) ?></p>
                            
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-gray-700"><?= htmlspecialchars($user->getMail()) ?></span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <span class="text-gray-700"><?= htmlspecialchars($role) ?></span>
                                </div>
                            </div>
                            
                            <div class="mt-8">
                                <label for="edit-user-modal"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200"
                                    data-user-id="<?= $user->getUserId() ?>"
                                    data-first-name="<?= htmlspecialchars($user->getFirstName()) ?>"
                                    data-last-name="<?= htmlspecialchars($user->getLastName()) ?>"
                                    data-nick-name="<?= htmlspecialchars($user->getNickName()) ?>"
                                    data-mail="<?= htmlspecialchars($user->getMail()) ?>"
                                    data-role-id="<?= $user->getRoleId() ?>"
                                    data-verified="<?= $user->isVerified() ? 'true' : 'false' ?>"
                                    onclick="populateEditForm(this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    Modifier mes informations
                                </label>
                            </div>
                        </div>
                        
                        <!-- Informations d'adresse -->
                        <div class="w-full md:w-1/2 bg-gray-50 rounded-xl p-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Coordonnées
                            </h2>
                            
                            <div class="space-y-3 text-gray-600">
                                <?php if ($addresse instanceof AddressesEntity): ?>
                                <div class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    <span><?= htmlspecialchars($addresse->getStreet() ?? '') ?></span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8"></div>
                                    <span><?= htmlspecialchars($addresse->getZipCode() ?? '') ?> <?= htmlspecialchars($addresse->getCity() ?? '') ?></span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8"></div>
                                    <span><?= htmlspecialchars($addresse->getCountry() ?? '') ?></span>
                                </div>
                                <div class="flex items-center mt-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span><?= htmlspecialchars($addresse->getPhone() ?? '') ?></span>
                                </div>
                                <?php else: ?>
                                <p class="text-gray-500 italic">Aucune adresse enregistrée</p>
                                <?php endif; ?>
                                
                                <div class="mt-6">
                                    <label for="edit-address-modal"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200"
                                        data-user-id="<?= $user->getUserId() ?>"
                                        data-street="<?= $addresse ? htmlspecialchars($addresse->getStreet()) ?? '' : '' ?>"
                                        data-zipCode="<?= $addresse ? htmlspecialchars($addresse->getZipCode()) ?? '' : '' ?>"
                                        data-city="<?= $addresse ? htmlspecialchars($addresse->getCity()) ?? '' : '' ?>"
                                        data-country="<?= $addresse ? htmlspecialchars($addresse->getCountry()) ?? '' : '' ?>"
                                        data-phone="<?= $addresse ? $addresse->getPhone() ?? '' : '' ?>"
                                        data-role-id="<?= $user->getRoleId() ?>"
                                        onclick="populateAddressForm(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                        Modifier mon adresse
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php
        $this->renderEditModal();
        $this->renderEditModalAdress();
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Profil', "Page de profil", ['debug', 'updateUsers']))->show();
    }

    private function renderEditModal()
    {
    ?>
        <input type="checkbox" id="edit-user-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box w-11/12 max-w-5xl bg-white rounded-lg shadow-xl">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Modifier mes informations</h3>
                <form method="POST" action="/admin/users/update">
                    <input type="hidden" name="userId" id="edit-user-id">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Prénom
                            </label>
                            <input type="text" name="firstName" id="edit-firstName" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nom de famille
                            </label>
                            <input type="text" name="lastName" id="edit-lastName" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Pseudo
                            </label>
                            <input type="text" name="nickName" id="edit-nickName" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Email
                            </label>
                            <input type="email" name="mail" id="edit-mail" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nouveau mot de passe
                            </label>
                            <input type="password" name="password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>

                        <div class="form-control hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Rôle
                            </label>
                            <input type="text" name="roleId" id="edit-roleId" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" list="roles" required>
                        </div>

                        <div class="form-control mt-4 hidden">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="verified" id="edit-verified" class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Compte vérifié</span>
                            </label>
                        </div>

                        <div class="modal-action col-span-2 flex justify-end space-x-3 mt-8">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Enregistrer
                            </button>
                            <label for="edit-user-modal" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Annuler
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php
    }

    private function renderEditModalAdress()
    {
    ?>
        <input type="checkbox" id="edit-address-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box w-11/12 max-w-5xl bg-white rounded-lg shadow-xl">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Modifier mon adresse</h3>
                <form method="POST" action="/admin/users/updateAddresse">
                    <input type="hidden" name="userId" id="edit-address-user-id">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Adresse
                            </label>
                            <input type="text" name="street" id="edit-street" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Code postal
                            </label>
                            <input type="text" name="zipCode" id="edit-zipCode" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Ville
                            </label>
                            <input type="text" name="city" id="edit-city" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Pays
                            </label>
                            <input type="text" name="country" id="edit-country" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                N° de téléphone
                            </label>
                            <input type="text" name="phone" id="edit-phone" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>

                        <div class="form-control hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Rôle
                            </label>
                            <input type="text" name="roleId" id="edit-addresse-roleId" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" list="roles" required>
                        </div>

                        <div class="modal-action col-span-2 flex justify-end space-x-3 mt-8">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Enregistrer
                            </button>
                            <label for="edit-address-modal" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Annuler
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
<?php
    }
}
