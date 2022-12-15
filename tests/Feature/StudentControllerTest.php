<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class StudentControllerTest extends TestCase
{

    /** @test */
    public function indexMethod()
    {
        Student::factory()->count(5)->make();

        $response = $this->json('GET', "/students");
        $response->assertStatus(200);
    }

    /** @test */
    public function storeMethod()
    {
        $student = Student::factory()->make();
        $response = $this->json('POST', "/student", $student->toArray());

        $response->assertStatus(200)
            ->assertJsonFragment(['success' => 1])
            ->assertJsonStructure(['success', 'data']);
    }
}
