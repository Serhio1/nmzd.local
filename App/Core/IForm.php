<?php

namespace App\Core;

use Symfony\Component\HttpFoundation\Request;

interface IForm
{

    public function build($config);

    public function validate(Request $request);

    public function submit(Request $request);

}