<?php

/**
 * Base Controller
 * php version 7.4.16
 *
 * @category Controller
 * @package  Http\Controller
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Qyon\ServiceLayer\Service\Contract\ServiceInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BaseController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * service
     *
     * @var ServiceInterface
     */
    protected $service;
    protected $model;

    /**
     * Construct function
     *
     * @param ServiceInterface $service Service sendo instanciando
     * @param $model   Model Principal
     */
    public function __construct(ServiceInterface $service, $model)
    {
        $this->service = $service;
        $this->model   = $model;
    }

    /**
     * Index function
     *
     * @param Request $request Form Request da Rota
     */
    public function index(Request $request)
    {
        if (!isset($request->per_page)) {
            $request->per_page = 50;
        }

        return $this->service->index($request->all(), $this->model)->getMessageDTO();
    }

    /**
     * Atualizar
     *
     * @param  mixed $request
     * @param  mixed $id
     */
    public function update(Request $request, int $id)
    {
        return $this->service->update($request->all(), $id, $this->model)->getMessageDTO();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id Parametro identificador Principal
     */
    public function show(int $id)
    {
        return $this->service->show($id, $this->model)->getMessageDTO();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id Parametro identificador Principal
     */
    public function destroy(int $id)
    {
        return $this->service->destroy($id, $this->model)->getMessageDTO();
    }

    /**
     * status the specified resource from storage.
     */
    public function status()
    {
        return $this->service->status($this->model)->getMessageDTO();
    }
}
