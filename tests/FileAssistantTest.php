<?php

namespace LaravelAILabs\FileAssistant\Test;

use Illuminate\Support\Str;
use LaravelAILabs\FileAssistant\Facades\FileAssistant;

class FileAssistantTest extends TestCase
{
    private function printDialog(string $dialog, bool $myself = true): void
    {
        if ($myself) {
            echo sprintf('Me: %s %s', $dialog, PHP_EOL);
        } else {
            echo sprintf('AI: %s %s', $dialog, PHP_EOL);
        }
    }

    public function test_it_can_query_pdf_files()
    {
        $dialog = FileAssistant::addFile('butterfly_points_and_hyperspace_selections.pdf')->initialize();

        $firstPrompt = 'Hi, I\'m Adrian';
        $this->printDialog($firstPrompt);

        $firstPromptResponse = $dialog->prompt($firstPrompt);
        $this->printDialog($firstPromptResponse, false);

        $this->assertTrue(Str::contains(needles: ['Adrian'], haystack: $firstPromptResponse, ignoreCase: true), '');

        $secondPrompt = 'What\'s my name?';
        $this->printDialog($secondPrompt);

        $secondPromptResponse = $dialog->prompt($secondPrompt);
        $this->printDialog($secondPromptResponse, false);

        $this->assertTrue(Str::contains(needles: ['Adrian'], haystack: $secondPromptResponse, ignoreCase: true), '');

        $thirdPrompt = 'Who is the author of the BUTTERFLY POINTS AND HYPERSPACE SELECTIONS paper?';
        $this->printDialog($thirdPrompt);

        $thirdPromptResponse = $dialog->prompt($thirdPrompt);
        $this->printDialog($thirdPromptResponse, false);

        $this->assertTrue(Str::contains(needles: ['Valentin', 'Gutev'], haystack: $thirdPromptResponse, ignoreCase: true), '');
    }
}
