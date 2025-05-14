<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Create extends BaseCommand
{
    protected $group = 'App';
    protected $name = 'create';
    protected $description = 'Creates a view, library, or module (controller, model, views).';
    protected $usage = 'create:view|library|module [name] [options]';
    protected $arguments = [];
    protected $options = [];

    public function run(array $params)
    {
        if (empty($params)) {
            CLI::write('Usage: create:view|library|module [name]', 'yellow');
            return;
        }

        $type = $params[0];
        $name = $params[1] ?? null;

        switch ($type) {
            case 'view':
                $this->createView($name);
                break;
            case 'library':
                $this->createLibrary($name);
                break;
            case 'module':
                $this->createModule($name);
                break;
            default:
                CLI::write('Unknown create type. Use view, library, or module.', 'red');
        }
    }

    protected function createView($name)
    {
        if (!$name) {
            $name = CLI::prompt('Enter view name (without .php)');
        }
        // Remove 'required' so blank is allowed
        $dir = CLI::prompt('Enter subdirectory under app/Views (leave blank for none)');
        $basePath = APPPATH . 'Views' . ($dir ? DIRECTORY_SEPARATOR . $dir : '');
        if (!is_dir($basePath)) {
            mkdir($basePath, 0777, true);
        }
        $filePath = $basePath . DIRECTORY_SEPARATOR . $name . '.php';
        if (file_exists($filePath)) {
            CLI::write('View already exists: ' . $filePath, 'red');
            return;
        }
        file_put_contents($filePath, "<!-- View: $name -->\n");
        CLI::write('View created: ' . $filePath, 'green');
    }

    protected function createLibrary($name)
    {
        if (!$name) {
            $name = CLI::prompt('Enter library name (without .php)');
        }
        // Remove 'required' so blank is allowed
        $dir = CLI::prompt('Enter subdirectory under app/Libraries (leave blank for none)');
        $basePath = APPPATH . 'Libraries' . ($dir ? DIRECTORY_SEPARATOR . $dir : '');
        if (!is_dir($basePath)) {
            mkdir($basePath, 0777, true);
        }
        $filePath = $basePath . DIRECTORY_SEPARATOR . $name . '.php';
        if (file_exists($filePath)) {
            CLI::write('Library already exists: ' . $filePath, 'red');
            return;
        }
        $className = ucfirst($name);
        $namespace = 'App\\Libraries' . ($dir ? '\\' . str_replace('/', '\\', $dir) : '');
        $content = "<?php\n\nnamespace $namespace;\n\nclass $className\n{\n    // ...\n}\n";
        file_put_contents($filePath, $content);
        CLI::write('Library created: ' . $filePath, 'green');
    }

    protected function createModule($name)
    {
        if (!$name) {
            $name = CLI::prompt('Enter module name');
        }
        $basePath = APPPATH . 'Modules' . DIRECTORY_SEPARATOR . $name;
        $dirs = ['Controllers', 'Models', 'Views'];
        foreach ($dirs as $dir) {
            $fullPath = $basePath . DIRECTORY_SEPARATOR . $dir;
            if (!is_dir($fullPath)) {
                mkdir($fullPath, 0777, true);
            }
        }
        // Create default Controller
        $controllerPath = $basePath . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . $name . 'Controller.php';
        if (!file_exists($controllerPath)) {
            $controllerContent = "<?php\n\nnamespace App\Modules\\$name\Controllers;\n\nuse CodeIgniter\Controller;\n\nclass {$name}Controller extends Controller\n{\n    public function index()\n    {\n        return view('Modules/$name/Views/index');\n    }\n}\n";
            file_put_contents($controllerPath, $controllerContent);
        }
        // Create default Model
        $modelPath = $basePath . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR . $name . 'Model.php';
        if (!file_exists($modelPath)) {
            $modelContent = "<?php\n\nnamespace App\Modules\\$name\Models;\n\nuse CodeIgniter\Model;\n\nclass {$name}Model extends Model\n{\n    // ...\n}\n";
            file_put_contents($modelPath, $modelContent);
        }
        // Create default View
        $viewPath = $basePath . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'index.php';
        if (!file_exists($viewPath)) {
            file_put_contents($viewPath, "<!-- Module $name default view -->\n");
        }
        CLI::write('Module created: ' . $basePath, 'green');
    }
}