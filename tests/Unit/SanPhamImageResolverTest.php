<?php

namespace Tests\Unit;

use App\Models\SanPham;
use Tests\TestCase;

class SanPhamImageResolverTest extends TestCase
{
    public function test_it_resolves_existing_product_image_name(): void
    {
        $resolved = SanPham::resolveImageName('yonex_doura10.webp');

        $this->assertSame('yonex_doura10.webp', $resolved);
    }

    public function test_it_returns_default_when_image_does_not_exist(): void
    {
        $resolved = SanPham::resolveImageName('image-does-not-exist.webp');

        $this->assertSame('yonex_doura10.webp', $resolved);
    }
}
