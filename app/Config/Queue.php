<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter Queue.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Config;

use CodeIgniter\Queue\Config\Queue as BaseQueue;
use CodeIgniter\Queue\Exceptions\QueueException;
use CodeIgniter\Queue\Handlers\DatabaseHandler;
use CodeIgniter\Queue\Handlers\PredisHandler;
use CodeIgniter\Queue\Handlers\RedisHandler;
use CodeIgniter\Queue\Interfaces\JobInterface;
use CodeIgniter\Queue\Interfaces\QueueInterface;

class Queue extends BaseQueue
{
    /**
     * Default handler.
     */
    public string $defaultHandler = 'predis';

    /**
     * Available handlers.
     *
     * @var array<string, class-string<QueueInterface>>
     */
    public array $handlers = [
        'database' => DatabaseHandler::class,
        'redis'    => RedisHandler::class,
        'predis'   => PredisHandler::class,
    ];

    /**
     * Database handler config.
     */
    public array $database = [
        'dbGroup'   => 'default',
        'getShared' => true,
        // use skip locked feature to maintain concurrency calls
        // this is not relevant for the SQLite3 database driver
        'skipLocked' => true,
    ];

    /**
     * Redis handler config.
     */
    public array $redis = [
        'host'     => '127.0.0.1',
        'password' => null,
        'port'     => 6379,
        'timeout'  => 0,
        'database' => 0,
        'prefix'   => '',
    ];

    /**
     * Predis handler config.
     */
    public array $predis = [
        'scheme'   => 'tcp',
        'host'     => '127.0.0.1',
        'password' => null,
        'port'     => 6379,
        'timeout'  => 5,
        'database' => 0,
        'prefix'   => '',
    ];

    /**
     * Whether to keep the DONE jobs in the queue.
     */
    public bool $keepDoneJobs = false;

    /**
     * Whether to save failed jobs for later review.
     */
    public bool $keepFailedJobs = true;

    /**
     * Default priorities for the queue
     * if different from the "default".
     */
    public array $queueDefaultPriority = [];

    /**
     * Valid priorities in the order for the queue,
     * if different from the "default".
     */
    public array $queuePriorities = [];

    /**
     * Your jobs handlers.
     *
     * @var array<string, class-string<JobInterface>>
     */
    public array $jobHandlers = [
        'email' => \App\Jobs\Email::class
    ];

}
