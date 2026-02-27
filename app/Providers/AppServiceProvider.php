<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            \Illuminate\Support\Facades\Storage::extend('google', function ($app, $config) {
                $options = [];

                if (!empty($config['teamDriveId'] ?? null)) {
                    $options['teamDriveId'] = $config['teamDriveId'];
                }

                if (!empty($config['sharedFolderId'] ?? null)) {
                    $options['sharedFolderId'] = $config['sharedFolderId'];
                }

                $client = new \Google\Client();

                // Prioritize Refresh Token (OAuth 2) if available, as it uses the personal 15GB+ quota
                if (!empty($config['refreshToken'])) {
                    $client->setClientId($config['clientId']);
                    $client->setClientSecret($config['clientSecret']);
                    $client->refreshToken($config['refreshToken']);
                } elseif (!empty($config['serviceAccount'])) {
                    $client->setAuthConfig(base_path($config['serviceAccount']));
                    $client->addScope(\Google\Service\Drive::DRIVE);
                }

                $service = new \Google\Service\Drive($client);
                $adapter = new \Masbug\Flysystem\GoogleDriveAdapter($service, $config['folderId'] ?? '/', $options);
                $driver = new \League\Flysystem\Filesystem($adapter);

                return new \Illuminate\Filesystem\FilesystemAdapter($driver, $adapter, $config);
            });
        } catch (\Exception $e) {
            // Log error or handle it
        }
    }
}
