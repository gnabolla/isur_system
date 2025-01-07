<?php

$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$routes = [
    "/" => "controllers/index.php",
    "/schedule/create" => "controllers/schedule_create.php",
    "/schedule/availability" => "controllers/schedule_availability.php",
    "/schedule/edit" => "controllers/schedule_edit.php",
    // ADD this line for deletion
    "/schedule/delete" => "controllers/schedule_delete.php",
];

/**
 * Checks the current path ($uri) against a list of routes,
 * and loads the corresponding controller file or shows 404 if not found.
 *
 * @param string $uri
 * @param array  $routes
 */
function routesToController(string $uri, array $routes): void
{
    if (array_key_exists($uri, $routes)) {
        require $routes[$uri];
    } else {
        http_response_code(404);
        echo "404 Not Found";
    }
}

routesToController($uri, $routes);
