<?php
/**
 * Created by PhpStorm.
 * User: Nyi Nyi Lwin
 * Date: 9/21/18
 * Time: 13:36
 */

namespace PhpJunior\LaravelGlobalSearch\Services;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Config\Repository;

class LaravelGlobalSearch
{
    /**
     * @var Collection
     */
    private $resources;

    private $text;
    /**
     * @var Repository
     */
    private $config;

    /**
     * LaravelGlobalSearch constructor.
     * @param Collection $resources
     * @param Repository $config
     */
    public function __construct(Collection $resources, Repository $config)
    {
        $this->resources = $resources;
        $this->config = $config;
    }

    /**
     * @param null $text
     * @return array
     */
    public function search($text = null)
    {
        $this->text = $text;
        $formatted = [];
        foreach ($this->getSearchResults() as $resource => $models) {
            $items = [];
            foreach ($models as $model) {
                if (empty($model->filterColumns())){
                    $items[] = $model->toArray();
                }else{
                    $data=[];
                    foreach ($model->filterColumns() as $column)
                    {
                        $data[$column] = $model->{$column};
                    }
                    $items[] = $data;
                }
            }
            $formatted[$resource]= $items;
        }
        return $formatted;
    }

    /**
     * Get the search results for the resources.
     *
     * @return array
     */
    protected function getSearchResults()
    {
        $results = [];
        foreach ($this->resources as $resource) {
            $model = new $resource;
            $query = $this->applySearch($model->newQuery());

            if (count($models = $query->limit($this->config->get('laravel-global-search.limit'))->get()) > 0) {
                $results[$model->getSearchIndex()] = $models;
            }
        }
        return collect($results)->sortKeys()->all();
    }

    /**
     * Apply the search query to the query.
     * @param $query
     * @return mixed
     */
    protected function applySearch($query)
    {
        if (is_numeric($this->text) && in_array($query->getModel()->getKeyType(), ['int', 'integer'])) {
            $query->whereKey($this->text);
        }

        return $query->where(function ($query) {
            foreach ($query->getModel()->orderableColumns() as $column => $sort) {
                $query->orderBy($query->getModel()->qualifyColumn($column) ,$sort);
            }
            foreach ($query->getModel()->getAdditionalWhereClauses() as $clause) {
                if (array_key_exists('operator', $clause))
                    $query->{$clause['method']}(
                        $query->getModel()->qualifyColumn($clause['column']),
                        $clause['operator'],
                        $clause['value']
                    );
                else
                    $query->{$clause['method']}(
                        $query->getModel()->qualifyColumn($clause['column']),
                        $clause['value']
                    );
            }
            foreach ($query->getModel()->searchableColumns() as $column) {
                $query->orWhere($query->getModel()->qualifyColumn($column), 'like', '%'.$this->text.'%');
            }
        });
    }
}
