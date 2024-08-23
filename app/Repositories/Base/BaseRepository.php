<?php

namespace App\Repositories\Base;

use App\Models\Category;
use App\Repositories\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Arr;

/**
 * Class BaseRepository
 * @property BaseRepository $applicationRepository
 * @package App\Repositories
 */
class BaseRepository implements BaseRepositoryInterface
{
    /**
     * BaseRepository constructor.
     */

    public $model;    // public $model = "App\Models\Category";
    public $resource;
    public $paginate = 15;



    public function __construct()
    {
        $this->init();
    }
    public function init()
    {
        if (!isset($this->model) && class_exists($this->getDefaultModel()))
            $this->model = $this->getDefaultModel();

        if (!isset($this->resource) && class_exists($this->getDefaultResource()))
            $this->resource = $this->getDefaultResource();
    }


    /**
     * Get's all models.
     *
     * @return mixed
     */
    public function all()
    {
        $models = $this->resource::collection($this->indexQuery())->resolve();
    }

    public function indexQuery()
    {
        return $this->model->search(request()->query())->paginate($this->paginate);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data)
    {
        // return $this->model->create($data);
        return $this->model->create($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data)
    {
        // return $this->model->find($id)->update($data);
    }

    /**
     * Deletes a store.
     *
     * @param int
     * @return int
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }











    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    // return some variabels in functions [ GETTERS ]
    public function getModel()
    {
        return $this->getDefaultModel();
    }
    public function getRequest()
    {
        return $this->getDefaultRequest();
    }
    public function getResource($object)
    {
        return new ($this->resource)($object);
    }

    public function getDefaultModel()
    {
        $custom_model = "App\\Models\\" . str_replace(["Repositories", "Repository"], ["", ""], get_class_name($this));
        return class_exists($custom_model) ? $custom_model : BaseModel::class;
    }
    public function getDefaultRequest()
    {
        $custom_request = "App\\Http\\Requests\\" . str_replace(["Repositories", "Repository"], ["Requests", "Request"], get_class_name($this));
        $request = class_exists($custom_request) ? $custom_request : BaseRequest::class;
        return new $request;
    }
    public function getDefaultResource()
    {
        $custom_resource = "App\\Http\\Resources\\" . str_replace(["Repositories", "Repository"], ["Resources", "Resource"], get_class_name($this));
        return class_exists($custom_resource) ? $custom_resource : BaseResource::class;
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////

}
