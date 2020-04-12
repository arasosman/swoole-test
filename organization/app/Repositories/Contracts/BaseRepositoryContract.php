<?php

namespace App\Repositories\Contracts;

interface BaseRepositoryContract
{
    /**
     * Idsi verilen elemanı döner.
     * @param $entityId
     * @return  $model
     * @internal param array|int $id
     */
    public function find($entityId);

    /**
     * Idsi verilen elemanı istenilen ilişkileri ile döner.
     * @param int $entityId
     * @param array $with
     * @return  $model
     * @internal param array|int $id
     */
    public function findWith(int $entityId, array $with);

    /**
     * @param int $entityId
     * @return mixed
     */
    public function findIncludingTrashed(int $entityId);

    /**
     * @param int $entityId
     * @param array $with
     * @return mixed
     */
    public function findWithIncludingTrashed(int $entityId, array $with);

    /**
     * @param  $attributes
     * @return static
     */
    public function firstOrCreate($attributes);

    /**
     * Kaynağın tüm elemanlarını döner
     * @return mixed
     */
    public function all();

    /**
     * @param array $with
     * @return mixed
     */
    public function allWith(array  $with);

    /**
     * Sayfalanmış koleksiyon döner.
     * @param array $params
     * @return mixed
     */
    public function paginate($params = []);

    /**
     * Yeni kayıt oluşturur.
     * @param array $data
     * @return mixed
     */
    public function create($data);

    /**
     * Create or update resource
     *
     * @param  $attributes
     * @param  $values
     * @return mixed
     */
    public function updateOrCreate($attributes, $values = []);

    /**
     * Kaydı günceller.
     * @param  $model
     * @param array $data
     * @return mixed
     */
    public function update($model, $data);

    /**
     * Kaydı kaldırır.
     * @param $model
     * @return mixed
     */
    public function destroy($model);

    /**
     * @param $model
     * @return mixed
     */
    public function purge($model);

    /**
     * Özellikleri verilen bir kaydı bulur.
     * @param array $attributes
     * @return object
     */
    public function findByAttributes(array $attributes);

    /**
     * Özellikleri verilen bir çok kaydı bulur.
     * @param array $attributes
     * @return object
     */
    public function findManyByAttributes(array $attributes);

    /**
     * @return mixed
     */
    public function getModel();

    /**
     * @param $model
     * @param null $servicePrefix
     * @return $this
     */
    public function setModel($model);
}
