<?php

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;
use LaravelAILabs\FileAssistant\Readers\WordReader;
use LaravelAILabs\FileAssistant\Test\TestCase;

class WordReaderTest extends TestCase
{
    public function test_it_can_read_word_files()
    {
        $reader = new WordReader('ipsum.docx');

        $text = $reader->getText();

        $this->assertTrue(Str::contains(haystack: $text, needles: ['Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'Habitant morbi tristique senectus et.']), 'File incorrectly read');
    }

    /**
     * @throws FileNotFoundException
     */
    public function test_limit_word_reading()
    {
        $reader = new WordReader('ipsum.docx');

        $text = $reader->limit(2)->getText();

        $this->assertTrue(Str::contains(haystack: $text, needles: ['Lorem ipsum dolor sit amet, consectetur adipiscing elit,', 'Duis ultricies lacus sed turpis tincidunt id aliquet risus feugiat']), 'File incorrectly read');
        $this->assertFalse(Str::contains(haystack: $text, needles: 'Mauris vitae ultricies leo integer malesuada nunc vel risus commodo'), 'File incorrectly read');
    }
}
