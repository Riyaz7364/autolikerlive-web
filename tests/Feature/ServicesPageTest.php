<?php

namespace Tests\Feature;

use Tests\TestCase;

class ServicesPageTest extends TestCase
{
    public function test_instagram_views_tool_is_listed_and_category_filters_are_loaded(): void
    {
        $this->get(route('services'))
            ->assertOk()
            ->assertSee(route('free-instagram-views'), false)
            ->assertSee('Instagram Auto Views')
            ->assertSee("onclick=\"filterTools('instagram', this)\"", false)
            ->assertSee('function filterTools(cat, tab)', false)
            ->assertSee('tab.classList.add(\'active\')', false);
    }
}
