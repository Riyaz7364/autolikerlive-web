<?php

namespace Tests\Unit;

use App\Services\FacebookShareUrlResolver;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Tests\TestCase;

class FacebookShareUrlResolverTest extends TestCase
{
    public function test_canonicalize_removes_query_and_fragment_from_final_facebook_url(): void
    {
        $resolver = new FacebookShareUrlResolver;

        $url = $resolver->canonicalize(
            'https://www.facebook.com/mohd.mustakim.52035?rdid=aJJiUxmAPCe0A2Ms&share_url=https%3A%2F%2Fwww.facebook.com%2Fshare%2F1DLFL6kGrw#'
        );

        $this->assertSame('https://www.facebook.com/mohd.mustakim.52035', $url);
    }

    public function test_share_url_resolves_to_the_final_facebook_path_without_query(): void
    {
        Http::fakeSequence('https://www.facebook.com/share/1DLFL6kGrw/*')
            ->push(null, 302, ['Location' => 'https://www.facebook.com/mohd.mustakim.52035?rdid=aJJiUxmAPCe0A2Ms&share_url=encoded#'])
            ->push();

        $url = (new FacebookShareUrlResolver)->resolve('https://www.facebook.com/share/1DLFL6kGrw/');

        $this->assertSame('https://www.facebook.com/mohd.mustakim.52035', $url);
        Http::assertSentCount(2);
    }

    public function test_redirect_to_another_host_is_rejected_before_following_it(): void
    {
        Http::fakeSequence('https://www.facebook.com/share/1DLFL6kGrw/*')
            ->push(null, 302, ['Location' => 'https://example.com/profile']);

        try {
            (new FacebookShareUrlResolver)->resolve('https://www.facebook.com/share/1DLFL6kGrw/');
            $this->fail('Expected a redirect to another host to be rejected.');
        } catch (RuntimeException) {
            Http::assertSentCount(1);
        }
    }

    public function test_non_share_urls_are_returned_without_a_request(): void
    {
        Http::fake();

        $url = 'https://www.facebook.com/mohd.mustakim.52035?ref=profile';
        $resolved = (new FacebookShareUrlResolver)->resolve($url);

        $this->assertSame($url, $resolved);
        Http::assertNothingSent();
    }

    public function test_share_urls_on_other_hosts_are_rejected_without_a_request(): void
    {
        Http::fake();

        try {
            (new FacebookShareUrlResolver)->resolve('https://example.com/share/1DLFL6kGrw/');
            $this->fail('Expected a non-Facebook share URL to be rejected.');
        } catch (RuntimeException) {
            Http::assertNothingSent();
        }

    }
}
