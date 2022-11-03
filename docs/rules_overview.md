# 3 Rules Overview

## ChangeInitializationRector

Initialize object of type SymfonyStyleVerbose instead of SymfonyStyle

- class: [`Elaberino\SymfonyStyleVerbose\Utils\Rector\Rector\ChangeInitializationRector`](../utils/rector/src/Rector/ChangeInitializationRector.php)

```diff
-$io = new SymfonyStyle($input, $output);
+$io = new SymfonyStyleVerbose($input, $output)
```

<br>

## ChangeMethodCallsAndRemoveIfRector

Removes if statments e.g. with `isVerbose()` and renames SymfonyStyle methods to e.g. `title()` to titleIsVerbose

:wrench: **configure it!**

- class: [`Elaberino\SymfonyStyleVerbose\Utils\Rector\Rector\ChangeMethodCallsAndRemoveIfRector`](../utils/rector/src/Rector/ChangeMethodCallsAndRemoveIfRector.php)

```php
<?php

declare(strict_types=1);

use Elaberino\SymfonyStyleVerbose\Utils\Rector\Rector\ChangeMethodCallsAndRemoveIfRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(ChangeMethodCallsAndRemoveIfRector::class, [2]);
};
```

↓

```diff
-if ($output->isVerbose()) {
-    $io->title('This is a title');
-    $io->section('This is a section');
-}
-     
-if ($output->isVeryVerbose()) {
-    $io->title('This is a title');
-    $io->section('This is a section');
-}
+$io->titleIfVerbose('This is a title');
+$io->sectionIfVerbose('This is a section');
 
-if ($output->isDebug()) {
-    $io->title('This is a title');
-    $io->section('This is a section');
-}
+$io->titleIfVeryVerbose('This is a title');
+$io->sectionIfVeryVerbose('This is a section');
+
+$io->titleIfDebug('This is a title');
+$io->sectionIfDebug('This is a section');
```

<br>

## ChangeNamespaceRector

Replace namespace of SymfonyStyle with the one of SymfonyStyleVerbose

- class: [`Elaberino\SymfonyStyleVerbose\Utils\Rector\Rector\ChangeNamespaceRector`](../utils/rector/src/Rector/ChangeNamespaceRector.php)

```diff
-use Symfony\Component\Console\Style\SymfonyStyle;
+use Elaberino\SymfonyStyleVerbose\SymfonyStyleVerbose;
```

<br>
