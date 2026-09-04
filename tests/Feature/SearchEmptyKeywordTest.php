<?php

namespace Tests\Feature;

use Tests\TestCase;

class SearchEmptyKeywordTest extends TestCase
{
    public function test_empty_search_keyword_redirects_to_home(): void
    {
        $response = $this->get('/tim-kiem?keyword=' );

        $response->assertRedirect('/');
    }
}
