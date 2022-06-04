<?php

namespace Application\Interfaces;

interface OrderRepository {
    public function createOrder(int $userId, array $bookIdsWithCount, string $creditCardName, string $creditCardNumber): ?int;    // hier ggf eine Order Entity erstellen (bei mehr Order Logik)
    // public function getOrder(int $id): ?OrderEntity  // Verbesserung
}