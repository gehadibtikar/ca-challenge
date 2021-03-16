<?php

namespace App\Controller;

use App\DTO\ScoreAverageRangeDTO;
use App\Repository\ReviewRepository;
use App\Service\ReviewService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OvertimeApiController extends AbstractController
{


    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var ReviewService
     */
    private $reviewService;
    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct(
        ValidatorInterface $validator,
        ReviewService $reviewService,
        SerializerInterface $serializer
    )
    {
        $this->validator = $validator;
        $this->reviewService = $reviewService;
        $this->serializer = $serializer;
    }

    /**
     * @Route(
     *     "/api/hotel/{hotelId}/overtime",
     *     methods={"GET"},
     *     requirements={
     *               "hotelId"="\d+"
     *          }
     *     )
     * @param Request $request
     * @param int $hotelId
     * @return Response
     */
    public function index(Request $request, int $hotelId): Response
    {
        $from = $request->get('from', date('Y-m-d',strtotime("-14 days")));
        $to = $request->get('to', date('Y-m-d'));

        $scoreAverageRangeDTO = new ScoreAverageRangeDTO($from, $to);


        /** @var ConstraintViolationList $validation */
        $errors = $this->validator->validate($scoreAverageRangeDTO);

        if(count($errors) > 0) {
            throw new ValidatorException((string) $errors);
        }

        $response = $this->reviewService->getAverageScoreByRange($hotelId, $scoreAverageRangeDTO);
        die(var_dump($this->serializer->serialize($response,'json')));
        return $this->json();
    }
}
