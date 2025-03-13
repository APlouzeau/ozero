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
        $stmt = $this->db->prepare("DELETE FROM users WHERE userId = :userId");
        $stmt->bindParam(':userId', $userId, \PDO::PARAM_INT);

        return $stmt->execute();
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

    /**
     * Récupère tous les utilisateurs
     *
     * @return UserEntity[]
     */
    public function getUsers(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM users");
        $stmt->execute();

        $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $userEntities = [];

        foreach ($users as $user) {
            $userEntities[] = $this->mapToEntity($user);
        }

        return $userEntities;
    }

    public function getTotalUsers() {
        $query = "SELECT COUNT(*) as total FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch()['total'];
    }
}
