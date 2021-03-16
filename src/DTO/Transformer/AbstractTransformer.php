<?php

namespace App\DTO\Transformer;

abstract class AbstractTransformer implements TransformerInterface
{
    public function transformFromList(iterable $list): iterable
    {
        $dto = [];

        foreach ($list as $array) {
            $dto[] = $this->transformFromArray($array);
        }

        return $dto;
    }

}
