<?php

namespace App\Filters;

use App\Constants\TranslationKeys;
use App\Services\RedisService;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RateLimitFilter implements FilterInterface
{
    /** @var RedisService $redis  */
    protected $redis;

    public function __construct() {
        $this->redis = service("redisService");
        helper("response");
    }
    /**
     * @param RequestInterface  $request
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $ipAddress = $request->getIPAddress();
        $key = "rateLimit:" . $ipAddress;
        $requestCount = $this->redis->get($key);

        if (!$requestCount) {
            $this->redis->set($key, 1);
        } else {
            if ($requestCount >= 50) {
                return response_fail(TranslationKeys::TOO_MANY_REQUESTS);
            }
            $this->redis->incr($key);
        }
        $this->redis->expire($key, 60);
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
