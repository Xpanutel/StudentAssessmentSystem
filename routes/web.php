<?php

class Router {
    private array $routes = [];

    public function get(string $path, callable $handler): void {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable $handler): void {
        $this->routes['POST'][$path] = $handler;
    }

    public function resolve(): void {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (isset($this->routes[$requestMethod][$requestPath])) {
            call_user_func($this->routes[$requestMethod][$requestPath]);
        } else {
            $this->handleNotFound();
        }
    }

    private function handleNotFound(): void {
        http_response_code(404);
        echo "404 Not Found";
    }
}
