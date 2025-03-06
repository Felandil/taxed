Feature: Get Asset
  In order to manage assets
  As a user
  I want to get an asset
  
  Scenario Outline: Retrieval of an asset
    Given I want to retrieve an asset with the ID "<asset_id>"
    When I send a GET request to "/api/assets/<asset_id>"
    Then the HTTP response code should be "<http_response_code>"
    And the response should contain response code "<response_code>"

    Examples:
    | asset_id   | http_response_code | response_code  |
    | 0          | 404                | -5             |
    | 1          | 200                | 1              |