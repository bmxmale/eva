<?php

declare(strict_types=1);

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Helper\DatabasePrimer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

final class EndpointsTest extends ApiTestCase
{
    protected static function createKernel(array $options = []): KernelInterface
    {
        return new \App\Kernel('test', true);
    }

    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        /** @var EntityManagerInterface $em */
        $em = static::getContainer()->get(EntityManagerInterface::class);
        DatabasePrimer::createSchema($em);
    }

    public function testCreateApplicationAndFetchViaEndpoints(): void
    {
        $client = static::createClient();

        $payload = [
            'passport' => [
                'number' => 'YUBICO2025',
                'code' => 'USA',
                'type' => 'P',
                'firstName' => 'John',
                'lastName' => 'Wick',
                'issuedAt' => '2021-06-01',
                'expiresAt' => '2031-06-01'
            ],
            'visaType' => 'D',
            'purposeOfVisit' => 4,
            'startDate' => '2025-01-01',
            'endDate' => '2035-12-31',
            'status' => 'approved'
        ];

        $response = $client->request('POST', '/applications', [
            'headers' => [
                'Accept' => 'application/ld+json',
                'Content-Type' => 'application/ld+json',
            ],
            'json' => $payload,
        ]);
        self::assertResponseStatusCodeSame(201);

        // GET the application(s) by passport
        $response = $client->request('GET', '/applications/USA/YUBICO2025', [
            'headers' => [
                'Accept' => 'application/ld+json',
            ],
        ]);
        self::assertResponseIsSuccessful();

        $data = $response->toArray(false);
        self::assertIsArray($data);
        self::assertNotEmpty($data);

        // GET the passport by code/number
        $response = $client->request('GET', '/passport/USA/YUBICO2025');
        self::assertResponseIsSuccessful();
        $passport = $response->toArray(false);
        self::assertSame('YUBICO2025', $passport['number'] ?? null);
        self::assertSame('USA', $passport['code'] ?? null);
    }
}
