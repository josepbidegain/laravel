Click here to reset your password: <a href="{{ $link = url('password/email', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
