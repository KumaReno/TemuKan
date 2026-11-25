<?php
declare(strict_types=1);

final class HomeController
{
    public function __construct(
        private ItemRepository $itemRepository
    ) {
    }

    public function index(): void
    {
        $items = $this->itemRepository->getAll();
        $totalItems = count($items);
        $lostCount = count(array_filter(
            $items,
            static fn (Item $item): bool => $item->isLost()
        ));
        $foundCount = $totalItems - $lostCount;

        require __DIR__ . '/../views/home.php';
    }
}
