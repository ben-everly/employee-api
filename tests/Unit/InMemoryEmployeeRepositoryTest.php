<?php

namespace Tests\Unit;

use App\Repositories\InMemoryEmployeeRepository;
use PHPUnit\Framework\TestCase;

class InMemoryEmployeeRepositoryTest extends TestCase
{
    private InMemoryEmployeeRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new InMemoryEmployeeRepository;
    }

    public function test_all_returns_seeded_employees(): void
    {
        $this->assertCount(2, $this->repository->all());
    }

    public function test_find_returns_seeded_employee(): void
    {
        $john = $this->repository->find(1);
        $this->assertSame('John', $john->firstName);
        $this->assertSame('Smith', $john->lastName);
        $this->assertSame('Jane', $this->repository->find(2)->firstName);
    }

    public function test_find_returns_null_for_unset_id(): void
    {
        $this->assertNull($this->repository->find(999));
    }

    public function test_find_by_email_returns_matching_employee_ignoring_case(): void
    {
        $this->assertSame(1, $this->repository->findByEmail('John.Smith@Example.com')?->id);
    }

    public function test_find_by_email_returns_null_for_unknown_email(): void
    {
        $this->assertNull($this->repository->findByEmail('nobody@example.com'));
    }

    public function test_create_assigns_the_next_id_and_the_employee_can_be_found(): void
    {
        $new = $this->repository->create('test', 'employee', 'test.employee@example.com');
        $this->assertSame(3, $new->id);
        $found = $this->repository->find($new->id);
        $this->assertSame($new, $found);
    }

    public function test_delete_removes_the_employee_and_returns_true(): void
    {
        $this->assertTrue($this->repository->delete(1));
        $this->assertNull($this->repository->find(1));
    }

    public function test_delete_returns_false_for_an_unset_id(): void
    {
        $this->assertFalse($this->repository->delete(999));
    }

    public function test_deleted_ids_are_not_reused(): void
    {
        $this->repository->delete(2);
        $new = $this->repository->create('test', 'employee', 'test.employee@example.com');
        $this->assertSame(3, $new->id);
    }
}
