<?php declare( strict_types=1 );


namespace App\Contracts;


use App\Entity\Entity;

interface RepositoryInterface
{
    public function find(int $id): ?object;
    public function findOneBy(string $field, $value): ?object;
    public function findBy(array $criteria);
    public function findAll(int $id): array;
    public function sql(string $query);
    public function create(Entity $entity): object;
    public function update(Entity $entity, array $conditions = []): object;
    public function delete(Entity $entity, array $conditions = []): void;
}