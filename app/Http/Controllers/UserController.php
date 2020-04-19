<?php

namespace App\Http\Controllers;
use App\Http\Resources\UserResource;
use App\Interfaces\Services\UserServiceInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * User service.
     *
     * @var UserServiceInterface
     */
    private UserServiceInterface $service;

    /**
     * UserController constructor.
     *
     * @param UserServiceInterface $service
     */
    public function __construct(UserServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', Auth::user());

        return UserResource::collection($this->service->index());
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return UserResource
     */
    public function show(string $id)
    {
        return new UserResource($this->service->show($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $id
     * @return UserResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, string $id)
    {
        return new UserResource($this->service->update($id));
    }
}
