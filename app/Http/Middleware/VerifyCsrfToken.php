<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [

        'login*','product*','rate*','ticket*','service*','coupon*','multiTickets*','register*','identities*',
        'reseed*', 'seed_all*', 'cart*', 'payment*','logout*','layout*','orders*','clean*', 'seed*', 'behaviour*',
        'link*','order*', 'widget*', 'hotel*', 'room*'

    ];
}
