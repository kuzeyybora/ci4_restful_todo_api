<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\App;

class LanguageFilter implements FilterInterface
{
    /**
     * This function sets the application's language locale based on the userLanguage request header.
     * If userLanguage is one of the allowed languages (defined in LanguageKeys::ALLOWED_LOCALS),
     * it uses that locale; otherwise, it defaults to Turkish (tr). The locale is then set via the language service.
     * */
    public function before(RequestInterface $request, $arguments = null): ?ResponseInterface
    {
        $userLanguage = $request->getHeaderLine('userLanguage') ?? 'tr';

        $locale = in_array($userLanguage, config(App::class)->supportedLocales)
            ? $request->getHeaderLine('userLanguage')
            : 'tr';

        service('language')->setLocale($locale);

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){}
}
