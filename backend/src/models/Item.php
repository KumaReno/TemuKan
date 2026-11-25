<?php
declare(strict_types=1);

final class Item
{
    private string $id;
    private string $name;
    private string $category;
    private string $status;
    private string $location;
    private string $date;
    private string $reporter;
    private string $initials;
    private string $avatar;
    private string $visual;
    private string $symbol;

    public function __construct(
        string $id,
        string $name,
        string $category,
        string $status,
        string $location,
        string $date,
        string $reporter,
        string $initials,
        string $avatar,
        string $visual,
        string $symbol
    ) {
        if ($id === '') {
            throw new InvalidArgumentException('ID barang tidak boleh kosong.');
        }

        if (!in_array($status, ['hilang', 'ditemukan'], true)) {
            throw new InvalidArgumentException('Status barang harus hilang atau ditemukan.');
        }

        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->status = $status;
        $this->location = $location;
        $this->date = $date;
        $this->reporter = $reporter;
        $this->initials = $initials;
        $this->avatar = $avatar;
        $this->visual = $visual;
        $this->symbol = $symbol;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getReporter(): string
    {
        return $this->reporter;
    }

    public function getInitials(): string
    {
        return $this->initials;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function getVisual(): string
    {
        return $this->visual;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function isLost(): bool
    {
        return $this->status === 'hilang';
    }

    public function getStatusLabel(): string
    {
        return $this->isLost() ? 'Hilang' : 'Ditemukan';
    }

    public function getStatusTagClass(): string
    {
        return $this->isLost() ? 'tag-lost' : 'tag-found';
    }

    public function getDetailUrl(): string
    {
        return 'detail.html?id=' . rawurlencode($this->id);
    }

    public function getSearchText(): string
    {
        return strtolower(implode(' ', [
            $this->name,
            $this->category,
            $this->location,
            $this->getStatusLabel(),
        ]));
    }
}
