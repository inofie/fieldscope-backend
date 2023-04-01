<?php

namespace App\Libraries\Sign;

class HelloSign
{

    private $client;

    public function authentication(){
        $this->client = new \HelloSign\Client("e0c00acd6cbf593a177c7683e95122c86cac6155830f551489ba8d5d746f685b");
        $account = $this->client->getAccount();
        dump('$account',$this->client);

//        die(base_path('public/uploads/pdf/project_report_4.pdf'));
    }

    public function sign(){

        $request = new \HelloSign\SignatureRequest;
        $request->enableTestMode();
        $request->setTitle('Sample Doc');
        $request->setSubject('Test Doc from Fieldscope');
        $request->setMessage('Please sign this NDA from developer@retrocube and then we can discuss more.');
//        $request->addSigner('dnoah@yopmail.com', 'Daniel Noah');
        $request->addSigner('paul@emerson-enterprises.com', 'Paul Lewis');
        $request->addCC('support@fieldscope.com');
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