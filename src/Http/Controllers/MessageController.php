<?php

namespace App\Http\Controllers;

use App\Model\Repository\MessageRepository;
use App\Model\Validators\MessageValidator;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;

class MessageController
{
    public function index(ServerRequest $request, Response $response)
    {
        $messagesRepo = new MessageRepository();
        $messages = $messagesRepo->getAll();

        $view = Twig::fromRequest($request);

        return $view->render($response, 'showMessages.twig', ['messages' => $messages]);
    }

    public function newMessage(ServerRequest $request, Response $response)
    {
        $view = Twig::fromRequest($request);

        return $view->render($response, 'newMessage.twig');
    }

    public function sendMessage(ServerRequest $request, Response $response)
    {
        $repo         = new MessageRepository();
        $messageData  = $request->getParsedBodyParam('message', []);

        $validator = new MessageValidator();
        $errors    = $validator->validate($messageData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'newMessage.twig', [
                'data'   => $messageData,
                'errors' => $errors,
            ]);
        }

        $repo->create($messageData);

        return $response->withRedirect('/messages');
    }

}
