<?php

namespace Tests\Feature;

use Behat\Behat\Context\Context;
use Behat\Step\Given;
use Behat\Step\When;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use PHPUnit\Framework\Assert as PHPUnit;
use Illuminate\Foundation\Application;

class FeatureContext implements Context
{
    /**
     * @var Application
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
     * Asset id to retrieve via api/assets/{id}
     * @var int
     */
    private $assetId;

    /**
     * Setup Laravel's Application instance
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

    #[Given('I want to retrieve an asset with the ID :assetId')]
    public function iWantToRetrieveAnAssetWithTheId($assetId): void
    {
        $this->assetId = (int) $assetId;
    }

    /**
     * @When I send a POST request to :uri
     */
    public function iSendAPOSTRequestTo($uri)
    {
        $request = Request::create($uri, 'POST', [], [], [], [
            'Content-Type' => 'application/json'
        ], json_encode($this->payload));

        $request->headers->set('Accept', 'application/json');
        $request->headers->set('Content-Type', 'application/json');

        $this->response = $this->app->handle($request);
    }

    #[When('I send a GET request to :uri')]
    public function iSendAGetRequestTo($uri): void
    {
        $request = Request::create($uri, 'GET');

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
