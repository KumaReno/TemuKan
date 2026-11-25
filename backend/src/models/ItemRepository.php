<?php
declare(strict_types=1);

final class ItemRepository
{
    /**
     * @return Item[]
     */
    public function getAll(): array
    {
        return require __DIR__ . '/../data/items.php';
    }
}
