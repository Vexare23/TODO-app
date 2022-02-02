<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\TODO;
use App\Repository\TODORepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<TODO>
 *
 * @method static TODO|Proxy createOne(array $attributes = [])
 * @method static TODO[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static TODO|Proxy find(object|array|mixed $criteria)
 * @method static TODO|Proxy findOrCreate(array $attributes)
 * @method static TODO|Proxy first(string $sortedField = 'id')
 * @method static TODO|Proxy last(string $sortedField = 'id')
 * @method static TODO|Proxy random(array $attributes = [])
 * @method static TODO|Proxy randomOrCreate(array $attributes = [])
 * @method static TODO[]|Proxy[] all()
 * @method static TODO[]|Proxy[] findBy(array $attributes)
 * @method static TODO[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static TODO[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static TODORepository|RepositoryProxy repository()
 * @method TODO|Proxy create(array|callable $attributes = [])
 */
final class TODOFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->sentence(),
            'description' => self::faker()->text(30),
            'datetime' => self::faker()->dateTimeInInterval('1 year', '2 years'),
            'assignedTo' => UserFactory::random(),
            'status' => true,
        ];
    }

    protected function initialize(): self
    {
        return $this
        ;
    }

    protected static function getClass(): string
    {
        return TODO::class;
    }
}
