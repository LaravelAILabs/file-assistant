# AI File Assistant

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravelailabs/file-assistant.svg?style=flat-square)](https://packagist.org/packages/laravelailabs/file-assistant)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/laravelailabs/file-assistant/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/laravelailabs/file-assistant/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/laravelailabs/file-assistant/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/laravelailabs/file-assistant/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/laravelailabs/file-assistant.svg?style=flat-square)](https://packagist.org/packages/laravelailabs/file-assistant)

Analyzez files based on AI and offers the possibility to query them.

## Support us

If this helped you, consider supporting my development over on [Patreon](https://patreon.com/AdrianTanase443).

## Installation

You can install the package via composer:

```bash
composer require laravelailabs/file-assistant
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="file-assistant-config"
```

## Setup
Currently using [Pinecone.io](https://pinecone.io) as the vector database and [OpenAI](https://openai.com/) as the LLM. Planning to make it so any LLM can be used, as well as any Vector Database implemented in [Laravel Vector Store](adrianmtanase/laravel-vector-store).

Add the following secrets to your `.env`:

```dotenv
VECTOR_STORE_PINECONE_API_KEY=YOUR_PINECONE_API_KEY
VECTOR_STORE_PINECONE_ENVIRONMENT=YOUR_PINECONE_ENVIRONMENT
FILE_ASSISTANT_OPENAI_API_KEY=YOUR_OPENAPI_KEY
FILE_ASSISTANT_PINECONE_DATASET=YOUR_PINECONE_INDEX_NAME
```

You can find your [OpenAI API Key here](https://platform.openai.com/api-keys).

## Usage

#### 1. Start a new conversation
```php
$dialog = FileAssistant::addFile('PATH_TO_YOUR_FILE')
                             ->addFile('PATH_TO_YOUR_SECOND_FILE')
                             ->initialize();

echo $dialog->prompt('What is this document about?')
```

#### 2. Resume a conversation
```php
$dialog = FileAssistant::setConversation(Conversation::find(1))
                             ->setUser(Auth::user())
                             ->initialize();

// grab the conversation and display the messages
/**
* @var \LaravelAILabs\FileAssistant\Models\Conversation $conversation
 */
$conversation = $dialog->getConversation();
foreach ($conversation->messages as $message) {
    echo sprintf('%s: %s <br>', $message->role, $message->content);
}

echo $dialog->prompt('Where did we leave off?')
```

#### 3. Grab messages and display
The package creates 3 tables: `conversations`, `messages`, `files`, `conversation_files`. Feel free to modify their names using the [file-assistant config](https://github.com/LaravelAILabs/file-assistant/blob/main/config/file-assistant.php) environment variables. Use the models to interact with the database and display the messages of a conversation.

## Works with
- PDF
- Word
- TXT

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Adrian Tanase](https://github.com/adrianmtanase)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
