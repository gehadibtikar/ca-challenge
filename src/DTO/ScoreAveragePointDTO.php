<?php


namespace App\DTO;

class ScoreAveragePointDTO implements DTOInterface
{

    /**
     * @var int
     */
    private $reviewCount;
    /**
     * @var float
     */
    public $averageScore;
    /**
Z     * @var string
     */
    private $dateGroup;

    public function __construct(int $reviewCount, float $averageScore, string $dateGroup)
    {

        $this->reviewCount = $reviewCount;
        $this->averageScore = $averageScore;
        $this->dateGroup = $dateGroup;
    }

    /**
     * @return int
     */
    public function getReviewCount(): int
    {
        return $this->reviewCount;
    }

    /**
     * @return float
     */
    public function getAverageScore(): float
    {
        return $this->averageScore;
    }

    /**
     * @return string
     */
    public function getDateGroup(): string
    {
        return $this->dateGroup;
    }
}