<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExportCsvControllerTest extends WebTestCase
{
    public function testExportCsv(): void
    {
        $client = static::createClient();

        $userRepo = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepo->findOneByEmail('admin@example.com');
        $client->loginUser($testUser);
        $client->followRedirects();

        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();

        $button = $crawler->filter('#button-exportcsv_13')->link();

        $client->click($button);

        $this->assertEquals(true, $client->getResponse()->isOk());
        $this->assertSame('text/csv; charset=UTF-8', $client->getResponse()->headers->get('content_type'));
        $this->assertSame('attachment; filename="TODO.csv"', $client->getResponse()->headers->get('content_disposition'));


    }
}
