<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Repository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Created new repository';

    protected function configure()
    {
        $this->addArgument('name');
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');                  
        $this->createNewRepositoryClass($name);
    }

    public function createNewRepositoryClass(string $name)
    {
        $class = "<?php \n\n";
        $class .= "namespace App\Http\Repository;\n\n";
        $class .= "class $name extends Repository\n{ \n";
        $class .= "\tprotected function addSuportedFilters(): array\n\t{\n";
        $class .= "\t\t return [];\n\t}\n}";
        
        $path = "app/Http/Repository/$name.php";
        file_put_contents($path, $class);
    }

    protected function addSuportedFilters(): array
    {
        return [            
            'slug' => 'filterBySlug'
        ];
    }    
}
