<?php
function getPreferredLanguage($availableLanguages, $default = 'en') {
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        foreach ($langs as $lang) {
            $lang = substr($lang, 0, 2); // 获取前两位，即语言代码
            if (in_array($lang, $availableLanguages)) {
                return $lang;
            }
        }
    }
    return $default; // 如果没有匹配的语言，返回默认语言
}

// 定义所有支持的语言和地区代码，包括香港地区
$availableLanguages = [
    'en' => 'English',
    'zh' => 'Chinese (Simplified)',
    'zh-HK' => 'Chinese (Traditional, Hong Kong)',
    'fr' => 'French',
    'ko' => 'Korean',
    'ru' => 'Russian',
    'tw' => 'Chinese (Traditional, Taiwan)',
    'sg' => 'Chinese (Simplified, Singapore)',
    'vi' => 'Vietnamese',
    'de' => 'German',
    'es' => 'Spanish',
    'ja' => 'Japanese'
];

$defaultLanguage = 'en';
$language = getPreferredLanguage(array_keys($availableLanguages), $defaultLanguage);

// 选择对应的HTML文件
$htmlFile = __DIR__ . "/{$language}/index.html";

// 如果文件不存在，使用默认语言文件
if (!file_exists($htmlFile)) {
    $htmlFile = __DIR__ . "/{$defaultLanguage}/index.html";
}

// 读取HTML文件内容
$htmlContent = file_get_contents($htmlFile);

// 动态生成hreflang标签
$hreflangTags = '';
foreach ($availableLanguages as $lang => $name) {
    $hreflangTags .= "<link rel=\"alternate\" href=\"https://base64-afs.pages.dev/{$lang}/\" hreflang=\"{$lang}\">";
}

// 输出HTML内容，并插入hreflang标签
$htmlContent = str_replace('</head>', $hreflangTags . '</head>', $htmlContent);
echo $htmlContent;
?>
