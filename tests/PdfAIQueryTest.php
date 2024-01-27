<?php

namespace LaravelAILabs\FileAssistant\Test;

use LaravelAILabs\FileAssistant\Facades\FileAssistant;

class PdfAIQueryTest extends TestCase
{
    public function test_it_can_query_pdf_files()
    {
        $response = FileAssistant::from('butterfly_points_and_hyperspace_selections.pdf')
            ->initialize()
            ->ask('What is this paper about?');

        dd($response);
    }
}
