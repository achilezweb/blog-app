<?php

namespace Tests\Feature;

use App\Models\Privacy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\PrivacySeeder;

class PrivacyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_seeds_privacies_correctly()
    {
        // Run the CategorySeeder
        $this->seed(PrivacySeeder::class);

        // Check if all categories are in the database
        $privacies = Privacy::all();
        $this->assertCount(5, $privacies); // 10 categories in the seeder

        // Check if each category name matches the expected name
        $expectedPrivacies = [
            'Public',
            'Friends',
            'Only Me',
            'Custom',
            'Others',
        ];

        foreach ($expectedPrivacies as $index => $expectedPrivacy) {
            $this->assertEquals($expectedPrivacy, $privacies[$index]->name);
        }
    }
}
