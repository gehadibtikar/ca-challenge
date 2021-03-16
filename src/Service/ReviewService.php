<?php


namespace App\Service;


use App\DTO\ScoreAverageRangeDTO;
use App\DTO\Transformer\ScoreAveragePointTransformer;
use App\Repository\ReviewRepository;

class ReviewService
{

    /**
     * @var ReviewRepository
     */
    private $reviewRepository;
    /**
     * @var ScoreAveragePointTransformer
     */
    private $transformer;

    /**
     * ReviewService constructor.
     * @param ReviewRepository $reviewRepository
     * @param ScoreAveragePointTransformer $transformer
     */
    public function __construct(ReviewRepository $reviewRepository, ScoreAveragePointTransformer $transformer)
    {
        $this->reviewRepository = $reviewRepository;
        $this->transformer = $transformer;
    }

    public function getAverageScoreByRange(int $hotelId, ScoreAverageRangeDTO $range): iterable
    {
        $result = $this->reviewRepository->dateAverageScore($hotelId, $range);
        $this->transformer->setRange($range);

        return $this->transformer->transformFromList($result);
    }
}