<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class ProcessMakeCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:process {name} {--option}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Process class';

    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;

        $this->addOption('resource', 'Put Resource of process');

    }

    public function handle()
    {
        $path = $this->getSourceFilePath();

        $contents = $this->getSourceFile();

        $this->makeDirectory(dirname($path));


        if(!$this->files->exists($path)) {

            file_put_contents($path, $contents);
            $this->info("Processes Created Successfully");

        } else {
            $this->error("Processes Already exists");
        }
    }

    /**
     * Return the Singular Capitalize Name
     * @param $name
     * @return string
     */
    public function getSingularClassName($name)
    {
        return ucwords(Pluralizer::singular($name));
    }

    /**
     * Get the stub file for the generator
     *
     * @return string
     */
    public function getStub()
    {
        if($this->option('resource')) {
            $stub = '/stubs/processes.stub';
        }

        $stub = $stub ?? '/stubs/processes.plain.stub';

        return $this->resolveStubPath($stub);
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/'))) ? $customPath : __DIR__.$stub;
    }

    /**
     * Map the stub variables present in stub to its value
     *
     * @return array
     */
    public function getStubVariables()
    {
        return [
            'NAMESPACE'     => 'App\\Processes',
            'CLASS_NAME'    => $this->getSingularClassName($this->argument('name')),
            'NAME'          => strtolower($this->argument('name')),
        ];
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getSourceFile()
    {
        return $this->getStubContents($this->getStub(), $this->getStubVariables());
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub , $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace)
        {
            $contents = str_replace('$'.$search.'$' , $replace, $contents);
        }

        return $contents;
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath()
    {
        return app_path('Processes/') . $this->getSingularClassName($this->argument('name')) . 'Process.php';
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
}
