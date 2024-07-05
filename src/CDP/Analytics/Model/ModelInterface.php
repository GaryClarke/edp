<?php

namespace App\CDP\Analytics\Model;

interface ModelInterface
{
    /**
     * @return  array<string, mixed>
     */
    public function toArray(): array;
}
