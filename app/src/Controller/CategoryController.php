<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categories")
 *
 * Class CategoryController
 * @package App\Controller
 */
class CategoryController extends ApiController
{
    /**
     * @Route("", methods={"GET"})
     *
     * @return Response
     */
    public function list(): Response
    {
        $categories = [
            'Business',
            'IT',
            'Marketing',
            'Security'
        ];
        return $this->show($categories);
    }
}