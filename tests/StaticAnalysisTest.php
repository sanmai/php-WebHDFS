<?php

use PHPUnit\Framework\TestCase;

/**  
 * @coversNothing  
 */  
class StaticAnalysisTest extends TestCase  
{  
    public static function provideFiles(): iterable  
    {  
        $directory = new RecursiveDirectoryIterator('./src/');
        $iterator = new RecursiveIteratorIterator($directory);
        $regexIterator = new RegexIterator($iterator, '/\.php$/');
        
        foreach ($regexIterator as $file) {
            /** @var SplFileInfo $file */
            $filePath = $file->getRealPath();
            $relativePath = str_replace(getcwd(), '.', $filePath);

            yield $relativePath => [$relativePath];
        }
    }

    /**  
     * @dataProvider provideFiles  
     */  
    public function testFileIncludesSuccessfully($filename)  
    {  
        require $filename;  
        $this->addToAssertionCount(1); // Add a count for each successful inclusion
    }  
}
