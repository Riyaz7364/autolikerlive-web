<?php

namespace App\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;

class MyPolicy extends Basic
{
    public function configure()
    {
        // parent::configure();

        // $this
        // ->addDirective(Directive::SCRIPT, 'unsafe-inline');

    }
}
