<?php

namespace App\Test\Controller;

use App\Entity\CompanyProfile;
use App\Repository\CompanyProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompanyProfileControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CompanyProfileRepository $repository;
    private string $path = '/company/profile/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(CompanyProfile::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('CompanyProfile index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'company_profile[company_name]' => 'Testing',
            'company_profile[registration_code]' => 'Testing',
            'company_profile[vat]' => 'Testing',
            'company_profile[adress]' => 'Testing',
            'company_profile[mobile_phone]' => 'Testing',
            'company_profile[turnover]' => 'Testing',
            'company_profile[created_at]' => 'Testing',
            'company_profile[updated_at]' => 'Testing',
        ]);

        self::assertResponseRedirects('/company/profile/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new CompanyProfile();
        $fixture->setCompany_name('My Title');
        $fixture->setRegistration_code('My Title');
        $fixture->setVat('My Title');
        $fixture->setAdress('My Title');
        $fixture->setMobile_phone('My Title');
        $fixture->setTurnover('My Title');
        $fixture->setCreated_at('My Title');
        $fixture->setUpdated_at('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('CompanyProfile');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new CompanyProfile();
        $fixture->setCompany_name('My Title');
        $fixture->setRegistration_code('My Title');
        $fixture->setVat('My Title');
        $fixture->setAdress('My Title');
        $fixture->setMobile_phone('My Title');
        $fixture->setTurnover('My Title');
        $fixture->setCreated_at('My Title');
        $fixture->setUpdated_at('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'company_profile[company_name]' => 'Something New',
            'company_profile[registration_code]' => 'Something New',
            'company_profile[vat]' => 'Something New',
            'company_profile[adress]' => 'Something New',
            'company_profile[mobile_phone]' => 'Something New',
            'company_profile[turnover]' => 'Something New',
            'company_profile[created_at]' => 'Something New',
            'company_profile[updated_at]' => 'Something New',
        ]);

        self::assertResponseRedirects('/company/profile/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getCompany_name());
        self::assertSame('Something New', $fixture[0]->getRegistration_code());
        self::assertSame('Something New', $fixture[0]->getVat());
        self::assertSame('Something New', $fixture[0]->getAdress());
        self::assertSame('Something New', $fixture[0]->getMobile_phone());
        self::assertSame('Something New', $fixture[0]->getTurnover());
        self::assertSame('Something New', $fixture[0]->getCreated_at());
        self::assertSame('Something New', $fixture[0]->getUpdated_at());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new CompanyProfile();
        $fixture->setCompany_name('My Title');
        $fixture->setRegistration_code('My Title');
        $fixture->setVat('My Title');
        $fixture->setAdress('My Title');
        $fixture->setMobile_phone('My Title');
        $fixture->setTurnover('My Title');
        $fixture->setCreated_at('My Title');
        $fixture->setUpdated_at('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/company/profile/');
    }
}
