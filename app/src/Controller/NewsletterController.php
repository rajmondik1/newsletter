<?php


namespace App\Controller;


use App\Entity\NewsletterSubscription;
use App\Service\NewsletterSubscriptionService;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="newsletter_")
 * Class NewsletterController
 * @package App\Controller
 */
class NewsletterController extends ApiController
{
    // TODO: Implement exceptions

    /**
     * @Route("", name="list", methods={"GET"})
     *
     * @param NewsletterSubscriptionService $service
     * @return Response
     */
    public function list(Request $request, NewsletterSubscriptionService $service): Response
    {
        $options['order'] = $request->query->get('order');
        $options['category'] = $request->query->get('category');

        return $this->show($service->list($options));

    }

    /**
     * @Route("/{id}", name="view", methods={"GET"})
     *
     * @param string $id
     * @return Response
     */
    public function view(string $id, NewsletterSubscriptionService $service): Response
    {
        return $this->show($service->view($id));
    }

    /**
     * @Route("", name="create", methods={"POST"})
     *
     * @param Request $request
     * @param NewsletterSubscriptionService $service
     * @return Response
     */
    public function create(Request $request, NewsletterSubscriptionService $service): Response
    {
        return $this->show($service->create($request->getContent()));
    }

    /**
     * @Route("", name="edit", methods={"PUT"})
     *
     *
     * @param Request $request
     * @param NewsletterSubscriptionService $service
     * @return Response
     * @throws \JsonException
     */
    public function edit(Request $request, NewsletterSubscriptionService $service): Response
    {
        $object = (object)json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $sub = new NewsletterSubscription();
        $sub
            ->setId($object->id)
            ->setEmail($object->email)
            ->setCategory($object->category);

        return $this->show($service->edit($sub));
    }

    /**
     * @Route("{id}", methods={"DELETE"})
     *
     * @param NewsletterSubscriptionService $service
     * @param string $id
     * @return Response
     */
    public function remove(NewsletterSubscriptionService $service, string $id): Response
    {
        return $this->show($service->delete($id));

    }

}