<?php

class PurchaseEntity
{
    private int $purchaseId;
    private int $userId;
    private string $purchaseDate;
    private float $totalAmount;
    private string $status;
    private int $addressId;
    private string $paymentMethod;
    private $user;
    private $address;
    private $products;

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = "set" . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            } else {
                $this->$key = $value;
            }
        }
    }

    public function getPurchaseId(): int
    {
        return $this->purchaseId;
    }
    public function setPurchaseId(int $purchaseId): self
    {
        $this->purchaseId = $purchaseId;
        return $this;
    }
    public function getUserId()
    {
        return $this->userId;
    }
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }
    public function getPurchaseDate(): string
    {
        return $this->purchaseDate;
    }
    public function setPurchaseDate(string $purchaseDate): self
    {
        $this->purchaseDate = $purchaseDate;
        return $this;
    }
    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }
    public function setTotalAmount(float $totalAmount): self
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }
    public function getStatus(): string
    {
        return $this->status;
    }
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }
    public function getAddressId(): int
    {
        return $this->addressId;
    }
    public function setAddressId(int $addressId): self
    {
        $this->addressId = $addressId;
        return $this;
    }
    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }
    public function setPaymentMethod(string $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address): self
    {
        $this->address = $address;
        return $this;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function setProducts($products): self
    {
        $this->products = $products;
        return $this;
    }
}
