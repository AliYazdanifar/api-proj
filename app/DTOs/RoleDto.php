<?php

namespace App\DTOs;

class RoleDto implements BaseDtoContract
{
    public function __construct(
        public string $name,
        public string $nickname,
    )
    {
    }

    public static function fromArray(array $data): static
    {
        return new self(
            name: $data['name'],
            nickname: $data['nickname'] ?? ''
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'nickname' => $this->nickname,
        ];
    }
}
