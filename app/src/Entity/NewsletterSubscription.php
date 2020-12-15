<?php

namespace App\Entity;

use JMS\Serializer\Annotation as Serializer;

class NewsletterSubscription
{

    /**
     * @var string
     *
     * @Serializer\Type("string")
     */
    public string $id;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     */
    public string $email;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     */
    public string $category;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function toArray(): ?array
    {
        return [
            'id' => $this->getId(),
            'email' => $this->email,
            'category' => $this->category
        ];
    }
}