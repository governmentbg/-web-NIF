<?php

declare(strict_types=1);

namespace nif\middleware;

use base\middleware\OWASP as BaseOWASP;
use vakata\http\Request;
use vakata\http\Response;

class OWASP extends BaseOWASP
{
    /**
     * @param Request $req
     * @param callable(Request):Response $next
     * @return Response
     */
    public function __invoke(Request $req, callable $next): Response
    {
        $res = parent::__invoke($req, $next);

        return $res->withHeader('Cross-Origin-Embedder-Policy', 'unsafe-none');
    }
}
