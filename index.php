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

$availableLanguages = ['en', 'zh', 'fr', 'ko'];
$defaultLanguage = 'en';
$language = getPreferredLanguage($availableLanguages, $defaultLanguage);

// 选择对应的HTML文件
$htmlFile = __DIR__ . "/lang/{$language}.html";

// 如果文件不存在，使用默认语言文件
if (!file_exists($htmlFile)) {
    $htmlFile = __DIR__ . "/lang/{$defaultLanguage}.html";
}

// 读取并输出HTML文件内容
echo file_get_contents($htmlFile);
?>