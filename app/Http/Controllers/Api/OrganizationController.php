<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MatrixRequest;
use App\Services\ContainerOrganizer;

class OrganizationController extends Controller
{
    protected $service;

    public function __construct(ContainerOrganizer $service)
    {
        $this->service = $service;
    }

    public function check(MatrixRequest $request)
    {
        return response()->json(
            $this->service->canOrganize($request->matrix)
        );
    }
}