<?php

namespace App\Libraries;

use CodeIgniter\Log\Handlers\BaseHandler;
use Config\MongoDB;
use MongoDB\Client;

class MongoDBLogger extends BaseHandler
{
    protected $collection;

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $mongoConfig = new MongoDB();

        $client = new Client($mongoConfig->uri);
        $db = $client->selectDatabase($mongoConfig->database);
        $this->collection = $db->selectCollection($mongoConfig->collection);
    }

    public function handle($level, $message): bool
    {
        if ($message == "Session: Class initialized using 'CodeIgniter\Session\Handlers\FileHandler' driver.")
        {
            return true;
        }
        $log = [
            'level'   => strtoupper($level),
            'message' => $message,
            'date'    => date('Y-m-d H:i:s'),
        ];

        $this->collection->insertOne($log);

        return true;
    }
}
