<?php

namespace App\Tests\Functional\Post;

use App\Entity\Post\Tag;
use App\Entity\Post\Post;
use App\Entity\Post\Category;
use App\Repository\Post\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogTest extends WebTestCase
{
    public function testBlogPageWorks(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertSelectorExists('h1');
        $this->assertSelectorTextContains('h1', 'SymBlog : Le blog créé de A à Z avec Symfony');
    }

    public function testPaginationWorks(): void
    {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, '/');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $posts = $crawler->filter('div.card');
        $this->assertEquals(9, count($posts));

        $link = $crawler->selectLink('2')->extract(['href'])[0];
        $crawler = $client->request(Request::METHOD_GET, $link);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $posts = $crawler->filter('div.card');
        $this->assertGreaterThanOrEqual(1, count($posts));
    }

    // public function testDropdownWorks(): void
    // {
    //     $client = static::createClient();
    //     $crawler = $client->request(Request::METHOD_GET, '/');

    //     $this->assertResponseIsSuccessful();
    //     $this->assertResponseStatusCodeSame(Response::HTTP_OK);

    //     $link = $crawler->filter('.dropdown-menu > li > a')->link()->getUri();

    //     $client->request(Request::METHOD_GET, $link);

    //     $this->assertResponseIsSuccessful();
    //     $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    //     $this->assertRouteSame('category.index');
    // }



    public function testFilterSystemReturnsNoItems(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGeneratorInterface->generate('post.index')
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter('form[name=search]')->form([
            'search[q]' => 'aazzeerrttyy'
        ]);

        $crawler = $client->submit($form);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertRouteSame('post.index');

        $this->assertSelectorExists('form[name=search]');
        $this->assertSelectorNotExists('div.card');
    }
}
