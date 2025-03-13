<?php


class UserModel
{
    protected $db;

    public function __construct()
    {
        $this->db = DataBase::getConnection();
    }

    /**
     * Récupère un utilisateur par son ID
     *
     * @param int $userId
     * @return UserEntity|null
     */
    public function getUserById(int $userId): ?UserEntity
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE userId = :userId");
        $stmt->bindParam(':userId', $userId, \PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($user) {
            return $this->mapToEntity($user);
        }
        return null;
    }

    /**
     * Récupère un utilisateur par son email
     *
     * @param string $email
     * @return UserEntity|null
     */
    public function getUserByEmail(string $email): ?UserEntity
    {
        try {
            error_log("Searching user with email: $email"); // Log

            $stmt = $this->db->prepare("SELECT * FROM users WHERE mail = :mail");
            $stmt->bindParam(':mail', $email, \PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(\PDO::FETCH_ASSOC);
            if ($user) {
                return $this->mapToEntity($user);
            }
            return null;
        } catch (\PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            throw new \RuntimeException("Erreur lors de la récupération de l'utilisateur.");
        }
    }


    /**
     * Ajoute un utilisateur à la base de données
     *
     * @param UserEntity $userEntity
     * @return bool
     */
    public function addUser(UserEntity $userEntity): bool
    {
        $firstName = $userEntity->getFirstName();
        $lastName = $userEntity->getLastName();
        $nickName = $userEntity->getNickName();
        $mail = $userEntity->getMail();
        $password = $userEntity->getPassword();
        $verified = 0;
        $roleId = $userEntity->getRoleId() ?? 1;

        // Debug pour vérifier les valeurs
        // Préparer la requête
        $stmt = $this->db->prepare("INSERT INTO users (firstName, lastName, nickName, mail, password, verified, roleId) 
        VALUES (:firstName, :lastName, :nickName, :mail, :password, :verified, :roleId)");

        return $stmt->execute([
            ':firstName' => $firstName,
            ':lastName' => $lastName,
            ':nickName' => $nickName,
            ':mail' => $mail,
            ':password' => $password,
            ':verified' => $verified,
            ':roleId' => $roleId
        ]);
    }



    /**
     * Met à jour un utilisateur
     *
     * @param UserEntity $userEntity
     * @return bool
     */
    public function updateUser(UserEntity $userEntity): bool
    {
        $firstName = $userEntity->getFirstName();
        $lastName = $userEntity->getLastName();
        $nickName = $userEntity->getNickName();
        $mail = $userEntity->getMail();
        $password = $userEntity->getPassword();
        $verified = $userEntity->isVerified();
        $roleId = $userEntity->getRoleId();
        $userId = $userEntity->getUserId();

        $stmt = $this->db->prepare("UPDATE users SET firstName = :firstName, lastName = :lastName, 
        nickName = :nickName, mail = :mail, password = :password, verified = :verified, roleId = :roleId 
        WHERE userId = :userId");

        $stmt->bindParam(':userId', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':firstName', $firstName, \PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, \PDO::PARAM_STR);
        $stmt->bindParam(':nickName', $nickName, \PDO::PARAM_STR);
        $stmt->bindParam(':mail', $mail, \PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, \PDO::PARAM_STR);
        $stmt->bindParam(':verified', $verified, \PDO::PARAM_BOOL);
        $stmt->bindParam(':roleId', $roleId, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Supprime un utilisateur
     *
     * @param int $userId
     * @return bool
     */
    public function deleteUser(int $userId): bool
    {
        try {
            // Commencer une transaction
            $this->db->beginTransaction();
            
            // 1. Récupérer les adresses de l'utilisateur
            $addrStmt = $this->db->prepare("SELECT addressId FROM addresses WHERE userId = :userId");
            $addrStmt->bindParam(':userId', $userId, \PDO::PARAM_INT);
            $addrStmt->execute();
            $addressIds = $addrStmt->fetchAll(\PDO::FETCH_COLUMN);
            
            // 2. Pour chaque adresse, supprimer les entrées dans purchases
            if (!empty($addressIds)) {
                $placeholders = implode(',', array_fill(0, count($addressIds), '?'));
                $purchStmt = $this->db->prepare("DELETE FROM purchases WHERE addressId IN ($placeholders)");
                foreach ($addressIds as $i => $addressId) {
                    $purchStmt->bindValue($i + 1, $addressId, \PDO::PARAM_INT);
                }
                $purchStmt->execute();
                
                // 3. Supprimer les adresses
                $delAddrStmt = $this->db->prepare("DELETE FROM addresses WHERE userId = :userId");
                $delAddrStmt->bindParam(':userId', $userId, \PDO::PARAM_INT);
                $delAddrStmt->execute();
            }
            
            // 4. Supprimer d'autres dépendances potentielles (ex: paniers, commentaires, etc.)
            // Exemple pour paniers (si applicable):
            $basketStmt = $this->db->prepare("DELETE FROM baskets WHERE userId = :userId");
            $basketStmt->bindParam(':userId', $userId, \PDO::PARAM_INT);
            $basketStmt->execute();
            
            // 5. Finalement, supprimer l'utilisateur
            $userStmt = $this->db->prepare("DELETE FROM users WHERE userId = :userId");
            $userStmt->bindParam(':userId', $userId, \PDO::PARAM_INT);
            $userStmt->execute();
            
            // Si tout s'est bien passé, valider la transaction
            $this->db->commit();
            return true;
            
        } catch (\PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $this->db->rollBack();
            error_log("Erreur lors de la suppression de l'utilisateur: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Marque un utilisateur comme supprimé sans le supprimer physiquement
     * 
     * @param int $userId
     * @return bool
     */
    public function softDeleteUser(int $userId): bool
    {
        try {
            // Vérifier si la colonne isDeleted existe, sinon la créer
            $this->ensureIsDeletedColumnExists();
            
            // Marquer l'utilisateur comme supprimé
            $stmt = $this->db->prepare("UPDATE users SET isDeleted = TRUE WHERE userId = :userId");
            $stmt->bindParam(':userId', $userId, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Erreur lors de la suppression logique de l'utilisateur: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * S'assure que la colonne isDeleted existe dans la table users
     */
    private function ensureIsDeletedColumnExists(): void
    {
        try {
            // Vérifier si la colonne existe déjà
            $stmt = $this->db->prepare("SHOW COLUMNS FROM users LIKE 'isDeleted'");
            $stmt->execute();
            if ($stmt->rowCount() === 0) {
                // La colonne n'existe pas, on la crée
                $this->db->exec("ALTER TABLE users ADD COLUMN isDeleted BOOLEAN DEFAULT FALSE");
            }
        } catch (\PDOException $e) {
            error_log("Erreur lors de la vérification/création de la colonne isDeleted: " . $e->getMessage());
            throw $e; // On relance l'exception pour qu'elle soit gérée par l'appelant
        }
    }
    
    /**
     * Récupère la liste des utilisateurs non supprimés
     * 
     * @return array
     */
    public function getUsers(): array
    {
        try {
            // Vérifier si la colonne isDeleted existe
            $this->ensureIsDeletedColumnExists();
            
            // Récupérer uniquement les utilisateurs non supprimés
            $stmt = $this->db->prepare("SELECT * FROM users WHERE isDeleted = FALSE OR isDeleted IS NULL");
            $stmt->execute();
            
            $users = [];
            while ($user = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $users[] = $this->mapToEntity($user);
            }
            
            return $users;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des utilisateurs: " . $e->getMessage());
            return [];
        }
    }

    public function getTotalUsers() {
        $query = "SELECT COUNT(*) as total FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch()['total'];
    }

    /**
     * Mappe les données de la base de données vers une entité UserEntity
     *
     * @param array $data
     * @return UserEntity
     */
    private function mapToEntity(array $data): UserEntity
    {
        $userEntity = new UserEntity();

        $userEntity->setUserId($data['userId'])
            ->setFirstName($data['firstName'])
            ->setLastName($data['lastName'])
            ->setNickName($data['nickName'])
            ->setMail($data['mail'])
            ->setPassword($data['password'])
            ->setVerified($data['verified'])
            ->setCreatedAt(new \DateTime($data['createdAt']))
            ->setRoleId($data['roleId']);

        return $userEntity;
    }
}
