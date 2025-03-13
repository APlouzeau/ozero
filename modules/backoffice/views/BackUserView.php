<?php

class BackUserView extends View
{

    public function show($userList, $rolesList)
    {


        ob_start();


?>
        <!-- Dashboard Header -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 font-chillax">Gestion des utilisateurs</h1>
                    <p class="text-gray-500 mt-1">Administration des comptes et des rôles utilisateurs</p>
                </div>
                <label for="add-user-modal" class="btn btn-primary gap-2 mt-4 md:mt-0 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouvel utilisateur
                </label>
            </div>
        </div>

        <!-- Stats Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-primary/10 text-primary mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total utilisateurs</p>
                        <h3 class="text-xl font-bold"><?= count($userList) ?></h3>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Comptes vérifiés</p>
                        <h3 class="text-xl font-bold">
                            <?= count(array_filter($userList, function($user) { return $user->isVerified(); })) ?>
                        </h3>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Administrateurs</p>
                        <h3 class="text-xl font-bold">
                            <?= count(array_filter($userList, function($user) { return $user->getRoleId() == 1; })) ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des utilisateurs -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800">Liste des utilisateurs</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">ID</th>
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">Nom complet</th>
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">Email</th>
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">Rôle</th>
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">Vérifié</th>
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($userList as $user): ?>
                            <tr class="border-t border-gray-100 hover:bg-gray-50">
                                <td class="px-4 py-3"><?= htmlspecialchars($user->getUserId()) ?></td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold mr-3">
                                            <?= strtoupper(substr($user->getFirstName(), 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-800"><?= htmlspecialchars($user->getNickName()) ?></div>
                                            <div class="text-xs text-gray-500">
                                                <?= htmlspecialchars($user->getFirstName() . ' ' . $user->getLastName()) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-600"><?= htmlspecialchars($user->getMail()) ?></td>
                                <td class="px-4 py-3">
                                    <?php foreach ($rolesList as $role): ?>
                                        <?php if ($role->getRoleId() === $user->getRoleId()): ?>
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                <?= $role->getRoleId() == 1 ? 'bg-primary/10 text-primary' : 
                                                   ($role->getRoleId() == 2 ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600') ?>
                                            ">
                                                <?= htmlspecialchars($role->getRole()) ?>
                                            </span>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </td>
                                <td class="px-4 py-3">
                                    <?php if ($user->isVerified()): ?>
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-600">Vérifié</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-600">Non vérifié</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <label for="edit-user-modal"
                                            class="btn btn-sm btn-outline text-blue-600 border-blue-600 hover:bg-blue-600 hover:border-blue-600 hover:text-white group"
                                            data-user-id="<?= $user->getUserId() ?>"
                                            data-first-name="<?= htmlspecialchars($user->getFirstName()) ?>"
                                            data-last-name="<?= htmlspecialchars($user->getLastName()) ?>"
                                            data-nick-name="<?= htmlspecialchars($user->getNickName()) ?>"
                                            data-mail="<?= htmlspecialchars($user->getMail()) ?>"
                                            data-role-id="<?= $user->getRoleId() ?>"
                                            data-verified="<?= $user->isVerified() ? 'true' : 'false' ?>"
                                            onclick="populateEditForm(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </label>
                                        <button class="btn btn-sm btn-error btn-outline text-red-600 border-red-600 hover:bg-red-600 hover:border-red-600 hover:text-white group"
                                            data-user-id="<?= $user->getUserId() ?>"
                                            onclick="confirmDelete(<?= $user->getUserId() ?>)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modals -->
    <?php $this->renderAddModal();
        $this->renderEditModal($rolesList);
        $this->renderDeleteModal();

        $contentPage = ob_get_clean();
        (new BackOfficePageView($contentPage, 'Utilisateurs Admin', "Ceci est la page de gestion des utilisateurs.", ['backoffice', 'updateUsers']))->show();
    }
    private function renderAddModal()
    {
    ?>
        <input type="checkbox" id="add-user-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box w-11/12 max-w-5xl bg-white">
                <h3 class="text-2xl font-bold text-primary mb-6">Nouvel utilisateur</h3>
                <form method="POST" action="/admin/users/create">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Prénom
                            </label>
                            <input type="text" name="firstName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nom de famille
                            </label>
                            <input type="text" name="lastName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Pseudo
                            </label>
                            <input type="text" name="nickName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Email
                            </label>
                            <input type="email" name="mail" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Mot de passe
                            </label>
                            <input type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Rôle
                            </label>
                            <select name="roleId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition">
                                <option value="1">Admin</option>
                                <option value="2">Éditeur</option>
                                <option value="3" selected>Utilisateur</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-control mt-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="verified" class="rounded text-primary focus:ring-primary">
                            <span class="ml-2 text-sm text-gray-700">Compte vérifié</span>
                        </label>
                    </div>

                    <div class="flex justify-end space-x-3 mt-8">
                        <label for="add-user-modal" class="btn btn-outline btn-sm px-6">Annuler</label>
                        <button type="submit" class="btn btn-primary btn-sm px-6">Créer l'utilisateur</button>
                    </div>
                </form>
            </div>
        </div>
    <?php
    }

    private function renderEditModal($rolesList)
    {
    ?>
        <input type="checkbox" id="edit-user-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box w-11/12 max-w-5xl bg-white">
                <h3 class="text-2xl font-bold text-primary mb-6">Modifier l'utilisateur</h3>
                <form method="POST" action="/admin/users/update">
                    <input type="hidden" name="userId" id="edit-user-id">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Prénom
                            </label>
                            <input type="text" name="firstName" id="edit-firstName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nom de famille
                            </label>
                            <input type="text" name="lastName" id="edit-lastName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Pseudo
                            </label>
                            <input type="text" name="nickName" id="edit-nickName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Email
                            </label>
                            <input type="email" name="mail" id="edit-mail" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nouveau mot de passe <span class="text-xs text-gray-500">(laisser vide pour conserver l'actuel)</span>
                            </label>
                            <input type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition">
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Rôle
                            </label>
                            <select name="roleId" id="edit-roleId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition">
                                <?php foreach ($rolesList as $role): ?>
                                    <option value=<?= $role->getRoleId() ?>><?= $role->getRole() ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-control mt-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="verified" id="edit-verified" class="rounded text-primary focus:ring-primary">
                            <span class="ml-2 text-sm text-gray-700">Compte vérifié</span>
                        </label>
                    </div>

                    <div class="flex justify-end space-x-3 mt-8">
                        <label for="edit-user-modal" class="btn btn-outline btn-sm px-6">Annuler</label>
                        <button type="submit" class="btn btn-primary btn-sm px-6">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
        </div>
    <?php
    }

    private function renderDeleteModal()
    {
    ?>
        <input type="checkbox" id="delete-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box bg-white">
                <div class="flex items-center justify-center mb-4 text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 text-center">Confirmer la suppression</h3>
                <p class="py-4 text-gray-600 text-center">Cette action est irréversible. Êtes-vous sûr de vouloir supprimer définitivement cet utilisateur ?</p>
                <form method="POST" action="/admin/users/delete" id="delete-form">
                    <input type="hidden" name="userId" id="delete-user-id">
                    <div class="flex justify-center space-x-3 mt-4">
                        <label for="delete-modal" class="btn btn-outline btn-sm px-6">Annuler</label>
                        <button type="submit" class="btn bg-red-600 hover:bg-red-700 text-white border-none btn-sm px-6">Supprimer</button>
                    </div>
                </form>
            </div>
        </div>
<?php
    }
}
?>