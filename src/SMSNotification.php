<?php

namespace App;

class SMSNotification
{
    const FROM = "+18126252537";

    protected string $to;
    protected string $sid;
    protected string $token;
    protected string $url = "https://api.twilio.com/2010-04-01/Accounts/";
    protected string $body;

    public function __construct()
    {
        $this->sid = getenv('TWILLIO_ACCOUNT_SID');
        $this->token = getenv('TWILLIO_ACCOUNT_TOKEN');
        $this->url .= $this->sid . "/Messages.json";
    }

    public function setBody(string $body): SMSNotification
    {
        $this->body = $body;
        return $this;
    }

    public function setTo(string $to): SMSNotification
    {
        $this->to = $to;
        return $this;
    }

    protected function getHeaders() {
        return [
            'Authorization: Basic ' . base64_encode($this->sid . ":" . $this->token),
            'Accept: application/json'
        ];
    }

//    protected function setUrl(): string
//    {
//        $body = urlencode("From=" . self::FROM . "&Body=" . $this->body);
//        return $this->url . $this->sid . "/Messages.json?" . $body;
//    }

    protected function makeBody() {
        return json_encode([
            'To' => $this->to,
            'From' => self::FROM,
            'Body' => $this->body,
        ]);
    }

    public function send()
    {
        $request = curl_init();
        curl_setopt($request, CURLOPT_URL, $this->url);
        curl_setopt($request, CURLOPT_POST, true);
        curl_setopt($request, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_PROXY_SSL_VERIFYPEER, false);
        curl_setopt($request, CURLOPT_POSTFIELDS, $this->makeBody());

        $response = curl_exec($request);

        curl_close($request);

        return $response;
    }
}
