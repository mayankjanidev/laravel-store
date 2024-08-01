<?php

namespace Mayank\Store\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeStore extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:store {name} {--custom} {--namespace=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new data store.';

    protected $type = 'Store';

    protected function getDefaultNamespace($rootNamespace): string
    {
        $namespace = trim($this->option('namespace') ?? 'Stores', '\\');

        return trim($rootNamespace . '\\' . $namespace, '\\');
    }

    protected function getStubPath(string $fileName): string
    {
        return __DIR__ . '/../../../stubs/' . $fileName;
    }

    protected function getStub()
    {
        if ($this->option('custom'))
            return $this->getStubPath('custom-store.stub');

        return $this->getStubPath('query-store.stub');
    }
}
