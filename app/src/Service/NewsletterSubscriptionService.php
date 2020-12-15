<?php

namespace App\Service;

use App\Entity\NewsletterSubscription;
use App\Util\FileHandler;
use JMS\Serializer\SerializerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;

class NewsletterSubscriptionService
{
    private FileHandler $fileHandler;
    private SerializerInterface $serializer;

    public function __construct(FileHandler $fileHandler, SerializerInterface $serializer)
    {
        $this->fileHandler = $fileHandler;
        $this->serializer = $serializer;
    }

    public function list(array $options = null): ?array
    {
        $data = $this->fileHandler->read();
        $array = $this->serializer->deserialize($data, "array<App\Entity\NewsletterSubscription>", 'json');

        if ($data) {
            if (isset($options['category'])) {
                $array = $this->filterByCategory($array, $options['category']);
            }
            if (isset($options['order'])) {
                $array = $this->order($array, $options);
            }
            return $array;
        }
        return [];
    }

    public function view(string $id): ?NewsletterSubscription
    {
        $data = $this->fileHandler->read();
        $array = $this->serializer->deserialize($data, "array<App\Entity\NewsletterSubscription>", 'json');

        return array_filter($array, static function ($sub) use ($id) {
            return ($sub->getId() === $id);
        })[0];
    }

    public function create(string $content): array
    {
        $content = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        $subscription = new NewsletterSubscription();

        $subscription
            ->setId($this->getId())
            ->setEmail($content['email'])
            ->setCategory($content['category']);

        return $this->fileHandler->append($subscription->toArray());
    }

    public function edit(NewsletterSubscription $subscription): array
    {
        $data = $this->fileHandler->read();
        $subscriptions = $this->serializer->deserialize($data, "array<App\Entity\NewsletterSubscription>", 'json');


        $keys = array_column($subscriptions, 'id');
        $index = array_search($subscription->getId(), $keys, true);

        if ($index !== false) {
            $subscriptions[$index] = $subscription;
        }

        $this->fileHandler->write($subscriptions);

        return $subscriptions;
    }

    public function delete(string $subscriptionId): ?array
    {
        $data = $this->fileHandler->read();
        $subscriptions = $this->serializer->deserialize($data, "array<App\Entity\NewsletterSubscription>", 'json');


        $keys = array_column($subscriptions, 'id');
        $index = array_search($subscriptionId, $keys, true);

        unset($subscriptions[$index]);

        $this->fileHandler->write($subscriptions);

        return $subscriptions;
    }

    private function getId(): string
    {
        return Uuid::uuid6()->toString();
    }

    private function filterByCategory(array $array, ?string $flag = null): ?array
    {
        // TODO: Edit function is using same thing, separate to other methods those both places
        if ($flag) {
            return array_values(array_filter($array, function ($var) use ($flag) {
                return ($var->getCategory() === $flag);
            }));
        }
        return $array;
    }

// TODO: Move to separate class

    private function order(array $array, array $options): ?array
    {
        switch ($options['order']) {
            case '-email':
                return $this->ascSort($array, 'email');
            case 'email':
                return $this->descSort($array, 'email');
            case '-category':
                return $this->ascSort($array, 'category');
            case 'category':
                return $this->descSort($array, 'category');
            default:
                return $array;
        }

    }

    private function ascSort(array $array, string $field): array
    {
        usort($array, function ($first, $second) use ($field) {
            return strtolower($first->{$field}) > strtolower($second->{$field});
        });
        return $array;
    }

    private function descSort(array $array, string $field): array
    {
        usort($array, function ($first, $second) use ($field) {
            return strtolower($first->{$field}) < strtolower($second->{$field});
        });
        return $array;
    }


}