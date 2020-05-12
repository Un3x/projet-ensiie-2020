<?php


namespace App\Core;


/**
 * Class Cookie
 * @package App\Core
 */
class Cookie
{
    /**
     * Clé de cookie
     */
    const SAMESITE_NONE = 'none';
    /**
     * Clé de cookie
     */
    const SAMESITE_LAX = 'lax';
    /**
     * Clé de cookie
     */
    const SAMESITE_STRICT = 'strict';

    /**
     * @var string Le nom du cookie
     */
    protected $name;
    /**
     * @var string|null La valeur du cookie
     */
    protected $value;
    /**
     * @var string|null Le domaine du cookie
     */
    protected $domain;
    /**
     * @var int La date d'expiration du cookie
     */
    protected $expire;
    /**
     * @var string Le path du cookie
     */
    protected $path;
    /**
     * @var bool|null Le secure du cookie
     */
    protected $secure;
    /**
     * @var bool Le type du cookie
     */
    protected $httpOnly;

    /**
     * @var bool
     */
    private $raw;
    /**
     * @var mixed
     */
    private $sameSite;
    /**
     * @var bool
     */
    private $secureDefault = false;

    /**
     * @var string
     */
    private static $reservedCharsList = "=,; \t\r\n\v\f";
    /**
     * @var string[]
     */
    private static $reservedCharsFrom = ['=', ',', ';', ' ', "\t", "\r", "\n", "\v", "\f"];
    /**
     * @var string[]
     */
    private static $reservedCharsTo = ['%3D', '%2C', '%3B', '%20', '%09', '%0D', '%0A', '%0B', '%0C'];

    /**
     * Crée un Cookie à partir d'un header brut
     *
     * @param string $cookie
     * @param bool   $decode
     *
     * @return static
     */
    public static function fromString($cookie, $decode = false)
    {
        $data = [
            'expires' => 0,
            'path' => '/',
            'domain' => null,
            'secure' => false,
            'httponly' => false,
            'raw' => !$decode,
            'samesite' => null,
        ];

        // Merci Symfony <3 <3 <3
        $quotedSeparators = preg_quote(';=', '/');
        preg_match_all('
            /
                (?!\s)
                    (?:
                        # quoted-string
                        "(?:[^"\\\\]|\\\\.)*(?:"|\\\\|$)
                    |
                        # token
                        [^"'.$quotedSeparators.']+
                    )+
                (?<!\s)
            |
                # separator
                \s*
                (?<separator>['.$quotedSeparators.'])
                \s*
            /x', trim($cookie), $matches, PREG_SET_ORDER);

        $parts = self::groupParts($matches, ';=');

        $part = array_shift($parts);

        $name = $decode ? urldecode($part[0]) : $part[0];
        $value = isset($part[1]) ? ($decode ? urldecode($part[1]) : $part[1]) : null;

        $assoc = [];
        foreach ($parts as $part) {
            $name = strtolower($part[0]);
            $value = $part[1] ?? true;
            $assoc[$name] = $value;
        }

        $data = $assoc + $data;

        if (isset($data['max-age'])) {
            $data['expires'] = time() + (int) $data['max-age'];
        }

        return new static($name, $value, $data['expires'], $data['path'], $data['domain'], $data['secure'], $data['httponly'], $data['raw'], $data['samesite']);
    }

    /**
     * Factory, instanciateur statique
     *
     * @param string $name
     * @param string|null $value
     * @param int $expire
     * @param string|null $path
     * @param string|null $domain
     * @param bool|null $secure
     * @param bool $httpOnly
     * @param bool $raw
     * @param string|null $sameSite
     * @return static
     */
    public static function create(string $name, string $value = null, $expire = 0, ?string $path = '/', string $domain = null, bool $secure = null, bool $httpOnly = true, bool $raw = false, ?string $sameSite = self::SAMESITE_LAX): self
    {
        return new self($name, $value, $expire, $path, $domain, $secure, $httpOnly, $raw, $sameSite);
    }

    /**
     * Le constructeur
     * @param string                        $name     The name of the cookie
     * @param string|null                   $value    The value of the cookie
     * @param int|string|\DateTimeInterface $expire   The time the cookie expires
     * @param string                        $path     The path on the server in which the cookie will be available on
     * @param string|null                   $domain   The domain that the cookie is available to
     * @param bool|null                     $secure   Whether the client should send back the cookie only over HTTPS or null to auto-enable this when the request is already using HTTPS
     * @param bool                          $httpOnly Whether the cookie will be made accessible only through the HTTP protocol
     * @param bool                          $raw      Whether the cookie value should be sent with no url encoding
     * @param string|null                   $sameSite Whether the cookie will be available for cross-site requests
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $name, string $value = null, $expire = 0, ?string $path = '/', string $domain = null, ?bool $secure = false, bool $httpOnly = true, bool $raw = false, string $sameSite = null)
    {
        if (9 > \func_num_args()) {
            @trigger_error(sprintf('The default value of the "$secure" and "$samesite" arguments of "%s"\'s constructor will respectively change from "false" to "null" and from "null" to "lax" in Symfony 5.0, you should define their values explicitly or use "Cookie::create()" instead.', __METHOD__), E_USER_DEPRECATED);
        }

        // from PHP source code
        if ($raw && false !== strpbrk($name, self::$reservedCharsList)) {
            throw new \InvalidArgumentException(sprintf('The cookie name "%s" contains invalid characters.', $name));
        }

        if (empty($name)) {
            throw new \InvalidArgumentException('The cookie name cannot be empty.');
        }

        // convert expiration time to a Unix timestamp
        if ($expire instanceof \DateTimeInterface) {
            $expire = $expire->format('U');
        } elseif (!is_numeric($expire)) {
            $expire = strtotime($expire);

            if (false === $expire) {
                throw new \InvalidArgumentException('The cookie expiration time is not valid.');
            }
        }

        $this->name = $name;
        $this->value = $value;
        $this->domain = $domain;
        $this->expire = 0 < $expire ? (int) $expire : 0;
        $this->path = empty($path) ? '/' : $path;
        $this->secure = $secure;
        $this->httpOnly = $httpOnly;
        $this->raw = $raw;

        if ('' === $sameSite) {
            $sameSite = null;
        } elseif (null !== $sameSite) {
            $sameSite = strtolower($sameSite);
        }

        if (!\in_array($sameSite, [self::SAMESITE_LAX, self::SAMESITE_STRICT, self::SAMESITE_NONE, null], true)) {
            throw new \InvalidArgumentException('The "sameSite" parameter value is not valid.');
        }

        $this->sameSite = $sameSite;
    }

    /**
     * Permet de groupe les parties avec les séparateurs donnés
     * @param array $matches
     * @param string $separators
     * @return array
     */
    private static function groupParts(array $matches, string $separators): array
    {
        $separator = $separators[0];
        $partSeparators = substr($separators, 1);

        $i = 0;
        $partMatches = [];
        foreach ($matches as $match) {
            if (isset($match['separator']) && $match['separator'] === $separator) {
                ++$i;
            } else {
                $partMatches[$i][] = $match;
            }
        }

        $parts = [];
        if ($partSeparators) {
            foreach ($partMatches as $matches) {
                $parts[] = self::groupParts($matches, $partSeparators);
            }
        } else {
            foreach ($partMatches as $matches) {
                $parts[] = preg_replace('/\\\\(.)|"/', '$1', $matches[0][0]);
            }
        }

        return $parts;
    }

    /**
     * Récupère le nom du cookie
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Récupère la valeur du cookie
     *
     * @return string|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Récupère le domaine de validité du cookie
     *
     * @return string|null
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Récupère la date d'expiration du cookie
     *
     * @return int
     */
    public function getExpiresTime()
    {
        return $this->expire;
    }

    /**
     * Récupère la durée maximale d'existence du cookie
     *
     * @return int
     */
    public function getMaxAge()
    {
        $maxAge = $this->expire - time();

        return 0 >= $maxAge ? 0 : $maxAge;
    }

    /**
     * Récupère le chemin de validité du cookie
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Vérifie si le cookie peut être envoyé en HTTP ou uniquement en HTTPS
     *
     * @return bool
     */
    public function isSecure()
    {
        return $this->secure ?? $this->secureDefault;
    }

    /**
     * Vérifie si le cookie ne peut être accédé uniquement par HTTP (et non Javascript)
     *
     * @return bool
     */
    public function isHttpOnly()
    {
        return $this->httpOnly;
    }

    /**
     * Vérifie si le cookie est sur le point d'être effacé
     *
     * @return bool
     */
    public function isCleared()
    {
        return 0 !== $this->expire && $this->expire < time();
    }

    /**
     * Vérifie si le cookie doit être envoyé sans url encoding
     *
     * @return bool
     */
    public function isRaw()
    {
        return $this->raw;
    }

    /**
     * Récupère l'attribut Samesite
     *
     * @return string|null
     */
    public function getSameSite()
    {
        return $this->sameSite;
    }

    /**
     * @param bool $default La valeur par défaut si le secure est null
     */
    public function setSecureDefault(bool $default): void
    {
        $this->secureDefault = $default;
    }
}