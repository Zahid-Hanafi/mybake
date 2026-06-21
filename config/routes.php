<?php
/**
 * Routes configuration — MyBake
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {

        // Root → redirect to login
        $builder->connect('/', ['controller' => 'Users', 'action' => 'login']);

        // ── Auth ──────────────────────────────────────────────────────
        $builder->connect('/login',    ['controller' => 'Users', 'action' => 'login']);
        $builder->connect('/register', ['controller' => 'Users', 'action' => 'register']);
        $builder->connect('/logout',   ['controller' => 'Users', 'action' => 'logout']);

        // ── Customer Pages ────────────────────────────────────────────
        $builder->connect('/dashboard',   ['controller' => 'Pages', 'action' => 'dashboard']);
        $builder->connect('/products',    ['controller' => 'Products', 'action' => 'index']);
        $builder->connect('/about',       ['controller' => 'Pages', 'action' => 'about']);
        $builder->connect('/contact',     ['controller' => 'Pages', 'action' => 'contact']);

        // ── Profile & Addresses ───────────────────────────────────────
        $builder->connect('/profile',               ['controller' => 'Users', 'action' => 'profile']);
        $builder->connect('/profile/addresses',     ['controller' => 'Addresses', 'action' => 'index']);
        $builder->connect('/profile/addresses/add', ['controller' => 'Addresses', 'action' => 'add']);
        $builder->connect('/profile/addresses/edit/{id}',   ['controller' => 'Addresses', 'action' => 'edit']);
        $builder->connect('/profile/addresses/delete/{id}', ['controller' => 'Addresses', 'action' => 'delete']);
        $builder->connect('/profile/addresses/default/{id}',['controller' => 'Addresses', 'action' => 'setDefault']);

        // ── Cart ──────────────────────────────────────────────────────
        $builder->connect('/cart',                 ['controller' => 'Carts', 'action' => 'index']);
        $builder->connect('/cart/add',             ['controller' => 'Carts', 'action' => 'addItem']);
        $builder->connect('/cart/update/{id}',     ['controller' => 'Carts', 'action' => 'updateItem']);
        $builder->connect('/cart/remove/{id}',     ['controller' => 'Carts', 'action' => 'removeItem']);
        $builder->connect('/cart/count',           ['controller' => 'Carts', 'action' => 'count']);

        // ── Orders ────────────────────────────────────────────────────
        $builder->connect('/checkout',             ['controller' => 'Orders', 'action' => 'checkout']);
        $builder->connect('/my-orders',            ['controller' => 'Orders', 'action' => 'myOrders']);
        $builder->connect('/my-orders/view/{id}',  ['controller' => 'Orders', 'action' => 'view']);
        $builder->connect('/my-orders/edit/{id}',  ['controller' => 'Orders', 'action' => 'edit']);
        $builder->connect('/my-orders/cancel/{id}',['controller' => 'Orders', 'action' => 'cancel']);

        // ── Admin ─────────────────────────────────────────────────────
        $builder->connect('/admin',                 ['controller' => 'Admin', 'action' => 'dashboard']);
        $builder->connect('/admin/dashboard',       ['controller' => 'Admin', 'action' => 'dashboard']);
        $builder->connect('/admin/orders',          ['controller' => 'Admin', 'action' => 'orders']);
        $builder->connect('/admin/orders/status/{id}', ['controller' => 'Admin', 'action' => 'updateStatus']);
        $builder->connect('/admin/stock',           ['controller' => 'Admin', 'action' => 'stock']);
        $builder->connect('/admin/stock/restock/{id}',   ['controller' => 'Admin', 'action' => 'restock']);
        $builder->connect('/admin/stock/toggle/{id}',    ['controller' => 'Admin', 'action' => 'toggleStatus']);
        $builder->connect('/admin/sales',           ['controller' => 'Sales', 'action' => 'index']);
        $builder->connect('/admin/sales/add',       ['controller' => 'Sales', 'action' => 'add']);
        $builder->connect('/admin/sales/report',    ['controller' => 'Sales', 'action' => 'report']);

        $builder->fallbacks();
    });
};
