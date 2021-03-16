<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ScoreAverageRangeDTO implements DTOInterface
{

    const GROUP_DAY = 'day';
    const GROUP_WEEK = 'week';
    const GROUP_MONTH = 'month';

    private $group;

    const GROUP_RANGE = [
        self::GROUP_DAY => [1, 29],
        self::GROUP_WEEK => [30, 89]
    ];

    /**
     * @Assert\Date
     * @var string
     */
    private $from;

    /**
     * @Assert\Date
     * @var string
     */
    private $to;

    /**
     * ScoreAverageRangeDTO constructor.
     * @param string $from
     * @param string $to
     */
    public function __construct(string $from, string $to)
    {

        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    public function groupBy(): string
    {
        if(isset($this->group)) return $this->group;

        $this->group = self::GROUP_MONTH;
        $days = $this->diffInDays();
        foreach (self::GROUP_RANGE as $group => $range) {
            if ($days >= $range[0] && $days <= $range[1]) {
                $this->group = $group;
                break;
            }
        }

        return $this->group;
    }

    private function diffInDays(): int
    {
        $interval = date_create($this->to)->diff(date_create($this->from));

        return $interval->days;
    }

    /**
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     */
    public function validate(ExecutionContextInterface $context)
    {
        if (date_create($this->from) > date_create($this->to)) {
            $context->buildViolation('Start date must be earlier than end date')
                ->atPath('to')
                ->addViolation();
        }
    }
}