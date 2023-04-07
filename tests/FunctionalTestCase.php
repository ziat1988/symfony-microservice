<?php
declare(strict_types=1);

namespace App\Tests;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FunctionalTestCase extends KernelTestCase
{
    /**
     * @var EntityManager | null
     */
    protected ?EntityManager $entityManager;
    protected ContainerInterface $container;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->container = $kernel->getContainer();

        $this->entityManager = $this->container
            ->get('doctrine')
            ->getManager();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
