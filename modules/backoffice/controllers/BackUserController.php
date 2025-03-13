<?php

class BackUserController
{

    public function __construct() {}

    /**
     * @return void
     */
    public function execute()
    {
        $userModel = new UserModel();
        $userList = $userModel->getUsers();

        $roleModel = new RoleModel();
        $rolesList = $roleModel->getRoles();

        $view = new BackUserView();
        $view->show($userList, $rolesList);
    }

    public function createUser()
    {

        $user = new UserEntity(
            null,
            $_POST['firstName'],
            $_POST['lastName'],
            $_POST['nickName'],
            $_POST['mail'],
            $_POST['password'] ?? null,
            true,
            null,
            $_POST['roleId'],
        );
        $userModel = new UserModel();
        $userModel->addUser($user);
        header('Location: /admin/users');
    }
    
    /**
     * Supprime un utilisateur de la base de données (suppression logique)
     * 
     * @return void
     */
    public function deleteUser()
    {
        if (!isset($_POST['userId']) || empty($_POST['userId'])) {
            $_SESSION['error'] = "ID utilisateur manquant ou invalide.";
            header('Location: /admin/users');
            return;
        }
        
        $userId = (int)$_POST['userId'];
        $userModel = new UserModel();
        
        if ($userModel->softDeleteUser($userId)) {
            $_SESSION['success'] = "L'utilisateur a été supprimé avec succès.";
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression de l'utilisateur.";
        }
        
        header('Location: /admin/users');
    }
}
