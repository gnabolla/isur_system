<?php
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$routes = [
  "/" => "controllers/index.php",
  "/schedule/create" => "controllers/schedule_create.php",
  "/schedule/availability" => "controllers/schedule_availability.php",
  "/schedule/edit" => "controllers/schedule_edit.php",
  "/schedule/delete" => "controllers/schedule_delete.php",
  "/faculty/schedule" => "controllers/faculty_schedule.php",
  // Added print route
  "/faculty/schedule/print" => "controllers/faculty_schedule_print.php",
];

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
