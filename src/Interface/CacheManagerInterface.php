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

use Psr\Log\LoggerInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

/**
 * Interface CacheManagerInterface.
 */
interface CacheManagerInterface
{
    /**
     * Get the time when the cache will be expired.
     *
     * @return string
     */
    public function getExpiresAt(): string;

    /**
     * Set the time when the cache will be expired.
     *
     * @param string $expiresAt
     *
     * @return void
     */
    public function setExpiresAt(string $expiresAt): void;

    /**
     * Get the cache.
     *
     * @return CacheItemPoolInterface
     */
    public function getCache(): CacheItemPoolInterface;

    /**
     * Set the cache.
     *
     * @param CacheItemPoolInterface $cache
     *
     * @return void
     */
    public function setCache(CacheItemPoolInterface $cache): void;

    /**
     * Get the logger.
     *
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface;

    /**
     * Set the logger.
     *
     * @param LoggerInterface $logger
     *
     * @return void
     */
    public function setLogger(LoggerInterface $logger): void;

    /**
     * Get the response.
     *
     * @param array $input
     *
     * @throws InvalidArgumentException
     *
     * @return array|mixed
     */
    public function getResponse(array $input): ?array;

    /**
     * Get the cache key.
     *
     * @param array $input
     *
     * @return string
     */
    public function getCacheKey(array $input): string;
}
