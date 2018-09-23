<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 23/09/2018
 * Time: 13:10
 */

namespace KanbanBoard\Github\Test;

use Dotenv\Dotenv;
use KanbanBoard\Config\ConfigInterface;
use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{

    /**
     * @var string
     */
    protected $testRepositoryName;

    public function setUp()
    {
        $dotenv = new Dotenv(__DIR__, '/.env_test');
        $dotenv->load();
        $this->testRepositoryName = getenv(self::GH_TEST_REPOSITORY);
    }

    /**
     * Get Config mock. By default its returns available values from .env_test
     * file.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getConfigMock()
    {
        $configMock = $this->createMock(ConfigInterface::class);
        $configMock->method('getCacheLocation')
          ->willReturn(getenv(self::GH_TEST_CACHE_LOCATION));

        $configMock->method('getRepositoryList')
          ->will(
            $this->returnCallback(
              function () {
                  return [$this->testRepositoryName];
              }
            )
          );

        $configMock->method('getPausedLabels')
          ->will(
            $this->returnCallback(
              function () {
                  $labels = getenv(self::GH_TEST_PAUSED_LABELS);

                  return explode('|', $labels);
              }
            )
          );

        $configMock->method('getAccountName')
          ->willReturn(getenv(self::GH_TEST_ACCOUNT));

        $configMock->method('getClientId')
          ->willReturn(getenv(self::GH_TEST_CLIENT_ID));

        $configMock->method('getClientSecret')
          ->willReturn(getenv(self::GH_TEST_CLIENT_SECRET));

        return $configMock;
    }


    const GH_TEST_REPOSITORY = 'GH_TEST_REPOSITORY_NAME';

    const GH_TEST_PAUSED_LABELS = 'GH_TEST_PAUSED_LABELS';

    const GH_TEST_CACHE_LOCATION = 'GH_TEST_CACHE_LOCATION';

    const GH_TEST_ACCOUNT = 'GH_TEST_ACCOUNT';

    const GH_TEST_CLIENT_ID = 'GH_TEST_CLIENT_ID';

    const GH_TEST_CLIENT_SECRET = 'GH_TEST_CLIENT_SECRET';
}