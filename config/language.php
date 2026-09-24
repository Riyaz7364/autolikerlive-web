<?php

return [
    // English-only site. 'bn' kept ONLY as legacy redirect (old indexed /bn/* -> root).
    // No bn content is served. See routes/web.php language redirect.
    'allowed_languages' => ['en', 'bn'],
];
