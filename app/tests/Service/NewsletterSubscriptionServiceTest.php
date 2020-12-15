<?php


namespace Service;


use App\Entity\NewsletterSubscription;
use App\Service\NewsletterSubscriptionService;
use App\Util\FileHandler;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class NewsletterSubscriptionServiceTest extends WebTestCase
{
    private NewsletterSubscriptionService $service;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->service = $this->getMockBuilder(NewsletterSubscriptionService::class)
            ->setConstructorArgs([new FileHandler(__DIR__), new Serializer()])
            ->getMock();
    }

    protected function setUp()
    {
        parent::setUp();
    }

    public function testCreate()
    {
        $content = '{ "email" : "petras@gmail.com", "category" : "IT"}';
        $sub = new NewsletterSubscription();
        $expected = [ $sub ];


        $result = $this->service->create($content);

        self::assertEquals($expected, $result);
    }

    public function testList()
    {

    }

    public function testView()
    {

    }

    public function testEdit()
    {

    }

    public function testDelete()
    {

    }

    public function testGetId()
    {

    }

    public function testFilterByCategory()
    {

    }


}