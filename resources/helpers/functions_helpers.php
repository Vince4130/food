<?php

/*if(!function_exists("tagVersion")) {
    
    function tagVersion()
    {
        $token = env('GITHUB_API_TOKEN');
        $repo = env('GITHUB_REPO');

        if (!$token || !$repo) {
            return response()->json(['error' => 'Token ou repo manquant dans .env'], 400);
        }

        $response = Http::withToken($token)
            ->withHeaders(['Accept' => 'application/vnd.github.v3+json'])
            ->get("https://api.github.com/repos/{$repo}/tags");

        if ($response->failed()) {
            return response()->json(['error' => 'Erreur API GitHub'], 500);
        }

        $tags = $response->json();

        if (empty($tags)) {
            return response()->json(['error' => 'Aucun tag trouvé'], 404);
        }

        $version = $tags[0]['name'];

        return $version;   
    }
}*/
    
    