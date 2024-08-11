<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    private $client;
    private $accessToken;

    public function __construct(Google_Client $client)
    {
        $this->client = $client;
    }

    /**
     * Autentica con Google y obtiene el token de acceso.
     *
     * @param Request $request
     * @return void
     */
    public function auth(Request $request)
    {
        $data = $request->all();
        $this->client->setApplicationName(config('google.application_name'));
        $this->client->setAuthConfig(base_path('credentials_google.json'));
        $this->client->setScopes([config('google.scope')]);
        $this->client->setRedirectUri(config('google.redirect_uri'));

        if (!array_key_exists('code', $data)) {

            $authUrl = $this->client->createAuthUrl();

            return response()->json(compact('authUrl'));

        } else {
            try {
                $this->client->authenticate($data['code']);

                $accessTokenArray = $this->client->getAccessToken();

                $accessToken = json_encode($accessTokenArray);


                // Almacenar el token de acceso en la sesión

                session()->put('google_access_token', $accessToken);

            } catch (\Exception $e) {

                return response()->json(['error' => $e->getMessage()], 500);

            }

        }
    }

    public function createTask(Request $request)
    {
        return response()->json($this->createEvent('Probando mi API', 'Descripción de la tarea', '2024-07-27T10:00:00', '2024-07-27T11:00:00'));
    }

    /**
     * Crea una tarea en el calendario de Google.
     *
     * @param string $title Título de la tarea
     * @param string $description Descripción de la tarea
     * @param string $startDateTime Fecha y hora de inicio de la tarea
     * @param string $endDateTime Fecha y hora de fin de la tarea
     * @return void
     */
    public function createEvent($title, $description, $startDateTime, $endDateTime)
    {
        if (!session()->has('google_access_token')) {
            return response()->json(['error' => 'No se ha autenticado con Google'], 401);
        }

        $accessToken = session()->get('google_access_token');

        $this->client->setAccessToken($accessToken);

        $service = new Google_Service_Calendar($this->client);

        $event = new Google_Service_Calendar_Event();
        $event->setSummary($title);
        $event->setDescription($description);

        $start = new Google_Service_Calendar_EventDateTime();
        $start->setDateTime($startDateTime);
        $event->setStart($start);

        $end = new Google_Service_Calendar_EventDateTime();
        $end->setDateTime($endDateTime);
        $event->setEnd($end);

        try {
            $service->events->insert('primary', $event);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

