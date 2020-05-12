<?php


namespace App\Core;


/**
 * Class Response
 * @package App\Core
 */
class Response
{
    const HTTP_CONTINUE = 100;
    const HTTP_SWITCHING_PROTOCOLS = 101;
    const HTTP_PROCESSING = 102;            // RFC2518
    const HTTP_EARLY_HINTS = 103;           // RFC8297
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
    const HTTP_NO_CONTENT = 204;
    const HTTP_RESET_CONTENT = 205;
    const HTTP_PARTIAL_CONTENT = 206;
    const HTTP_MULTI_STATUS = 207;          // RFC4918
    const HTTP_ALREADY_REPORTED = 208;      // RFC5842
    const HTTP_IM_USED = 226;               // RFC3229
    const HTTP_MULTIPLE_CHOICES = 300;
    const HTTP_MOVED_PERMANENTLY = 301;
    const HTTP_FOUND = 302;
    const HTTP_SEE_OTHER = 303;
    const HTTP_NOT_MODIFIED = 304;
    const HTTP_USE_PROXY = 305;
    const HTTP_RESERVED = 306;
    const HTTP_TEMPORARY_REDIRECT = 307;
    const HTTP_PERMANENTLY_REDIRECT = 308;  // RFC7238
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_PAYMENT_REQUIRED = 402;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_NOT_ACCEPTABLE = 406;
    const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    const HTTP_REQUEST_TIMEOUT = 408;
    const HTTP_CONFLICT = 409;
    const HTTP_GONE = 410;
    const HTTP_LENGTH_REQUIRED = 411;
    const HTTP_PRECONDITION_FAILED = 412;
    const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
    const HTTP_REQUEST_URI_TOO_LONG = 414;
    const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const HTTP_EXPECTATION_FAILED = 417;
    const HTTP_I_AM_A_TEAPOT = 418;                                               // RFC2324
    const HTTP_MISDIRECTED_REQUEST = 421;                                         // RFC7540
    const HTTP_UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
    const HTTP_LOCKED = 423;                                                      // RFC4918
    const HTTP_FAILED_DEPENDENCY = 424;                                           // RFC4918

    /**
     * @deprecated
     */
    const HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425;   // RFC2817

    const HTTP_TOO_EARLY = 425;                                                   // RFC-ietf-httpbis-replay-04
    const HTTP_UPGRADE_REQUIRED = 426;                                            // RFC2817
    const HTTP_PRECONDITION_REQUIRED = 428;                                       // RFC6585
    const HTTP_TOO_MANY_REQUESTS = 429;                                           // RFC6585
    const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585
    const HTTP_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_NOT_IMPLEMENTED = 501;
    const HTTP_BAD_GATEWAY = 502;
    const HTTP_SERVICE_UNAVAILABLE = 503;
    const HTTP_GATEWAY_TIMEOUT = 504;
    const HTTP_VERSION_NOT_SUPPORTED = 505;
    const HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                        // RFC2295
    const HTTP_INSUFFICIENT_STORAGE = 507;                                        // RFC4918
    const HTTP_LOOP_DETECTED = 508;                                               // RFC5842
    const HTTP_NOT_EXTENDED = 510;                                                // RFC2774
    const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;                             // RFC6585

    /**
     * @var string[] Permet d'obtenir les labels associés aux status HTTP
     * @see Response::setStatusCode()
     */
    public static $statusTexts = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',            // RFC2518
        103 => 'Early Hints',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',          // RFC4918
        208 => 'Already Reported',      // RFC5842
        226 => 'IM Used',               // RFC3229
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',    // RFC7238
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',                                               // RFC2324
        421 => 'Misdirected Request',                                         // RFC7540
        422 => 'Unprocessable Entity',                                        // RFC4918
        423 => 'Locked',                                                      // RFC4918
        424 => 'Failed Dependency',                                           // RFC4918
        425 => 'Too Early',                                                   // RFC-ietf-httpbis-replay-04
        426 => 'Upgrade Required',                                            // RFC2817
        428 => 'Precondition Required',                                       // RFC6585
        429 => 'Too Many Requests',                                           // RFC6585
        431 => 'Request Header Fields Too Large',                             // RFC6585
        451 => 'Unavailable For Legal Reasons',                               // RFC7725
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',                                     // RFC2295
        507 => 'Insufficient Storage',                                        // RFC4918
        508 => 'Loop Detected',                                               // RFC5842
        510 => 'Not Extended',                                                // RFC2774
        511 => 'Network Authentication Required',                             // RFC6585
    ];

    /**
     * @var Headers
     */
    public $headers;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var string
     */
    protected $statusText;

    /**
     * @var string
     */
    protected $charset;

    /**
     * @var bool
     */
    protected $errorsInSession;

    /**
     * @var bool
     */
    protected $saveInLastUrl = true;

    /**
     * Response constructor.
     *
     * @param string $content
     * @param int $status
     * @param array $headers
     * @param bool $errorsInSession
     */
    public function __construct($content = '', int $status = 200, array $headers = [], $errorsInSession = true)
    {
        $this->headers = new Headers($headers);
        $this->setContent($content);
        $this->setStatusCode($status);
        $this->setProtocolVersion('1.0');
        $this->errorsInSession = $errorsInSession;
    }

    /**
     * Factory, permet de créer une réponse à partir d'un content, status, headers
     *
     * @param string $content
     * @param int $status
     * @param array $headers
     * @param bool $errorsInSession
     * @return Response
     */
    public static function create($content = '', $status = 200, $headers = [], $errorsInSession = true)
    {
        return new static($content, $status, $headers, $errorsInSession);
    }

    /**
     * Défini si on sauvegarde l'url actuelle dans la session ou non
     *
     * @param $bool bool Faux pour garder l'url, true pour l'oublier
     */
    public function forgetMeInLastUrl($bool){
        $this->saveInLastUrl = !$bool;
    }

    /**
     * Renvoie si l'url doit être sauvegardée dans la session
     * @see Response::forgetMeInLastUrl()
     * @return bool
     */
    public function getLastUrlTrigger(){
        return $this->saveInLastUrl;
    }

    /**
     *  Permet de cloner l'objet
     */
    public function __clone()
    {
        $this->headers = clone $this->headers;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return
            sprintf('HTTP/%s %s %s', $this->version, $this->statusCode, $this->statusText)."\r\n".
            $this->headers."\r\n".
            $this->getContent();
    }

    /**
     * Permet de récupérer une valeur sauvegardée dans la session
     * @param $fieldName
     * @param string $default
     * @return array|mixed|null
     * @see Response::withInput()
     *
     */
    public static function old($fieldName, $default = ""){
        return Session::get("field.$fieldName", $default);
    }

    /**
     * Flash dans la session les arguments passés en POST et GET
     * Permet de rafraîchir une page sans perdre les données entrées dans les champs
     *
     * @return $this
     */
    public function withInput(){
        foreach(App::request()->getParams() as $key => $value){
            Session::flash("field.$key", $value);
        }
        return $this;
    }

    /**
     * Envoie les headers HTTP
     *
     * @return $this
     */
    public function sendHeaders()
    {
        if($this->errorsInSession){
            Session::flash('errors', App::getErrors());
            Session::flash('warnings', App::getWarnings());
            Session::flash('notifs', App::getNotifs());
            Session::flash('success', App::getSuccess());
        }

        // headers have already been sent by the developer
        if (headers_sent()) {
            error_log("Les headers ont déjà été envoyés !");
            return $this;
        }

        // headers
        foreach ($this->headers->all(false) as $name => $value) {
            $replace = 0 === strcasecmp($name, 'Content-Type');
            header($name.': '.$value, $replace, $this->statusCode);
        }

        // cookies
        foreach ($this->headers->getCookies() as $cookie) {
            header('Set-Cookie: '.$cookie, false, $this->statusCode);
        }

        // status
        header(sprintf('HTTP/%s %s %s', $this->version, $this->statusCode, $this->statusText), true, $this->statusCode);

        return $this;
    }

    /**
     * Envoie le contenu de la réponse
     *
     * @return $this
     */
    public function sendContent()
    {
        echo $this->content;

        return $this;
    }

    /**
     * Fonction finale, envoie les headers puis le contenu
     * @see App::handle()
     *
     * @return $this
     */
    public function send()
    {
        $this->sendHeaders();
        $this->sendContent();

        return $this;
    }

    /**
     * Défini le contenu de la réponse
     *
     * Les types autorisés sont les strings, nombres, null, et les objets avec une méthode __toString()
     *
     * @param mixed $content Un contenu qui doit être stringifiable
     *
     * @return $this
     *
     * @throws \UnexpectedValueException
     */
    public function setContent($content)
    {
        if (null !== $content && !\is_string($content) && !is_numeric($content) && !\is_callable([$content, '__toString'])) {
            throw new \UnexpectedValueException(sprintf('The Response content must be a string or object implementing __toString(), "%s" given.', \gettype($content)));
        }

        $this->content = (string) $content;

        return $this;
    }

    /**
     * Récupère le contenu défini
     *
     * @return string|false
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Défini la version du protocole HTTP (1.0 or 1.1).
     *
     * @param string $version
     * @return $this
     *
     * @final
     */
    public function setProtocolVersion(string $version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Récupère la version du protocole HTTP
     *
     * @final
     */
    public function getProtocolVersion(): string
    {
        return $this->version;
    }

    /**
     * Défini le status de la réponse
     * Si le texte n'est pas fourni, on le prend directement du tableau des status connus
     * @see $statusTexts
     *
     * @param int $code
     * @param null $text
     * @return $this
     */
    public function setStatusCode(int $code, $text = null)
    {
        $this->statusCode = $code;
        if ($this->isInvalid()) {
            throw new \InvalidArgumentException(sprintf('The HTTP status code "%s" is not valid.', $code));
        }

        if (null === $text) {
            $this->statusText = isset(self::$statusTexts[$code]) ? self::$statusTexts[$code] : 'unknown status';

            return $this;
        }

        if (false === $text) {
            $this->statusText = '';

            return $this;
        }

        $this->statusText = $text;

        return $this;
    }

    /**
     * Renvoie le status de la réponse défini
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Défini l'encodage de la réponse
     *
     * @param string $charset
     * @return $this
     */
    public function setCharset(string $charset)
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * Renvoie l'encodage de la réponse
     */
    public function getCharset(): ?string
    {
        return $this->charset;
    }

    /**
     * Modifie la réponse pour qu'elle soit conforme à la règle
     * définie pour un status 304
     *
     * On définit le status 304, on supprime le contenu de la réponse,
     * et on supprime tous les headers qui ne doivent pas être contenu
     * dans la réponse d'un status 304
     * @return $this
     *
     * @see https://tools.ietf.org/html/rfc2616#section-10.3.5
     */
    public function setNotModified()
    {
        $this->setStatusCode(304);
        $this->setContent(null);

        // remove headers that MUST NOT be included with 304 Not Modified responses
        foreach (['Allow', 'Content-Encoding', 'Content-Language', 'Content-Length', 'Content-MD5', 'Content-Type', 'Last-Modified'] as $header) {
            $this->headers->remove($header);
        }

        return $this;
    }

    /**
     * Est-ce que la réponse est invalide ?
     *
     * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
     */
    public function isInvalid(): bool
    {
        return $this->statusCode < 100 || $this->statusCode >= 600;
    }

    /**
     * Est-ce que la réponse est informationnelle ?
     */
    public function isInformational(): bool
    {
        return $this->statusCode >= 100 && $this->statusCode < 200;
    }

    /**
     * Est-ce que la réponse est un succès ?
     */
    public function isSuccessful(): bool
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }

    /**
     * Est-ce que la réponse est une redirection ?
     */
    public function isRedirection(): bool
    {
        return $this->statusCode >= 300 && $this->statusCode < 400;
    }

    /**
     * Est-ce que la réponse est une erreur client ?
     */
    public function isClientError(): bool
    {
        return $this->statusCode >= 400 && $this->statusCode < 500;
    }

    /**
     * Est-ce qu'il y a eu une erreur serveur ?
     */
    public function isServerError(): bool
    {
        return $this->statusCode >= 500 && $this->statusCode < 600;
    }

    /**
     * Est-ce que la réponse est OK ?
     */
    public function isOk(): bool
    {
        return 200 === $this->statusCode;
    }

    /**
     * Est-ce que la réponse est : interdite ?
     */
    public function isForbidden(): bool
    {
        return 403 === $this->statusCode;
    }

    /**
     * Est-ce que la réponse est page introuvable ?
     */
    public function isNotFound(): bool
    {
        return 404 === $this->statusCode;
    }

    /**
     * Est-ce que la réponse est une redirection ?
     *
     * @final
     * @param string|null $location
     * @return bool
     */
    public function isRedirect(string $location = null): bool
    {
        return in_array($this->statusCode, [201, 301, 302, 303, 307, 308]) && (null === $location ?: $location == $this->headers->get('Location'));
    }

    /**
     * Est-ce que la réponse est vide ?
     */
    public function isEmpty(): bool
    {
        return in_array($this->statusCode, [204, 304]);
    }
}