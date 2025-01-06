<?php
namespace App\Models;

use MongoDB\Client;
use Config\MongoDB;

class MongoDBModel
{
    protected $client;
    protected $db;
    protected $collection;

    public function __construct()
    {
        $config = new MongoDB();

        $this->client = new Client($config->uri);
        $this->db = $this->client->selectDatabase($config->database);
        $this->collection = $this->db->selectCollection('logs');
    }

    public function insert(array $data)
    {
        return $this->collection->insertOne($data);
    }

    public function find(array $filter = [], array $options = [])
    {
        return $this->collection->find($filter, $options)->toArray();
    }

    public function findOneById(int $id)
    {
        return $this->collection->findOne($id);
    }

    public function update(array $filter, array $data)
    {
        return $this->collection->updateOne($filter, ['$set' => $data]);
    }

    public function delete(array $filter)
    {
        return $this->collection->deleteOne($filter);
    }
    public function getModelName(): string
    {
        return basename(str_replace('\\', '/', get_class($this)));
    }
}
