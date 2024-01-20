<?php

namespace LaravelAILabs\FileAssistant\Test;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;
use LaravelAILabs\FileAssistant\Readers\PdfReader;
use LaravelAILabs\FileAssistant\Readers\TextReader;

class PdfReaderTest extends TestCase
{
    public function test_it_can_read_pdf_files()
    {
        $reader = new PdfReader('ipsum.pdf');

        $text = $reader->getText();

        $this->assertTrue(Str::contains(haystack: $text, needles: ['Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'Habitant morbi tris8que senectus et.']), 'File incorrectly read');
    }

    /**
     * @throws FileNotFoundException
     */
    public function test_limit_text_reading()
    {
        $reader = new TextReader('ipsum.txt');

        $text = $reader->limit(2)->getText();

        $this->assertTrue(Str::contains(haystack: $text, needles: ['Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'Felis eget nunc lobor8s maAs aliquam faucibus purus']), 'File incorrectly read');
        $this->assertFalse(Str::contains(haystack: $text, needles: 'Proin nibh nisl condimentum id venena8s a condimentum'), 'File incorrectly read');
    }
}
