<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    
    // URL для отправки данных в Bitrix 24
    $webhook = 'https://b24-abo01v.bitrix24.kz/rest/1/jmvv084xf20ep5p8/crm.lead.add.json';
    
    $data = [
        'fields' => [
            'TITLE' => 'Заявка с сайта',
            'NAME' => $name,
            'EMAIL' => [['VALUE' => $email, 'VALUE_TYPE' => 'WORK']],
            'COMMENTS' => $message,
            'SOURCE_ID' => 'WEB',
        ],
    ];

    // Отправка данных
    $ch = curl_init($webhook);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $response = curl_exec($ch);
    curl_close($ch);

    // Обработка ответа
    $response = json_decode($response, true);
    if (isset($response['error'])) {
        // Обработка ошибки
        echo "Ошибка: " . $response['error_description'];
    } else {
        // Лид успешно создан
        echo "Заявка успешно отправлена!";
    }
}
?>
