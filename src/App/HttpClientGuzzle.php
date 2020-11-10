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

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class HttpClientGuzzle.
 */
class HttpClientGuzzle implements ClientInterface
{
    /**
     * Make the request.
     *
     * @param CacheConnectionInterface $connection
     * @param array                    $requestArray
     *
     * @throws GuzzleException
     *
     * @return string
     */
    public function request(CacheConnectionInterface $connection, array $requestArray): string
    {
        $client = new Client();
        $uri    = $this->getHost().'?'.http_build_query($requestArray);

        $response = $client->request('GET', $uri, [
            'auth' => [
                $this->getUsername(),
                $this->getPassword(),
            ],
        ]);

        return json_decode($response);
    }
}
