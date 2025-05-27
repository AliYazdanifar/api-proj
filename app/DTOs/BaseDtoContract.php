<?php

namespace App\DTOs;

interface BaseDtoContract
{
    public static function fromArray(array $data):static;
    public function toArray(): array;
}
