<?php

namespace Afaqy\Core\Console\LaravelModules\Commands;

use Illuminate\Support\Str;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Nwidart\Modules\Support\Config\GenerateConfigReader;

class FilterMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument being used.
     *
     * @var string
     */
    protected $argumentName = 'model-filter';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-model-filter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new model filter class for the specified module.';

    /**
     * Get controller name.
     *
     * @return string
     */
    public function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $controllerPath = GenerateConfigReader::read('model-filter');

        return $path . $controllerPath->getPath() . '/' . $this->getControllerName() . '.php';
    }

    /**
     * @return string
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub($this->getStubName(), [
            'MODULENAME'       => $module->getStudlyName(),
            'CONTROLLERNAME'   => $this->getControllerName(),
            'NAMESPACE'        => $module->getStudlyName(),
            'CLASS_NAMESPACE'  => $this->getClassNamespace($module),
            'CLASS'            => $this->getControllerNameWithoutNamespace(),
            'LOWER_NAME'       => $module->getLowerName(),
            'MODULE'           => $this->getModuleName(),
            'NAME'             => $this->getModuleName(),
            'STUDLY_NAME'      => $module->getStudlyName(),
            'MODULE_NAMESPACE' => $this->laravel['modules']->config('namespace'),
        ]))->render();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['model-filter', InputArgument::REQUIRED, 'The name of the model filter class.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

    /**
     * @return string
     */
    protected function getControllerName()
    {
        $controller = Str::studly($this->argument('model-filter'));

        if (Str::contains(strtolower($controller), 'filter') === false) {
            $controller .= 'Filter';
        }

        return $controller;
    }

    /**
     * @return string
     */
    private function getControllerNameWithoutNamespace()
    {
        return class_basename($this->getControllerName());
    }

    public function getDefaultNamespace(): string
    {
        $module = $this->laravel['modules'];

        return $module->config('paths.generator.model-filter.namespace') ?? $module->config('paths.generator.model-filter.path', 'Models/Filters');
    }

    /**
     * Get the stub file name based on the options
     * @return string
     */
    private function getStubName()
    {
        return '/afaqy/filter.stub';
    }
}
