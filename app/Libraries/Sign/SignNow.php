<?php

namespace App\Libraries\Sign;

use GuzzleHttp\Handler\CurlMultiHandler;
use GuzzleHttp\HandlerStack;
use SignNow\Api\Entity\Auth\TokenRequestPassword;
use SignNow\Api\Service\Guzzle\AuthorizationMiddleware;
use SignNow\Api\Service\Guzzle\OptionBuilder;
use SignNow\Api\Service\Guzzle\ResponseCheckerMiddleware;
use SignNow\Api\Service\OAuth\BasicToken;

use SignNow\Rest\Factories\ClientFactory;
use SignNow\Rest\Factories\EntityManagerFactory;

class SignNow
{

    private $client;

    private $host = 'https://api-eval.signnow.com/';

    public function authentication(){

//        AnnotationRegistry::registerLoader('class_exists');

        $token = "MjgyOTBmZTA5N2Q1MDM0MzVjYmRhNDYyNDRmY2U3M2I6MTUwNWMwZmZjNzYwZGEzOTVkNjA1OWU4M2NjMDI0M2M=";

        $stack = HandlerStack::create();
        $stack->setHandler(new CurlMultiHandler());
        $stack->push(new AuthorizationMiddleware( new BasicToken($token)));
        $stack->push(new ResponseCheckerMiddleware());
        $options = [
            'base_uri'        => $this->host,
            'headers'         => ['Content-Type' => 'application/json'],
            'connect_timeout' => 30,
            'request_timeout' => 30,
            'handler'         => $stack,
        ];


//        $options = (new OptionBuilder())
//            ->setUri($this->host)
//            ->useAuthorization(new BasicToken($token))
//            ->getOptions();

        $clientFactory = new ClientFactory($options);
        $entityManager = (new EntityManagerFactory($clientFactory))->create();


        $username = "alexretro74@gmail.com";
        $password = "av5hc8pug3ur";
        $param = [
            'grant_type' => 'password',
            'username' => $username,
            'password' => $password,
        ];

        // Request Access Token
        $token  = $entityManager->create(new TokenRequestPassword($username, $password));

        dump('$token',$token);
        dump('$account',$this->client);

//        die(base_path('public/uploads/pdf/project_report_4.pdf'));
    }

    public function sign(){

        $request = new \HelloSign\SignatureRequest;
        $request->enableTestMode();
        $request->setTitle('Sample Doc');
        $request->setSubject('Test Doc from Fieldscope');
        $request->setMessage('Please sign this NDA from developer@retrocube and then we can discuss more.');
        $request->addSigner('dnoah@yopmail.com', 'Daniel Noah');
//        $request->addSigner('paul@emerson-enterprises.com', 'Paul Lewis');
//        $request->addCC('support@fieldscope.com');
        $request->addFile(base_path('public/uploads/pdf/hello_test_report.pdf'));

//        $request->setUseTextTags(true);
//        $request->setFormFieldsPerDocument(
//            [
//                [ /** DOcument 1*/
//                    [ /** field 1 */
//                        "api_id"=> uniqid() . "_1",
//                        "name"=> "sign",
//                        "type"=> "text",
//                        "x"=> 152,
//                        "y"=> 170,
//                        "width"=> 100,
//                        "height"=> 16,
//                        "required"=> true,
//                        "signer"=> 0
//                    ],
//                ]
//            ]
//        );
        $response = $this->client->sendSignatureRequest($request);

        dd('$response',$response);

    }
}