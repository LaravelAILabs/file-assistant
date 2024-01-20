<?php

namespace LaravelAILabs\FileAssistant\Test;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;
use LaravelAILabs\FileAssistant\Readers\TextReader;

class TextReaderTest extends TestCase
{
	/**
	 * @throws FileNotFoundException
	 */
	function test_it_can_read_text_files() {
		$reader = new TextReader('ipsum.txt');

		$text = $reader->getText();

		$this->assertTrue(Str::contains(haystack: $text, needles: ['The standard Lorem Ipsum passage', 'greater pleasures, or else he endures pains to avoid worse pains.']), 'File incorrectly read');
	}

	/**
	 * @throws FileNotFoundException
	 */
	function test_limit_text_reading() {
		$reader = new TextReader('ipsum.txt');

		$text = $reader->limit(2)->getText();

		$this->assertTrue(Str::contains(haystack: $text, needles: ['The standard Lorem Ipsum passage', 'Lorem ipsum dolor sit amet, consectetur adi']), 'File incorrectly read');
		$this->assertFalse(Str::contains(haystack: $text, needles: 'Section 1.10.32 of'), 'File incorrectly read');
	}
}