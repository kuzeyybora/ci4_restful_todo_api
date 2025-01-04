<?php
namespace App\Models;

use MongoDB\Client;
use Config\MongoDB;

class MongoDBModel
{
    protected $client;
    protected $db;
    protected $collection;

    public function __construct(string $collectionName)
    {
        $config = new MongoDB();

        $this->client = new Client($config->uri);
        $this->db = $this->client->selectDatabase($config->database);
        $this->collection = $this->db->selectCollection($collectionName);
    }

    public function insert(array $data)
    {
        return $this->collection->insertOne($data);
    }

    public function find(array $filter = [], array $options = [])
    {
        return $this->collection->find($filter, $options)->toArray();
    }

    public function findOne(array $filter = [])
    {
        return $this->collection->findOne($filter);
    }

    public function update(array $filter, array $data)
    {
        return $this->collection->updateOne($filter, ['$set' => $data]);
    }

    public function delete(array $filter)
    {
        return $this->collection->deleteOne($filter);
    }
}
