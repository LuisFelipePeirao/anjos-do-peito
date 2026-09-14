<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    protected function buildMailMessage($url): MailMessage
    {
        $expirationMinutes = config('auth.passwords.'.config('auth.defaults.passwords').'.expire');

        return (new MailMessage)
            ->subject('Redefinicao de senha')
            ->greeting('Ola!')
            ->line('Recebemos uma solicitacao para redefinir a senha da sua conta.')
            ->action('Redefinir senha', $url)
            ->line("Este link expira em {$expirationMinutes} minutos.")
            ->line('Se voce nao solicitou a redefinicao de senha, ignore este e-mail.');
    }
}
