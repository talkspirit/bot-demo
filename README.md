[![Build Status](https://travis-ci.org/talkspirit/bot-demo.svg?branch=master)](https://travis-ci.org/talkspirit/bot-demo)

# Talkspirit Bot Demo

A working talkspirit bot sample powered by [symfony4](https://symfony.com/)

[![Deploy](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy?template=https://github.com/talkspirit/bot-demo?env[APP_ENV]=prod)

## Development

The project gives you a structure you can use to create your own bot. To do that, follow the steps bellow

### Create the new bot

Create a new class implementing the BotInterface :

```php
# src/Bot/MyNewBot.php

namespace Talkspirit\BotDemo\Bot;

class MyNewBot implements BotInterface
{
    public function reply(Message $message): Message
    {
        // Create the appropriate response to the $message->input request and
        // then put it into the $message->output attribute.
    }
    
    public function getAvailableCommands(): array
    {
        return [
            // List of available commands with your bot. Use Talkspirit\BotDemo\DTO\Command::createCommand to add a new one
        ];
    }
}
```

### Create the new controller action

Here you only need to create a new method which will recieve the bot in its parameters.
Thanks to the Symfony autowiring, you don't need to add any dependency injection's configuration. 

```php
# src/Controller/AppController.php

//...
use Talkspirit\BotDemo\Bot\MyNewBot;

class AppController
{
    //...
    public function myNewBot(HttpClient $client, MyNewBot $bot, Message $message)
    {
        return $this->botResponse($client, $bot, $message);
    }
    //...
}
```

Then add a routing for your action :

```yaml
# config/routes.yaml

my_new_bot:
    path: /my-new-bot
        controller: Talkspirit\BotDemo\Controller\AppController::MyNewBot
        methods:    [POST]
```

In this example the bot will be reachable via the url {your server}/my-new-bot

### Deployment

You can easily test your bot using the Heroku platform. To do that, follow the [documentation](https://devcenter.heroku.com/articles/git)
Then run the server :

```bash
git push heroku master
```

Once it's done, you'll have an url like https://xxxx.herokuapp.com/. So your bot url will be https://xxxx.herokuapp.com/my-new-bot

### Enable your bot

To activate the bot referer to the [Talkspirit documentation](https://talkspirit.github.io/docs/create-bot/)

## Contribution

For now, contributions aren't allowed. If you encounter an bug or if you have an improvement idea, please create an issue.
