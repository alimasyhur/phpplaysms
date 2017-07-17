<?php

namespace alimasyhur\phpplaysms;
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 7/16/2017
 * Time: 1:51 PM
 */
class PlaySms{
    /**
     * @var array
     * Array of config
     */
    protected $config = [];


    /**
     * @var array
     * Array of phone numbers
     */
    protected $phone_numbers = [];


    /**
     * @var null|string
     * PlaySMS Url
     */
    protected $url = null;

    /**
     * @var null|string
     * PlaySMS app
     */
    protected $app = 'ws';

    /**
     * @var null|string
     * PlaySMS op
     */
    protected $op = 'pv';

    /**
     * @var null|string
     * PlaySMS user
     */
    protected $user = null;

    /**
     * @var null|string
     * PlaySMS token
     */
    protected $token = null;

    public function __construct($newConfig)
    {
        $this->config = $newConfig;
    }

    protected function setConfig() {
        if (is_array($this->config)) {
            foreach ($this->config as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }


    /**
     * Start performing Send Single or Multiple Message
     *
     * @param array $arrPhoneNumber
     * @param string $message
     *
     * @return resource json
     */
    public function send($arrPhoneNumber, $message) {
        $this->setConfig();

        $status = [];
        foreach ($arrPhoneNumber as $phoneNumber) {
            $data = [
                'app' => $this->app,
                'op' => $this->op,
                'u' => $this->user,
                'h' => $this->token,
                'to' => $phoneNumber,
                'msg' => $message
            ];

            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data),
                ),
            );
            $context = stream_context_create($options);

            $result = file_get_contents($this->url, false, $context);
            $response = json_decode($result);
            if(isset($response->data[0]->status)){
                $status = $response->data[0]->status;
                $returnStatus[$phoneNumber] = $status;
            }else{
                $returnStatus[$phoneNumber] = $response->status . ': ' . $response->error_string;
            }
        }

        return json_encode($status);
    }

}