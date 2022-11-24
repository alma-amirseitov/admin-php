<?php

namespace App\Http\Controllers;

use App\Model\Services\MessageService;
use App\Model\Validators\MessageValidator;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;

//TODO контроллер не должен ходить в репо
class MessageController
{
    protected MessageService $messageService;

    /**
     * @param MessageService $messageService
     */
    public function __construct()
    {
        $messageService = new MessageService();
        $this->messageService = $messageService;
    }


    public function index(ServerRequest $request, Response $response)
    {
        $messages = $this->messageService->getAllMessages();
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
        //дату в сервис
        //обработку ошибки
        //логирование
        //try catch в сервисе
        //тесты
        //добавить коонфигы
        //const keyParam
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
        $this->messageService->saveMessage($messageData);
        $this->sendMessageToGo($messageData['message']);
        return $response->withRedirect('/messages');
    }

    public function sendMessageToGo(String $messageData){
        $client = new \GuzzleHttp\Client();
        //создать модель и вынести оответ
        //модель коотоорый принемает  message data return array
        // php migrate
        // codeseption
        $response = $client->request('POST', 'http://localhost:8081/message', [
            'form_params' => [
                'message' => $messageData
            ]
        ]);
        echo $response->getBody();
    }

}
