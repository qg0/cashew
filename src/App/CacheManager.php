<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

namespace App;

use DateTime;
use Exception;
use JsonException;
use Psr\Log\LoggerInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

/**
 * Class CacheManager.
 */
class CacheManager extends DataProvider implements CacheManagerInterface
{
    /**
     * Cache expires at.
     *
     * @var string
     */
    protected string $expiresAt;

    /**
     * Interface CacheItemPoolInterface.
     *
     * @var CacheItemPoolInterface
     */
    protected CacheItemPoolInterface $cache;

    /**
     * Interface LoggerInterface.
     *
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * Constructor.
     *
     * @param ClientInterface        $client
     * @param CacheItemPoolInterface $cache
     * @param LoggerInterface        $logger
     * @param string                 $expiresAt
     */
    public function __construct(ClientInterface $client, CacheItemPoolInterface $cache, LoggerInterface $logger, string $expiresAt = 'Now + 1 Day')
    {
        parent::__construct($client);
        $this->setCache($cache);
        $this->setLogger($logger);
        $this->setExpiresAt($expiresAt);
    }

    /**
     * Get the time when the cache will be expired.
     *
     * @return string
     */
    public function getExpiresAt(): string
    {
        return $this->expiresAt;
    }

    /**
     * Get the cache.
     *
     * @return CacheItemPoolInterface
     */
    public function getCache(): CacheItemPoolInterface
    {
        return $this->cache;
    }

    /**
     * Set the cache.
     *
     * @param CacheItemPoolInterface $cache
     *
     * @return void
     */
    public function setCache(CacheItemPoolInterface $cache): void
    {
        $this->cache = $cache;
    }

    /**
     * Set the time when the cache will be expired.
     *
     * @param string $expiresAt
     *
     * @return void
     */
    public function setExpiresAt(string $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * Get the logger.
     *
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * Set the logger.
     *
     * @param LoggerInterface $logger
     *
     * @return void
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * Get the response.
     *
     * @param array $input
     *
     * @throws InvalidArgumentException
     *
     * @return array
     */
    public function getResponse(array $input): array
    {
        try {
            $cacheKey  = $this->getCacheKey($input);
            $cacheItem = $this->getCache()->getItem($cacheKey);

            if ($cacheItem->isHit()) {
                return $cacheItem->get();
            }

            $result = $this->getData($input);

            $cacheItem
                ->set($result)
                ->expiresAt(new DateTime($this->getExpiresAt()));

            $this->getCache()->save();

            return $result;
        } catch (Exception $e) {
            $this->getLogger()->critical($e->getMessage());
            $result = [];
        }

        return $result;
    }

    /**
     * Get the cache key.
     *
     * @param array $input
     *
     * @throws JsonException
     *
     * @return string
     */
    public function getCacheKey(array $input): string
    {
        return hash('sha512', json_encode($input, JSON_THROW_ON_ERROR));
    }
}
