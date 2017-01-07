<?php

namespace App\Auth;

use GuzzleHttp\Client;

class Proxy {
    /**
     * @SWG\Info(title="Api Document", version="1.0")
     */

    /**
     * @SWG\Post(
     *     path="/api/login",
     *     summary="login with oauth2",
     *     tags={"Login"},
     *     description="login with oauth2",
     *     operationId="login",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *      @SWG\Parameter(
     *         name="username",
     *         in="formData",
     *         description="Email Address",
     *         required=true,
     *         type="string",
     *        
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi",
     *         
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="formData",
     *         description="Password",
     *         required=true,
     *         type="string",
     *        
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi",
     *         
     *     ),
     * 
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",    
     *         
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid tag value",
     *     )
     * )
     */
    public function attemptLogin($credentials) {

       foreach ($credentials as $key => $value) {

            $user[] = $value;
        }
        
       $customers = \App\customer::where('mobile', $user[0])->first();
       
       //return($customers);
       
                if (isset($customers)) {
                    $credentials = array(
                        'username' => $customers->email,
                        'password' => $user[1]
                    );
                }
        return $this->proxy('password', $credentials);
    }

    /**
     * @SWG\Post(
     *     path="/api/refresh-token",
     *     summary="login with oauth2",
     *     tags={"Login"},
     *     description="login with oauth2",
     *     operationId="login",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *      @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="Authorization Token",
     *         required=true,
     *         type="string",
     *          default = "Bearer X5rjdLJ69U0OvMKZsnnIJsQPqbrUBFO1q8wzfL9L",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",    
     *         
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid tag value",
     *     )
     * )
     */
    public function attemptRefresh() {
        $crypt = app()->make('encrypter');
        $request = app()->make('request');
        $header_bearer = $request->header('Authorization');
        $header_bearer = trim(substr($header_bearer, 7));

        return $this->proxy('refresh_token', [
                    'refresh_token' => $header_bearer
        ]);
    }

    private function proxy($grantType, array $data = []) {
        try {
            $config = app()->make('config');

            $data = array_merge([
                'client_id' => $config->get('secrets.client_id'),
                'client_secret' => $config->get('secrets.client_secret'),
                'grant_type' => $grantType
                    ], $data);
//return ($data);
            $client = new Client();
            $guzzleResponse = $client->post(sprintf('%s/oauth/access-token', $config->get('app.url')), [
                'form_params' => $data
            ]);
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $guzzleResponse = $e->getResponse();
        }

        $response = json_decode($guzzleResponse->getBody());

        if (property_exists($response, "access_token")) {
            $cookie = app()->make('cookie');
            $crypt = app()->make('encrypter');

            $encryptedToken = $crypt->encrypt($response->refresh_token);

            // Set the refresh token as an encrypted HttpOnly cookie
            $cookie->queue('refreshToken', $encryptedToken, 604800, // expiration, should be moved to a config file
                    null, null, false, true // HttpOnly
            );

            $response = [
                'accessToken' => $response->access_token,
                'refreshToken' => $response->refresh_token,
                'accessTokenExpiration' => $response->expires_in
            ];
        }

        /* $response = response()->json($response);
          $response->setStatusCode($guzzleResponse->getStatusCode());

          $headers = $guzzleResponse->getHeaders();
          foreach($headers as $headerType => $headerValue) {
          $response->header($headerType, $headerValue);
          }
         * 
         */

        return response()->json($response);
    }

}
