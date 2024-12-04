<?php

namespace App\Http\Controllers;

use App\Http\Request\PoolCrudRequest;
use App\Service\PollManageService;
use Illuminate\Http;

class PollResourceController extends Controller
{
    /**
     * @var PollManageService
     */
    protected $crud;

    /**
     * PoolResourceController constructor.
     *
     * @param PollManageService $service
     */
    public function __construct(PollManageService $service)
    {
        $this->crud = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        return $this->crud->fetch();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Http\Request|PoolCrudRequest $request
     *
     * @return mixed
     */
    public function store(PoolCrudRequest $request)
    {
        return $this->crud->create($request->values());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function show($id)
    {
        return $this->crud->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Http\Request|PoolCrudRequest $request
     * @param int                          $id
     *
     * @return mixed
     */
    public function update(PoolCrudRequest $request, $id)
    {
        return $this->crud->update($id, $request->values());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return void
     */
    public function destroy($id)
    {
        $this->crud->remove($id);
    }
}
