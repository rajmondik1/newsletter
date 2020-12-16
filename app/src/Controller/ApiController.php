<?php


namespace App\Controller;


use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiController extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * ApiController constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }


    /**
     * @param null $data Data to return
     * @param array|null $groups JMS Groups
     * @param int $status HTTP Status code
     * @param array $headers Additional headers
     * @return Response
     */
    protected function show($data = null, array $groups = null, int $status = 200, array $headers = []): Response
    {
        if (null == $data) {
            return new Response(null, Response::HTTP_NO_CONTENT, $headers);
        }

        $context = new SerializationContext();
        $context->setSerializeNull(true);
        if (null !== $groups) {
            $context->setGroups($groups);
        }

        $json = $this->serializer->serialize($data, 'json', $context);

        return new JsonResponse($json, $status, $headers, true);
    }

}