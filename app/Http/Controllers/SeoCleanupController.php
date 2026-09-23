<?php

namespace App\Http\Controllers;

/**
 * GSC 404 cleanup: retired tag / category / dated-post archives.
 *
 * URLs with a genuine living equivalent get a 301 (keeps equity).
 * Everything else under these dead sections gets an explicit 410
 * (gone for good) so Google drops it fast instead of re-crawling
 * a 404. Query strings (?page=2, ?random-post=1) are ignored.
 */
class SeoCleanupController extends Controller
{
    public function tag(string $name)
    {
        $map = config('seo.tag_redirects', []);
        $key = self::normalize($name);

        if (isset($map[$key])) {
            return redirect($map[$key], 301);
        }

        abort(410);
    }

    public function category(string $a, ?string $b = null)
    {
        $map = config('seo.category_redirects', []);
        // Nested archives (/category/fbsub/cheap-smm-panel) are all gone.
        if ($b !== null) {
            abort(410);
        }

        $key = self::normalize($a);

        if (isset($map[$key])) {
            return redirect($map[$key], 301);
        }

        abort(410);
    }

    public function dated(string $y, string $m, string $d, ?string $slug = null)
    {
        $map = config('seo.dated_redirects', []);

        if ($slug !== null) {
            $key = strtolower(trim($slug));
            if (isset($map[$key])) {
                return redirect($map[$key], 301);
            }
        }

        // Old dated posts (incl. Bengali slugs) were removed with the
        // content pruning — gone for good, not "not found".
        abort(410);
    }

    public static function normalize(string $value): string
    {
        $value = urldecode($value);
        $value = strtolower(trim($value));
        $value = preg_replace('/[-_+]+/', ' ', $value);
        return preg_replace('/\s+/', ' ', $value);
    }
}
