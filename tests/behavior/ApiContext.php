<?php

namespace TicTacToe\BehaviorTest;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\Stream;
use Slim\Http\Uri;

/**
 * Class ApiContext
 * @package TicTacToe\BehaviorTest
 */
class ApiContext implements Context
{
    /** @var string $host */
    protected $host = '';

    /** @var string $version */
    protected $version = '';

    /** @var string $target */
    protected $target = '';

    /** @var string $method */
    protected $method = 'GET';

    /** @var string $body */
    protected $body = '';

    /** @var Response $response */
    protected $response = null;

    /** @var string $errorMessage */
    protected $errorMessage = '';

    /**
     * ApiContext constructor.
     * @param string $host
     * @param string $version
     */
    public function __construct(string $host, string $version)
    {
        $this->host = $host;
        $this->version = $version;
    }

    /**
     * @When I make request
     */
    public function iMakeRequest()
    {
        $header = new Headers();
        $header->add('Content-Type', 'application/json');
        $header->add('Accept', 'application/json');

        $fp = fopen('php://temp', 'rw');
        fputs($fp, $this->body);

        $request = new Request(
            $this->method,
            new Uri('http', $this->host, 80, sprintf('%s/%s', $this->version, $this->target)),
            $header,
            [],
            [],
            new Stream($fp)
        );

        try {
            $this->response = (new Client())->send($request);
        } catch (ClientException $e) {
            $this->response = new Response($e->getCode(), [], $e->getResponse()->getBody());
        } catch (ConnectException $e) {
            $this->response = new Response($e->getCode(), [], $e->getMessage());
        }
    }

    /**
     * @Given I have the payload :
     *
     * @param $requestBody
     */
    public function aRequestBody($requestBody)
    {
        $this->body = $requestBody->__toString();
    }

    /**
     * @Given a request target url :url
     *
     * @param $targetUrl
     */
    public function aRequestTargetUrl($targetUrl)
    {
        $this->target = $targetUrl;
    }

    /**
     * @Given a request method :method
     *
     * @param $method
     */
    public function aRequestMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @Then the response status code should be :status
     * @param $expected
     */
    public function iShouldReceiveAResponseStatusCode($expected)
    {
        Assert::assertEquals($expected, $this->response->getStatusCode());
    }

    /**
     * @Then I should receive a response error message :expected
     * @param $expected
     */
    public function iShouldReceiveAResponseErrorMessage($expected)
    {
        Assert::assertEquals($expected, json_decode($this->response->getBody(), true)['title']);
    }

    /**
     * @BeforeScenario
     * @param BeforeScenarioScope $scope
     */
    public function before(BeforeScenarioScope $scope)
    {
        $this->target = '';
        $this->method = 'GET';
        $this->response = null;
    }
}
