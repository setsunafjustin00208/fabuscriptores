<?php

namespace App\Libraries;

use MongoDB\Client;

class MongoDBLibrary
{
    protected $client;
    protected $db;

    public function __construct()
    {
        $connectionString = getenv('monogo.default.connectionstring');
        if (!$connectionString) {
            throw new \Exception('MongoDB connection string not set in environment variables.');
        }

        $this->client = new Client($connectionString);

        // Optionally, set a default database from the connection string or .env
        $defaultDb = getenv('mongodb.default.database');
        if ($defaultDb) {
            $this->db = $this->client->selectDatabase($defaultDb);
        }
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getDatabase($dbName = null)
    {
        if ($dbName) {
            return $this->client->selectDatabase($dbName);
        }
        if ($this->db) {
            return $this->db;
        }
        throw new \Exception('No database specified or set as default.');
    }

    public function getCollection($collection, $dbName = null)
    {
        $db = $this->getDatabase($dbName);
        return $db->selectCollection($collection);
    }

    // Ping the MongoDB server
    public function ping()
    {
        try {
            $result = $this->client->selectDatabase('admin')->command(['ping' => 1])->toArray();
            return isset($result[0]['ok']) && $result[0]['ok'] == 1;
        } catch (\Exception $e) {
            return false;
        }
    }

    // CREATE
    public function insertOne($collection, array $document, $dbName = null)
    {
        return $this->getCollection($collection, $dbName)->insertOne($document);
    }

    public function insertMany($collection, array $documents, $dbName = null)
    {
        return $this->getCollection($collection, $dbName)->insertMany($documents);
    }

    // READ
    public function findOne($collection, array $filter = [], $dbName = null, array $options = [])
    {
        return $this->getCollection($collection, $dbName)->findOne($filter, $options);
    }

    public function findMany($collection, array $filter = [], $dbName = null, array $options = [])
    {
        return $this->getCollection($collection, $dbName)->find($filter, $options)->toArray();
    }

    // UPDATE
    public function updateOne($collection, array $filter, array $update, $dbName = null, array $options = [])
    {
        return $this->getCollection($collection, $dbName)->updateOne($filter, $update, $options);
    }

    public function updateMany($collection, array $filter, array $update, $dbName = null, array $options = [])
    {
        return $this->getCollection($collection, $dbName)->updateMany($filter, $update, $options);
    }

    // DELETE
    public function deleteOne($collection, array $filter, $dbName = null, array $options = [])
    {
        return $this->getCollection($collection, $dbName)->deleteOne($filter, $options);
    }

    public function deleteMany($collection, array $filter, $dbName = null, array $options = [])
    {
        return $this->getCollection($collection, $dbName)->deleteMany($filter, $options);
    }
}