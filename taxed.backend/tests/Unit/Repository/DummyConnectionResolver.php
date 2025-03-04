<?php

namespace Tests\Unit\Repository;

use Illuminate\Database\Connection;
use Illuminate\Database\ConnectionResolverInterface;

use Mockery\MockInterface;

class DummyConnectionResolver implements ConnectionResolverInterface
{
    protected $dummyConnection;

    public function __construct(MockInterface $dummyConnection)
    {
        $this->dummyConnection = $dummyConnection;
    }

    public function connection($name = null)
    {
        return $this->dummyConnection;
    }

    public function getDefaultConnection()
    {
        return 'dummy';
    }

    public function setDefaultConnection($name)
    {
        // Keine Aktion nötig
    }
}
