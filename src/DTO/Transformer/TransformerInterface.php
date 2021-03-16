<?php

namespace App\DTO\Transformer;

use App\DTO\DTOInterface;

interface TransformerInterface
{
    public function transformFromArray(array $array): DTOInterface;
    public function transformFromList(iterable $list): iterable;
}
