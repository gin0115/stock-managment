<?php

declare (strict_types=1);
/**
 * Wrapper around Nyholm\Psr7 library with a few helper methods and a basic emitter.
 *
 * For use in WordPress during ajax calls.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\HTTP
 */
namespace PC_Woo_Stock_Man\PinkCrab\HTTP;

use RuntimeException;
use PC_Woo_Stock_Man\WP_HTTP_Response;
use PC_Woo_Stock_Man\Nyholm\Psr7\Stream;
use PC_Woo_Stock_Man\Nyholm\Psr7\Request;
use PC_Woo_Stock_Man\Nyholm\Psr7\Response;
use InvalidArgumentException;
use PC_Woo_Stock_Man\Psr\Http\Message\UriInterface;
use PC_Woo_Stock_Man\Nyholm\Psr7\Factory\Psr17Factory;
use PC_Woo_Stock_Man\Psr\Http\Message\StreamInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\RequestInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\ResponseInterface;
use PC_Woo_Stock_Man\Nyholm\Psr7Server\ServerRequestCreator;
use PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface;
class HTTP
{
    /**
     * Returns the current request from glbals
     *
     * @uses Psr17Factory::class
     * @uses ServerRequestCreator::class
     * @return ServerRequestInterface
     */
    public function request_from_globals() : \PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface
    {
        $psr17_factory = new \PC_Woo_Stock_Man\Nyholm\Psr7\Factory\Psr17Factory();
        return (new \PC_Woo_Stock_Man\Nyholm\Psr7Server\ServerRequestCreator($psr17_factory, $psr17_factory, $psr17_factory, $psr17_factory))->fromGlobals()->withBody($this->create_stream_with_json($_POST));
        // phpcs:ignore WordPress.Security.NonceVerification.Missing
    }
    /**
     * Wrapper for making a PS7 request.
     *
     * @uses Nyholm\Psr7::Request()
     * @param string $method HTTP method
     * @param string|UriInterface $uri URI
     * @param array<string, string> $headers Request headers
     * @param string|resource|StreamInterface|null $body Request body
     * @param string $version Protocol version
     */
    public function psr7_request(string $method, $uri, array $headers = array(), $body = null, string $version = '1.1') : \PC_Woo_Stock_Man\Psr\Http\Message\RequestInterface
    {
        return new \PC_Woo_Stock_Man\Nyholm\Psr7\Request($method, $uri, $headers, $body, $version);
    }
    /**
     * Returns a PS7 Response object.
     *
     * @param int $status
     * @param array<string, string> $headers
     * @param array<string, string>|string|resource|StreamInterface|null $body
     * @param string $version
     * @param string $reason
     * @return ResponseInterface
     */
    public function psr7_response($body = null, int $status = 200, array $headers = array(), string $version = '1.1', string $reason = null) : \PC_Woo_Stock_Man\Psr\Http\Message\ResponseInterface
    {
        // Json Encode if body is array or object.
        if (\is_array($body) || \is_object($body)) {
            $body = wp_json_encode($body);
        }
        // If body is false, pass as null. @phpstan
        return new \PC_Woo_Stock_Man\Nyholm\Psr7\Response($status, $headers, $body ?: null, $version, $reason);
    }
    /**
     * Returns a WP_Rest_Response
     *
     * @param int $status
     * @param array<string, string> $headers
     * @param mixed $data
     * @return WP_HTTP_Response
     */
    public function wp_response($data = null, int $status = 200, array $headers = array()) : \WP_HTTP_Response
    {
        return new \WP_HTTP_Response($data, $status, $headers);
    }
    /**
     * Emits either a PS7 or WP_HTTP Response.
     *
     * @param ResponseInterface|WP_HTTP_Response|object $response
     * @return void
     * @throws InvalidArgumentException
     */
    public function emit_response($response) : void
    {
        // Throw if not a valid response.
        if (!$response instanceof \PC_Woo_Stock_Man\Psr\Http\Message\ResponseInterface && !$response instanceof \WP_HTTP_Response) {
            throw new \InvalidArgumentException('Only ResponseInterface & WP_REST_Response responses can be emitted.');
        }
        // Based on type, emit the response.
        if ($response instanceof \PC_Woo_Stock_Man\Psr\Http\Message\ResponseInterface) {
            $this->emit_psr7_response($response);
        } else {
            $this->emit_wp_response($response);
        }
    }
    /**
     * Emits a PSR7 response.
     *
     * @param ResponseInterface $response
     * @return void
     */
    public function emit_psr7_response(\PC_Woo_Stock_Man\Psr\Http\Message\ResponseInterface $response) : void
    {
        // If headers sent, throw headers already sent.
        $this->headers_sent();
        // Set Set status line..
        $status_line = \sprintf('HTTP/%s %s %s', $response->getProtocolVersion(), $response->getStatusCode(), $response->getReasonPhrase());
        \header($status_line, \true);
        // Append headers.
        foreach ($this->headers_with_json($response->getHeaders()) as $name => $values) {
            // If values are an array, join.
            $values = \is_array($values) ? \join(',', $values) : (string) $values;
            $response_header = \sprintf('%s: %s', $name, $values);
            \header($response_header, \false);
        }
        // Emit body.
        echo $response->getBody();
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        return;
        // phpcs:ignore Squiz.PHP.NonExecutableCode.ReturnNotRequired
    }
    /**
     * Emits a WP_HTTP Response.
     *
     * @param WP_HTTP_Response $response
     * @return void
     */
    public function emit_wp_response(\WP_HTTP_Response $response) : void
    {
        // If headers sent, throw headers already sent.
        $this->headers_sent();
        // Append headers.
        foreach ($this->headers_with_json($response->get_headers()) as $name => $values) {
            $values = \is_array($values) ? \join(',', $values) : (string) $values;
            $response_header = \sprintf('%s: %s', $name, $values);
            \header($response_header, \false);
        }
        // Emit body.
        $body = $response->get_data();
        print \is_string($body) ? $body : wp_json_encode($body);
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        return;
        // phpcs:ignore Squiz.PHP.NonExecutableCode.ReturnNotRequired
    }
    /**
     * Adds the JSON content type header if no header set.
     *
     * @param array<string, mixed> $headers
     * @return array<string, mixed>
     */
    public function headers_with_json(array $headers = array()) : array
    {
        if (!\array_key_exists('Content-Type', $headers)) {
            $headers['Content-Type'] = 'application/json; charset=' . get_option('blog_charset');
        }
        return $headers;
    }
    /**
     * Throws RunTime error if headers sent.
     *
     * @return void
     * @throws RuntimeException
     */
    protected function headers_sent() : void
    {
        if (\headers_sent()) {
            throw new \RuntimeException('Headers were already sent. The response could not be emitted!');
        }
    }
    /**
     * Wraps any value which can be json encoded in a StreamInterface
     *
     * @deprecated 0.2.3 Replaced with stream_from_scalar()
     * @param string|int|float|object|array<mixed> $data
     * @return \Psr\Http\Message\StreamInterface
     */
    public function create_stream_with_json($data) : \PC_Woo_Stock_Man\Psr\Http\Message\StreamInterface
    {
        return $this->stream_from_scalar($data);
        // phpcs:ignore WordPress.WP.AlternativeFunctions.json_encode_json_encode
    }
    /**
     * Wraps any value which can be json encoded in a StreamInterface
     *
     * @param string|int|float|object|array<mixed> $data
     * @return \Psr\Http\Message\StreamInterface
     */
    public function stream_from_scalar($data) : \PC_Woo_Stock_Man\Psr\Http\Message\StreamInterface
    {
        return \PC_Woo_Stock_Man\Nyholm\Psr7\Stream::create(\json_encode($data) ?: '');
        // phpcs:ignore WordPress.WP.AlternativeFunctions.json_encode_json_encode
    }
}
