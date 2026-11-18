<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ApiErrorResponseTest extends TestCase
{
    public function test_validation_errors_render_as_json_without_accept_header(): void
    {
        Route::post('/api/test-validation', fn (Request $request) => $request->validate([
            'name' => 'required',
        ]));

        $this->post('/api/test-validation')
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }

    public function test_not_found_renders_as_json_without_accept_header(): void
    {
        $this->get('/api/does-not-exist')
            ->assertNotFound()
            ->assertJsonStructure(['message']);
    }
}
