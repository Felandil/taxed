<?php

namespace Tests\Feature;

use Behat\Behat\Context\Context;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use PHPUnit\Framework\Assert as PHPUnit;
use Illuminate\Foundation\Application;

class FeatureContext implements Context
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    private $app;

    /**
     * @var \Illuminate\Http\Response
     */
    private $response;

    /**
     * Json-Payload of POST requests
     *
     * @var array
     */
    private $payload = [];

    /**
     * Inject Laravel's Application instance
     *
     * @param Application $app
     */
    public function __construct()
    {
        $this->app = require __DIR__ . '/../../bootstrap/app.php';
        $this->app->make(Kernel::class)->bootstrap();
    }

    /**
     * @Given I have an asset named :name with a price of :price and an asset category with the ID :categoryId
     */
    public function iHaveAnAssetNamedWithAPriceOfAndAnAssetCategoryWithTheId($name, $price, $categoryId)
    {
        $this->payload = [
            'name' => $name,
            'price' => (float) $price,
            'categoryId' => (int) $categoryId,
        ];
    }

    /**
     * @When I send a POST request to :uri
     */
    public function iSendAPOSTRequestTo($uri)
    {
        // Create a POST request with JSON payload.
        $request = Request::create($uri, 'POST', [], [], [], [
            'Content-Type' => 'application/json'
        ], json_encode($this->payload));

        $request->headers->set('Accept', 'application/json');
        $request->headers->set('Content-Type', 'application/json');

        $this->response = $this->app->handle($request);
    }

    /**
     * @Then the HTTP response code should be :expectedCode
     */
    public function theResponseCodeShouldBe($expectedCode)
    {
        PHPUnit::assertEquals((int) $expectedCode, $this->response->getStatusCode());
    }

    /**
     * @Then the response should contain response code :expectedCode
     */
    public function theResponseShouldContainResponseCode($expectedCode)
    {
        $responseJson = $this->response->getData();

        PHPUnit::assertEquals((int) $expectedCode, $responseJson->code);
    }
}
