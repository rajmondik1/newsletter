<?php


namespace App\Controller;


use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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


    /**
     * Return form errors to JSON
     *
     * @param FormInterface $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function formError(FormInterface $form)
    {
        $errorObj = $form->getErrors(true);
        return $this->show($errorObj, null, 400);
    }


    /**
     * Creates a form from Type class for data sent through POST method
     *
     * @param string $type Form type class. Usually looks similar to SomethingType::class
     * @param mixed $entity Entity object
     * @param array $options Form options such as validation groups
     * @return \Symfony\Component\Form\Form|FormInterface
     */
    protected function createPostForm($type = FormType::class, $entity = null, array $options = [])
    {
        return $this->get('form.factory')->createNamed('', $type, $entity, $options);
    }

    /**
     * Creates a form from Type class for data sent through PUT method
     *
     * @param string $type Form type class. Usually looks similar to SomethingType::class
     * @param mixed $entity Entity object
     * @param array $options Form options such as validation groups
     * @return \Symfony\Component\Form\Form|FormInterface
     */
    protected function createPutForm($type = FormType::class, $entity = null, array $options = [])
    {
        $options['method'] = 'PUT';
        return $this->get('form.factory')->createNamed('', $type, $entity, $options);
    }

    /**
     * Creates a form from Type class for data sent through PATCH method
     *
     * @param string $type Form type class. Usually looks similar to SomethingType::class
     * @param null $entity Entity object
     * @param array $options Form options such as validation groups
     * @return \Symfony\Component\Form\Form|FormInterface
     */
    protected function createPatchForm($type = FormType::class, $entity = null, array $options = [])
    {
        $options['method'] = 'PATCH';
        return $this->get('form.factory')->createNamed('', $type, $entity, $options);
    }

    /**
     * Handles POST form submission and generates a response object for controller to return.
     * WARNING: This will flush the EntityManager
     * If form is valid tries to persist the entity and generates a response showing entity
     * with status code 201 Created
     * Else generates a response with form error and status code 400 Bad Request.
     *
     * @param Request $request Request object to handle
     * @param FormInterface $form Form that will be handled
     * @param mixed $entity Entity that is being handled and persisted to DB
     * @param array|null $groups JMS Serializer groups. Strongly recommended to be set
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handlePost(Request $request, FormInterface $form, $entity, array $groups = null)
    {
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->show($entity, $groups, 201);
        }

        return $this->formError($form);
    }

    /**
     * Handles PUT form submission and generates a response object for controller to return.
     * WARNING: This will flush the EntityManager
     * If form is valid tries to flush the entity manager and generates a response showing entity
     * with status code 200 OK
     * Else generates a response with form error and status code 400 Bad Request.
     *
     * @param Request $request Request object to handle
     * @param FormInterface $form Form that will be handled
     * @param mixed $entity Entity that is being handled and flushed to DB
     * @param array|null $groups JMS Serializer groups. Strongly recommended to be set
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handlePut(Request $request, FormInterface $form, $entity, array $groups = null)
    {
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->show($entity, $groups);
        }

        return $this->formError($form);
    }

    /**
     * Deletes the entity from the database.
     * WARNING: This will flush the EntityManager
     *
     * @param $entity
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleDelete($entity)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            if ($em->getClassMetadata(get_class($entity))->hasField('deleted')) {
                $entity->setDeleted(new \DateTime());
            } else {
                $em->remove($entity);
            }
            $em->flush();

            return $this->show();
        } catch (ForeignKeyConstraintViolationException $exception) {
            return $this->show($this->get('translator')->trans('COMMON.DEPENDENCY_ERROR'), null, 400);
        }
    }

}