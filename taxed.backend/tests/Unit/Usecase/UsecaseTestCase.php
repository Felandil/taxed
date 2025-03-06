<?php

namespace Tests\Unit\Usecase;

use Illuminate\Database\Connection;
use Illuminate\Database\Query\Grammars\Grammar;
use Illuminate\Database\Query\Processors\Processor;

use App\Models\AssetCategory;
use App\Models\MovableAsset;

use Tests\Unit\Repository\DummyConnectionResolver;

use Mockery;

use PHPUnit\Framework\TestCase;

abstract class UsecaseTestCase extends TestCase {
  
  protected function setUp(): void
  {
    parent::setUp();

    $dummyGrammar = Mockery::mock(Grammar::class);
    $dummyGrammar->shouldReceive('getDateFormat')->andReturn('Y-m-d H:i:s');

    $dummyConnection = Mockery::mock(Connection::class);
    $dummyConnection->shouldReceive('getQueryGrammar')
      ->andReturn($dummyGrammar);
    $dummyConnection->shouldReceive('getPostProcessor')
      ->andReturn(Mockery::mock(Processor::class));
    $dummyConnection->shouldReceive('getPostProcessor')
      ->andReturn(Mockery::mock(Processor::class));

    $dummyResolver = new DummyConnectionResolver($dummyConnection);

    AssetCategory::setConnectionResolver($dummyResolver);
    MovableAsset::setConnectionResolver($dummyResolver);
  }

  protected function tearDown(): void
  {
    parent::tearDown();

    Mockery::close();
  }
}