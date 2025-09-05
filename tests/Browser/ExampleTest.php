<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     */
    public function testBasicExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('https://www.facebook.com/100089569266466/posts/pfbid0VQ7Z7mbbqUew5VmrgFKeQ8KG9C2SCEWAhozofKRUyR3EmR2qMi5uLKgXK1VdJVDWl/')
                    ->assertSee('Laravel');
        });
    }
}
