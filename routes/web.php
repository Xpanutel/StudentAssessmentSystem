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

        foreach ($this->routes[$requestMethod] as $path => $handler) {
            if (preg_match($this->convertToRegex($path), $requestPath, $matches)) {
                array_shift($matches);
                call_user_func_array($handler, $matches);
                return;
            }
        }

        $this->handleNotFound();
    }

    private function convertToRegex(string $path): string {
        return '#^' . preg_replace('/{(\w+)}/', '([^/]+)', $path) . '$#';
    }

    private function handleNotFound(): void {
        http_response_code(404);
        echo "404 Not Found";
    }
}