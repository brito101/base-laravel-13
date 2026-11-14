<?php

namespace App\Models;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Shetabit\Visitor\Models\Visit as BaseVisit;

/**
 * Log de visitas (shetabit/visitor) com corpo e headers da requisição
 * cifrados em repouso usando a APP_KEY. Registrado em config/visitor.php
 * ("model"), usado pelo pacote em todas as gravações e relações.
 *
 * O corpo pode conter senhas, tokens e dados pessoais; os headers trazem
 * Cookie (sessão) e Authorization (Bearer/JWT). Ambos são gravados com o
 * cast "encrypted:array", e continuam legíveis via Eloquent para auditoria.
 */
class Visit extends BaseVisit
{
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'request' => 'encrypted:array',
            'headers' => 'encrypted:array',
        ]);
    }

    /**
     * Fragmentos de nomes de campo cujo valor nunca deve ser exibido em tela.
     */
    private const SENSITIVE_KEYS = '/pass|token|secret|otp|2fa|code|key|auth|cookie|session/i';

    /**
     * Decifra o "request" bruto (como vem da view visitors_view) e mascara
     * campos sensíveis, para exibição em listagens/dashboard.
     */
    public static function redactedRequest(?string $payload): string
    {
        if ($payload === null || $payload === '') {
            return '';
        }

        try {
            $data = json_decode(Crypt::decryptString($payload), true);
        } catch (DecryptException) {
            return '[não foi possível decifrar]';
        }

        if (! is_array($data) || $data === []) {
            return '';
        }

        return json_encode(
            self::redact($data),
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }

    /**
     * Mascara valores sensíveis da URL para exibição: parâmetros de query
     * com nomes sensíveis e o token no caminho de redefinição de senha.
     */
    public static function redactedUrl(?string $url): string
    {
        if ($url === null || $url === '') {
            return '';
        }

        $url = preg_replace('#(/reset-password/)[^/?\#]+#i', '$1********', $url);

        $queryStart = strpos($url, '?');
        if ($queryStart === false) {
            return $url;
        }

        parse_str(substr($url, $queryStart + 1), $params);

        return substr($url, 0, $queryStart).'?'.http_build_query(self::redact($params));
    }

    private static function redact(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_string($key) && preg_match(self::SENSITIVE_KEYS, $key)) {
                $data[$key] = '********';
            } elseif (is_array($value)) {
                $data[$key] = self::redact($value);
            }
        }

        return $data;
    }
}
