<?php

namespace LaravelAILabs\FileAssistant\Test;

use LaravelAILabs\FileAssistant\Facades\FileAssistant;

class PdfAIQueryTest extends TestCase
{
    public function test_it_can_query_pdf_files()
    {
        $response = FileAssistant::from('ipsum.pdf')
            ->query('What is this paper about?');

        dd($response);
    }
}
