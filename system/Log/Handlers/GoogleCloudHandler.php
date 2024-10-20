<?php

namespace CodeIgniter\Log\Handlers;

use Google\Cloud\Logging\LoggingClient;

class GoogleCloudHandler extends BaseHandler
{
    protected $loggingClient;

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        // Inicializar el cliente de logging de Google Cloud
        $this->loggingClient = new LoggingClient();
    }

    public function handle($level, $message): bool
    {
        $logger = $this->loggingClient->logger('codeigniter-log');

        $logger->write($message, [
            'level' => $level,
            'resource' => [
                'type' => 'gae_app',
                'labels' => [
                    'module_id' => getenv('GAE_SERVICE'),
                    'version_id' => getenv('GAE_VERSION'),
                ],
            ],
        ]);

        return true;
    }
}