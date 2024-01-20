<?php

namespace LaravelAILabs\FileAssistant\Readers;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use LaravelAILabs\FileAssistant\Abstracts\FileReaderAbstract;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Reader\Word2007;

class WordReader extends FileReaderAbstract
{
    private PhpWord $reader;

    public function __construct(string $path)
    {
        parent::__construct($path);

        $parser = new Word2007();
        $this->reader = $parser->load($path);
    }

    /**
     * @throws FileNotFoundException
     */
    public function getText(): string
    {
        $content = '';
        $rows = 0;

        foreach ($this->reader->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (method_exists($element, 'getElements')) {
                    foreach ($element->getElements() as $childElement) {
                        if (method_exists($childElement, 'getText')) {
                            $rows++;

                            if ($rows > $this->limit) {
                                break;
                            }

                            $content .= $childElement->getText().PHP_EOL;
                        } elseif (method_exists($childElement, 'getContent')) {
                            $rows++;

                            if ($rows > $this->limit) {
                                break;
                            }

                            $content .= $childElement->getContent().PHP_EOL;
                        }
                    }
                } elseif (method_exists($element, 'getText')) {
                    $rows++;

                    if ($rows > $this->limit) {
                        break;
                    }

                    $content .= $element->getText().PHP_EOL;
                }
            }
        }

        return $content;
    }
}
