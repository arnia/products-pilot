<?php

define('EXP_TIME',5);

class SecureSessionHandler extends Singleton {

    protected $key, $name, $cookie;

    protected function __construct($key, $name = 'MY_SESSION', $cookie = [])
    {
        $this->key = $key;
        $this->name = $name;
        $this->cookie = $cookie;

        $this->cookie += [
            'lifetime' => 0,
            'path'     => ini_get('session.cookie_path'),
            'domain'   => ini_get('session.cookie_domain'),
            'secure'   => isset($_SERVER['HTTPS']),
            'httponly' => true
        ];

        $this->setup();
    }

    private function setup()
    {
        ini_set('session.use_cookies', 1);
        ini_set('session.use_only_cookies', 1);

        session_name($this->name);

        session_set_cookie_params(
            $this->cookie['lifetime'],
            $this->cookie['path'],
            $this->cookie['domain'],
            $this->cookie['secure'],
            $this->cookie['httponly']
        );
    }

    public function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            if (session_start()) {
                return mt_rand(0, 4) === 0 ? $this->refresh() : true; // 1/5
            }
        }

        return false;
    }

    public function refresh()
    {
        return session_regenerate_id(true);
    }

    public function forget()
    {
        if (session_status() == PHP_SESSION_NONE) {
            return false;
        }

        $_SESSION = [];

        //var_dump("forget-> ".session_id());

        return session_destroy();
    }

    public function read($id)
    {
        return mcrypt_decrypt(MCRYPT_3DES, $this->key, parent::read($id), MCRYPT_MODE_ECB);
    }

    public function write($id, $data)
    {
        return parent::write($id, mcrypt_encrypt(MCRYPT_3DES, $this->key, $data, MCRYPT_MODE_ECB));
    }

    public function isExpired()
    {
        $last = isset($_SESSION['_last_activity'])
            ? $_SESSION['_last_activity']
            : false;

        if ($last !== false && time() - $last > EXP_TIME * 60) {
            return true;
        }

        $_SESSION['_last_activity'] = time();

        return false;
    }

    public function isFingerprint()
    {
        $hash = md5(
            $_SERVER['HTTP_USER_AGENT'] .
            (ip2long($_SERVER['REMOTE_ADDR']) & ip2long('255.255.0.0'))
        );

        if (isset($_SESSION['_fingerprint'])) {
            return $_SESSION['_fingerprint'] === $hash;
        }

        $_SESSION['_fingerprint'] = $hash;

        return true;
    }

    public function isValid()
    {
        return ! $this->isExpired() && $this->isFingerprint();
    }

    public function get($name)
    {
        $parsed = explode('.', $name);

        $result =& $_SESSION;

        while ($parsed) {
            $next = array_shift($parsed);

            if (isset($result[$next])) {
                $result =& $result[$next];
            } else {
                return null;
            }
        }

        return $result;
    }

    public function getDelete($name)
    {
        $parsed = explode('.', $name);

        $result =& $_SESSION;
        $value = null;

        while ($parsed) {
            $next = array_shift($parsed);
            if (isset($result[$next])) {
                $result =& $result[$next];
                $value = $result;
            } else {
                return null;
            }
        }

        $result = [];

        return $value;
    }

    public function put($name, $value)
    {
        $parsed = explode('.', $name);

        $session =& $_SESSION;

        while (count($parsed) > 1) {
            $next = array_shift($parsed);

            if ( ! isset($session[$next]) || ! is_array($session[$next])) {
                $session[$next] = [];
            }

            $session =& $session[$next];
        }

        $session[array_shift($parsed)] = $value;
    }

    public function putc($name, $value, $time = 0.05)
    {
         return setcookie(
            $name,
            $value,
            time() + (3600 * $time),
            $this->cookie['path'],
            $this->cookie['domain'],
            $this->cookie['secure'],
            $this->cookie['httponly']
        );
    }

    public function getc($name)
    {

        if(isset($_COOKIE[$name])) return $_COOKIE[$name];

        return null;
    }

    public function distroyc($name)
    {
        setcookie(
            $name,
            null,
            time() - 3600,
            $this->cookie['path'],
            $this->cookie['domain'],
            $this->cookie['secure'],
            $this->cookie['httponly']
        );
    }

    public function isAuth(){
        if($this->getc('user_email')) return true;
        $this->start();
        if($this->isValid() && $this->get('user.email')) return true;

        $this->forget();
        $this->distroyc('user_email');
        return false;
    }

    public function isAdmin(){
        if($this->getc('user_admin')) return true;
        $this->start();
        if($this->isAuth() && $this->get('user.admin')) return true;

        //var_dump($this->get('user.admin'));

        return false;
    }
}