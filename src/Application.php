<?php
declare(strict_types=1);

namespace App;

use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;

use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Cake\Routing\RouteBuilder;
use Psr\Http\Message\ServerRequestInterface;

class Application extends BaseApplication implements AuthenticationServiceProviderInterface
{
    public function bootstrap(): void
    {
        parent::bootstrap();
        if (PHP_SAPI !== 'cli') {
            FactoryLocator::add('Table', (new TableLocator())->allowFallbackClass(false));
        }
        $this->addPlugin('Authentication');
    }

    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            ->add(new ErrorHandlerMiddleware(Configure::read('Error'), $this))
            ->add(new AssetMiddleware())
            ->add(new RoutingMiddleware($this))
            ->add(new BodyParserMiddleware())
            ->add(new AuthenticationMiddleware($this));

        // Apply CSRF selectively (skip for login/register)
        $middlewareQueue->add(function ($request, $handler) {
            $controller = $request->getParam('controller');
            $action     = $request->getParam('action');

            $bypassActions = [
                'Users' => ['login', 'register'],
                'Carts' => ['addItem', 'removeItem', 'updateItem'],
            ];

            if (isset($bypassActions[$controller]) && in_array($action, $bypassActions[$controller])) {
                return $handler->handle($request);
            }

            $csrf = new CsrfProtectionMiddleware(['httponly' => true, 'checkNoCache' => false]);
            return $csrf->process($request, $handler);
        });

        return $middlewareQueue;
    }

    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $base = $request->getAttribute('base') ?? '';

        $service = new AuthenticationService([
            'unauthenticatedRedirect' => $base . '/login',
            'queryParam'              => 'redirect',
        ]);

        $service->loadIdentifier('Authentication.Password', [
            'fields' => [
                'username' => 'email',
                'password' => 'password',
            ],
        ]);

        // Session authenticator runs first — restores identity for already-logged-in users.
        $service->loadAuthenticator('Authentication.Session');

        // Form authenticator — NO loginUrl set (defaults to null).
        // When loginUrl is null, DefaultUrlChecker returns true immediately (empty URL list = no restriction).
        // This means Form auth tries on every request but only SUCCEEDS when valid email+password
        // are present in POST data. Session auth above handles all subsequent page loads.
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => [
                'username' => 'email',
                'password' => 'password',
            ],
        ]);

        return $service;
    }

    public function services(ContainerInterface $container): void {}
}