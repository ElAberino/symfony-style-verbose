# Symfony Style Verbose
This class generates new methods for each output method of symfony style, which only create output based on the defined
verbositoy level, e.g. for title, titleIfVerbose(), titleIfVeryVerbose() and titleIfDebug().

The idea is to reduce complexity, if you need output only on some verbosity level.

## Example
### Before:
```php
$io = new SymfonyStyle($input, $output);

try {
    if ($output->isVerbose()) {
        $io->title('This is my title');
        $io->section('This is my section');
    }
    
    //do some stuff here
    
    if ($output->isVerbose()) {
        $io->section('Get objects');
        $io->progressStart(count($objects));
    }
    $objects = $this->repository->findBy(['active' => true]);
    
    foreach ($objects as $object) {
        //do something with the object
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
    
    //do some stuff here
    
    $io->sectionIfVerbose('Get objects');
    $io->progressStartIfVerbose(count($objects));
    $objects = $this->repository->findBy(['active' => true]);
        
    foreach ($objects as $object) {
        //do something with the object
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
## Rector Rules
There are rector rules which can make the changes like in the example for you.
Go to the  [Rules Overview](./docs/rules_overview.md) to see the rules details.

There ist also a SetList which combines all existing rules.
```php
    $rectorConfig->sets([
        \Elaberino\SymfonyStyleVerbose\Utils\Rector\Set\SymfonyStyleVerboseSetList::CHANGE_OUTPUT,
    ]);
```