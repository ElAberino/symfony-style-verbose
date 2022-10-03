# Symfony Style Verbose
This class generates new methods for each output method of symfony style, which only create output based on the defined
verbositoy level, e.g. for title, titleIfVerbose(), titleIfVeryVerbose() and titleIfDebug().

The idea is to reduce complexity if you need output only on some verbosity level.

## Example
### Before:
```php
$io = new SymfonyStyle($input, $output);

try {
    if ($output->isVerbose()) {
        $io->title('This is my title');
        $io->section('This is my section');
    }
    
    $objects = $this->repository->findBy(['active' => true]);
    if ($output->isVerbose()) {
        $io->section('Get objects');
        $io->progressStart(count($objects));
    }
    
    foreach ($objects as $object) {
        if ($output->isVerbose()) {
            $io->progressAdvance();
        }
    }
    
    if ($output->isVerbose()) {
        $io->progressFinish();
        $io->success('All objects handled');
    } 
} catch (Throwable $throwable) {
    if ($output->isVerbose()) {
        $io->error('Error while handling products');
    }
    return Command::FAILURE;
}

return Command::SUCCESS;
```
### After:
```php
$io = new SymfonyStyleVerbose($input, $output);

try {
    $io->titleIfVerbose('This is my title');
    $io->sectionIfVerbose('This is my section');
    
    $objects = $this->repository->findBy(['active' => true]);
    $io->sectionIfVerbose('Get objects');
    $io->progressStartIfVerbose(count($objects));
        
    foreach ($objects as $object) {
        $io->progressAdvanceIfVerbose();
    }
    
    $io->progressFinishIfVerbose();
    $io->successIfVerbose('All objects handled');
} catch (Throwable $throwable) {
    $io->errorIfVerbose($throwable->getMessage());
    
    return Command::FAILURE;
}

return Command::SUCCESS;
```
