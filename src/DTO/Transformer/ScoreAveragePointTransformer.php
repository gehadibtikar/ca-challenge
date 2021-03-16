<?php

namespace App\DTO\Transformer;

use App\DTO\DTOInterface;
use App\DTO\ScoreAveragePointDTO;
use App\DTO\ScoreAverageRangeDTO;

class ScoreAveragePointTransformer extends AbstractTransformer
{
    private $range;

    public function transformFromArray(array $array): DTOInterface
    {
        return new ScoreAveragePointDTO($array['count'], $array['score'],$this->getDateGroup($array));
    }

    public function setRange(ScoreAverageRangeDTO $range) {
        $this->range = $range;
    }

    private function getDateGroup(array $array): string
    {
        switch ($this->range->groupBy()) {
            case ScoreAverageRangeDTO::GROUP_DAY:
                return sprintf('%d-%d-%d',$array['day'],$array['month'],$array['year']);
            case ScoreAverageRangeDTO::GROUP_WEEK:
                return sprintf('W%d %d',$array['week'],$array['year']);
            case ScoreAverageRangeDTO::GROUP_MONTH:
                return sprintf('%d-%d',$array['month'],$array['year']);
        }
    }
}
