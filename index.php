<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<form action="">
    <input type="text" name="city" placeholder="Город">
    <input type="submit" value="Поиск">
</form>

</body>
</html>

<?php

if (isset($_GET['city'])) {
    $city = $_GET['city'];

    $url = 'https://kladr-api.ru/api.php';

    $options = [
        'query' => $city,
        'oneString' => 1,
        'withParent' => 1,
        'limit' => 50
    ];

    $result = curl_init();
    curl_setopt($result, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($result, CURLOPT_URL, $url . '?' . http_build_query($options));

    $response = curl_exec($result);
    $data = json_decode($response, true);
    curl_close($result);

    echo '<pre>';
    unset($data['result'][0]); // убираем строку триал версии

    if (!empty($data['result'])) {
        foreach ($data['result'] as $v) {
            $result = $v['fullName'];
            echo '<br>' . $result . '<br>';
        }
    } else {
        echo '<br>' . 'Ничего не найдено! Повторите поиск...' . '<br>';
    }
} else {
    echo '<br>' . 'Введите запрос' . '<br>';
}
