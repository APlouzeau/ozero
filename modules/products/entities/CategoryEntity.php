<?php

class CategoryEntity {
    // Propriétés correspondant aux colonnes de la table `categories`
    private ?int $categoryId;
    private string $name;
    private ?int $parentCategoryId;

    // Constructeur
    public function __construct(
        ?int $categoryId = null,
        string $name,
        ?int $parentCategoryId = null
    ) {
        $this->categoryId = $categoryId;
        $this->name = $name;
        $this->parentCategoryId = $parentCategoryId;
    }

    // Getters
    public function getCategoryId(): ?int {
        return $this->categoryId;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function getParentCategoryId(): ?int {
        return $this->parentCategoryId;
    }
}
