<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LanguageFilter implements FilterInterface
{
    /**
     * This function sets the application's language locale based on the userLanguage request header.
     * it uses that locale; otherwise, it defaults to Turkish (tr). The locale is then set via the language service.
     * */
    public function before(RequestInterface $request, $arguments = null): void
    {
        $userLanguage = $request->getHeaderLine('userLanguage') ?? 'tr';

        $locale = in_array($userLanguage, config("app")->supportedLocales)
            ? $request->getHeaderLine('userLanguage')
            : 'tr';

        service('language')->setLocale($locale);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){}
}
