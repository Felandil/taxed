Feature: Asset creation
  In order to manage assets
  As a user
  I want to create an asset
  
  Scenario Outline: Unsucessful creation of an asset
    Given I have an asset named "<asset_name>" with a price of "<asset_price>" and an asset category with the ID "<asset_category>"
    When I send a POST request to "/api/assets"
    Then the HTTP response code should be "<http_response_code>"
    And the response should contain response code "<response_code>"

    Examples:
    | asset_name | asset_price   | asset_category | http_response_code | response_code  |
    | TestAsset  | 1000          | 0              | 400                | -1             |
    | Te         | 1000          | 7              | 400                | -2             |
    | TestAsset  |               | 7              | 400                | -3             |

  Scenario: Sucessful creation of an asset
    Given I have an asset named "TestAsset" with a price of "1000" and an asset category with the ID "7"
    When I send a POST request to "/api/assets"
    Then the HTTP response code should be "201"
    And the response should contain response code "1"