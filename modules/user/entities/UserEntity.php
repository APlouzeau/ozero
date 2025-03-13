<?php

class UserEntity {
    // Propriétés correspondant aux colonnes de la table `users`
    private ?int $userId;
    private ?string $firstName;
    private ?string $lastName;
    private ?string $nickName;
    private ?string $mail;
    private ?string $password;
    private bool $verified;
    private ?DateTime $createdAt;
    private ?int $roleId;

    // Constructeur
    public function __construct(
        ?int $userId = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $nickName = null,
        ?string $mail = null,
        ?string $password = null,
        bool $verified = false,
        ?DateTime $createdAt = null,
        ?int $roleId = null
    ) {
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->nickName = $nickName;
        $this->mail = $mail;
        $this->password = $password;
        $this->verified = $verified;
        $this->createdAt = $createdAt;
        $this->roleId = $roleId;
    }

    // Getters
    public function getUserId(): ?int {
        return $this->userId;
    }

    public function getFirstName(): ?string {
        return $this->firstName;
    }

    public function getLastName(): ?string {
        return $this->lastName;
    }

    public function getNickName(): ?string {
        return $this->nickName;
    }

    public function getMail(): ?string {
        return $this->mail;
    }

    public function getPassword(): ?string {
        return $this->password;
    }

    public function isVerified(): bool {
        return $this->verified;
    }

    public function getCreatedAt(): ?DateTime {
        return $this->createdAt;
    }

    public function getRoleId(): ?int {
        return $this->roleId;
    }

    public function getRole(): int
    {
        return $this->role;
    }

    // Setters avec return $this pour chaînage
    public function setUserId(?int $userId): self {
        $this->userId = $userId;
        return $this;
    }

    public function setFirstName(?string $firstName): self {
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName(?string $lastName): self {
        $this->lastName = $lastName;
        return $this;
    }

    public function setNickName(?string $nickName): self {
        $this->nickName = $nickName;
        return $this;
    }

    public function setMail(?string $mail): self {
        $this->mail = $mail;
        return $this;
    }

    public function setPassword(?string $password): self {
        $this->password = $password;
        return $this;
    }

    public function setVerified(bool $verified): self {
        $this->verified = $verified;
        return $this;
    }

    public function setCreatedAt(null|string|DateTime $createdAt): self {
        if (is_string($createdAt)) {
            $createdAt = new DateTime($createdAt);
        }
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setRoleId(?int $roleId): self {
        $this->roleId = $roleId;
        return $this;
    }

    public function setRole(int $role): self
    {
        $this->role = $role;
        return $this;
    }

    // Méthode pour convertir l'objet en tableau
    public function toArray(): array {
        return [
            'userId' => $this->userId,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'nickName' => $this->nickName,
            'mail' => $this->mail,
            'password' => $this->password,
            'verified' => $this->verified,
            'createdAt' => $this->createdAt ? $this->createdAt->format('Y-m-d H:i:s') : null,
            'roleId' => $this->roleId,
            'role' => $this->role
        ];
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = "set" . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}
