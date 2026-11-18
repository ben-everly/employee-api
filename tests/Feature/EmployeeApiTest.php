<?php

namespace Tests\Feature;

use Tests\TestCase;

class EmployeeApiTest extends TestCase
{
    public function test_index_returns_all_employees(): void
    {
        $this->getJson('/api/employees')
            ->assertOk()
            ->assertJsonCount(2)
            ->assertJsonPath('0.email', 'john.smith@example.com');
    }

    public function test_show_returns_the_employee(): void
    {
        $this->getJson('/api/employees/1')
            ->assertOk()
            ->assertExactJson([
                'id' => 1,
                'firstName' => 'John',
                'lastName' => 'Smith',
                'email' => 'john.smith@example.com',
            ]);
    }

    public function test_show_returns_404_for_unknown_employee(): void
    {
        $this->getJson('/api/employees/999')
            ->assertNotFound()
            ->assertJsonPath('message', 'Employee 999 not found.');
    }

    public function test_show_returns_404_for_non_numeric_id(): void
    {
        $this->getJson('/api/employees/abc')
            ->assertNotFound();
    }

    public function test_store_creates_an_employee(): void
    {
        $this->postJson('/api/employees', [
            'firstName' => 'Ben',
            'lastName' => 'Everly',
            'email' => 'ben.everly@example.com',
        ])
            ->assertCreated()
            ->assertExactJson([
                'id' => 3,
                'firstName' => 'Ben',
                'lastName' => 'Everly',
                'email' => 'ben.everly@example.com',
            ]);

        $this->getJson('/api/employees/3')->assertOk();
    }

    public function test_store_ignores_client_supplied_id(): void
    {
        $this->postJson('/api/employees', [
            'id' => 1,
            'firstName' => 'Ben',
            'lastName' => 'Everly',
            'email' => 'ben.everly@example.com',
        ])
            ->assertCreated()
            ->assertJsonPath('id', 3);
    }

    public function test_store_requires_all_fields(): void
    {
        $this->postJson('/api/employees', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['firstName', 'lastName', 'email']);
    }

    public function test_store_rejects_an_invalid_email(): void
    {
        $this->postJson('/api/employees', [
            'firstName' => 'Ben',
            'lastName' => 'Everly',
            'email' => 'not-an-email',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['email'])
            ->assertJsonMissingValidationErrors(['firstName', 'lastName']);
    }

    public function test_destroy_deletes_the_employee(): void
    {
        $this->deleteJson('/api/employees/1')
            ->assertNoContent();

        $this->getJson('/api/employees/1')->assertNotFound();
    }

    public function test_destroy_returns_404_for_unknown_employee(): void
    {
        $this->deleteJson('/api/employees/999')
            ->assertNotFound()
            ->assertJsonPath('message', 'Employee 999 not found.');
    }
}
