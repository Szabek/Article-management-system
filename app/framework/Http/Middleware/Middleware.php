<?php

namespace Szabek\Framework\Http\Middleware;

use Szabek\Framework\Http\Request;
use Szabek\Framework\Http\Response;

interface Middleware
{
    public function process(Request $request, callable $next): Response;
}