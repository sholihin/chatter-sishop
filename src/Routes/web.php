<?php

/**
 * Helpers.
 */

// Route helper.
$route = function ($accessor, $default = '') {
    return $this->app->config->get('chatter.routes.'.$accessor, $default);
};

// Middleware helper.
$middleware = function ($accessor, $default = []) {
    return $this->app->config->get('chatter.middleware.'.$accessor, $default);
};

// Authentication middleware helper.
$authMiddleware = function ($accessor) use ($middleware) {
    return array_unique(
        array_merge((array) $middleware($accessor), ['auth'])
    );
};

/*
 * Chatter routes.
 */
Route::group([
    'as'         => 'chatter.',
    'prefix'     => $route('home'),
    'middleware' => $middleware('global', 'web'),
    'namespace'  => 'Sholihin\ChatterSiShop\Controllers',
], function () use ($route) {

    // Home view.
    Route::get('/', [
        'as'         => 'home',
        'uses'       => 'ChatterController@index',
    ]);

    // Single category view.
    Route::get($route('category').'/{slug}', [
        'as'         => 'category.show',
        'uses'       => 'ChatterController@index',
    ]);

    /*
     * Auth routes.
     */

    // Login view.
    Route::get('login', [
        'as'   => 'login',
        'uses' => 'ChatterController@login',
    ]);

    // Register view.
    Route::get('register', [
        'as'   => 'register',
        'uses' => 'ChatterController@register',
    ]);

    /*
     * Discussion routes.
     */
    Route::group([
        'as'     => 'discussion.',
        'prefix' => $route('discussion'),
    ], function () {

        // All discussions view.
        Route::get('/', [
            'as'         => 'index',
            'uses'       => 'ChatterDiscussionController@index',
        ]);

        // Create discussion view.
        Route::get('create', [
            'as'         => 'create',
            'uses'       => 'ChatterDiscussionController@create',
        ]);

        // Store discussion action.
        Route::post('/', [
            'as'         => 'store',
            'uses'       => 'ChatterDiscussionController@store',
        ]);

        // Single discussion view.
        Route::get('{category}/{slug}', [
            'as'         => 'showInCategory',
            'uses'       => 'ChatterDiscussionController@show',
        ]);

        // Add user notification to discussion
        Route::post('{category}/{slug}/email', [
            'as'         => 'email',
            'uses'       => 'ChatterDiscussionController@toggleEmailNotification',
        ]);

        /*
         * Specific discussion routes.
         */
        Route::group([
            'prefix' => '{discussion}',
        ], function () {

            // Single discussion view.
            Route::get('/', [
                'as'         => 'show',
                'uses'       => 'ChatterDiscussionController@show',
            ]);

            // Edit discussion view.
            Route::get('edit', [
                'as'         => 'edit',
                'uses'       => 'ChatterDiscussionController@edit',
            ]);

            // Update discussion action.
            Route::match(['PUT', 'PATCH'], '/', [
                'as'         => 'update',
                'uses'       => 'ChatterDiscussionController@update',
            ]);

            // Destroy discussion action.
            Route::delete('/', [
                'as'         => 'destroy',
                'uses'       => 'ChatterDiscussionController@destroy',
            ]);
        });
    });

    /*
     * Post routes.
     */
    Route::group([
        'as'     => 'posts.',
        'prefix' => $route('post', 'posts'),
    ], function () {

        // All posts view.
        Route::get('/', [
            'as'         => 'index',
            'uses'       => 'ChatterPostController@index',
        ]);

        // Create post view.
        Route::get('create', [
            'as'         => 'create',
            'uses'       => 'ChatterPostController@create',
        ]);

        // Store post action.
        Route::post('/', [
            'as'         => 'store',
            'uses'       => 'ChatterPostController@store',
        ]);

        /*
         * Specific post routes.
         */
        Route::group([
            'prefix' => '{post}',
        ], function () {

            // Single post view.
            Route::get('/', [
                'as'         => 'show',
                'uses'       => 'ChatterPostController@show',
            ]);

            // Edit post view.
            Route::get('edit', [
                'as'         => 'edit',
                'uses'       => 'ChatterPostController@edit',
            ]);

            // Update post action.
            Route::match(['PUT', 'PATCH'], '/', [
                'as'         => 'update',
                'uses'       => 'ChatterPostController@update',
            ]);

            // Destroy post action.
            Route::delete('/', [
                'as'         => 'destroy',
                'uses'       => 'ChatterPostController@destroy',
            ]);
        });
    });
});

/*
 * Atom routes
 */
Route::get($route('home').'.atom', [
    'as'         => 'chatter.atom',
    'uses'       => 'Sholihin\ChatterSiShop\Controllers\ChatterAtomController@index',
]);
