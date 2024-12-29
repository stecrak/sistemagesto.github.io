<?php
require_once __DIR__ . '/vendor/autoload.php';

$client = new Google_Client();
$client->setAuthConfig('client_secret_862539758703-ndjikdmsln8vcbunc7ihigck26057b0v.apps.googleusercontent.com.json');
$client->addScope(Google_Service_Drive::DRIVE);

$tokenPath = 'token.json';

if (file_exists($tokenPath)) {
    $accessToken = json_decode(file_get_contents($tokenPath), true);
    $client->setAccessToken($accessToken);

    if ($client->isAccessTokenExpired()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
} else {
    if (!isset($_GET['code'])) {
        $authUrl = $client->createAuthUrl();
        header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
        exit;
    } else {
        $authCode = $_GET['code'];
        try {
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            if (isset($accessToken['error'])) {
                throw new Exception($accessToken['error_description']);
            }
            file_put_contents($tokenPath, json_encode($accessToken));
            $client->setAccessToken($accessToken);
        } catch (Exception $e) {
            echo 'Error al obtener el token: ' . $e->getMessage();
            exit;
        }
    }
}

$driveService = new Google_Service_Drive($client);

try {
    $results = $driveService->files->listFiles([
        'q' => "mimeType = 'application/vnd.google-apps.folder' and trashed = false",
        'fields' => 'files(id, name)'
    ]);
    $files = $results->getFiles();

    if (count($files) === 0) {
        echo "No se encontraron carpetas.\n";
    } else {
        foreach ($files as $file) {
            printf("ID: %s, Nombre: %s\n", $file->getId(), $file->getName());
        }
    }
} catch (Exception $e) {
    echo 'Se produjo un error: ' . $e->getMessage();
}
?>
