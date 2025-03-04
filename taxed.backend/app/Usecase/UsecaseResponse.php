<?php

namespace App\Usecase;

abstract class UsecaseResponse
{
  public const CODE_SUCCESS = 1;
  public const CODE_INVALID_ASSET_CATEGORY = -1;
  public const CODE_INVALID_ASSET_NAME = -2;
  public const CODE_INVALID_ASSET_PRICE = -3;
  public const CODE_UNKNOWN_ERROR = -4;

  /**
   * Mapping of error codes to messages
   * @var array
   */
  protected static array $messages = [
    self::CODE_SUCCESS => 'Success',
    self::CODE_INVALID_ASSET_CATEGORY => 'Invalid Asset Category',
    self::CODE_INVALID_ASSET_NAME => 'Invalid Asset Name',
    self::CODE_INVALID_ASSET_PRICE => 'Invalid Asset Price',
    self::CODE_UNKNOWN_ERROR => 'Unknown Error',
  ];

  public int $code;

  /**
   * @param int $code
   */
  public function __construct(int $code)
  {
    $this->code = $code;
  }

  /**
   * Resolves a given code to the corresponding message
   * 
   * @param int $code
   * 
   * @return string
   */
  public function getMessageForCode(): string
  {
    return self::$messages[$this->code] ?? 'Unbekannter Fehlercode';
  }
}