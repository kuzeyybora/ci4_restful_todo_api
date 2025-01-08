<?php
/**
 * MongoDB model class for interacting with MongoDB collections.
 */
namespace App\Models;

use MongoDB\Client;
use Config\MongoDB;
use MongoDB\Collection;
use MongoDB\Database;
use MongoDB\DeleteResult;
use MongoDB\InsertOneResult;
use MongoDB\UpdateResult;

class MongoDBModel
{
    protected Client $client;
    protected Database $db;
    protected Collection $collection;

    public function __construct()
    {
        $config = new MongoDB();

        $this->client = new Client($config->uri);
        $this->db = $this->client->selectDatabase($config->database);
        $this->collection = $this->db->selectCollection('logs');
    }

    /**
     * Inserts a document into the MongoDB collection.
     *
     * @param array $data Data to be inserted into the collection.
     * @return InsertOneResult The result of the insertion operation.
     */
    public function insert(array $data): InsertOneResult
    {
        return $this->collection->insertOne($data);
    }

    /**
     * Retrieves documents from the MongoDB collection based on the provided filter.
     *
     * @param array $filter The filter criteria to find documents (default is empty).
     * @param array $options Additional options for the query (default is empty).
     * @return array An array of documents matching the filter.
     */
    public function find(array $filter = [], array $options = []): array
    {
        return $this->collection->find($filter, $options)->toArray();
    }

    /**
     * Finds a single document by its ID.
     *
     * @param int $id The ID of the document to retrieve.
     * @return array|null The document if found, or null if not.
     */
    public function findOneById(int $id): ?array
    {
        return $this->collection->findOne(['_id' => $id]);
    }

    /**
     * Updates a document in the MongoDB collection based on the provided filter.
     *
     * @param array $filter The filter criteria to find the document to update.
     * @param array $data The data to update in the document.
     * @return UpdateResult The result of the update operation.
     */
    public function update(array $filter, array $data): UpdateResult
    {
        return $this->collection->updateOne($filter, ['$set' => $data]);
    }

    /**
     * Deletes a document from the MongoDB collection based on the provided filter.
     *
     * @param array $filter The filter criteria to find the document to delete.
     * @return DeleteResult The result of the delete operation.
     */
    public function delete(array $filter): DeleteResult
    {
        return $this->collection->deleteOne($filter);
    }

    /**
     * Retrieves the model name based on the class name.
     *
     * @return string The model's class name.
     */
    public function getModelName(): string
    {
        return basename(str_replace('\\', '/', get_class($this)));
    }
}
