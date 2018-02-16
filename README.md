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

You can easily test your bot using the Heroku platform. To do that, follow the [documentation](https://devcenter.heroku.com/articles/git) and then add the environment variables :

```bash
heroku config:set APP_ENV=dev

# If you want to use the GoogleBot (see https://developers.google.com/custom-search/json-api/v1/overview)
heroku config:set GOOGLE_API_KEY=dev
heroku config:set GOOGLE_SEARCH_ENGINE=dev

```

Now you can run the server :

```bash
git push heroku master
```

Once it's done, you'll have an url like https://polar-ridge-99999.herokuapp.com/. So your bot url will be https://polar-ridge-99999.herokuapp.com/my-new-bot
