<?php
    include('displayErrors.php');
    use PHPMailer\PHPMailer\PHPMailer;

    //Load composer's autoloader
    require 'vendor/autoload.php';

    $name = '';
    $contacts = '';
    $message = '';
    $email = '';
    $emptyNameError = '';
    $emptyContactsError = '';
    $emptyEmailError = '';
    $mailSentStatus = '';

    if (isset($_POST['ajaxRequest']) || isset($_POST['name'])) {
        $name = htmlspecialchars($_POST['name']);
        $contacts = htmlspecialchars($_POST['contacts']);
        $message = htmlspecialchars($_POST['message']);
        $email = htmlspecialchars($_POST['email']);
    }

    if (isset($_POST['ajaxRequest'])) {
        echo sendCallRequestByEmail($name, $contacts, $message, $email);
        exit;
    } else if (isset($_POST['name'])) {
        $formIsCorrect = true;
        if (strlenTrim($_POST['name']) == 0) {
            $emptyNameError = fieldShouldNotBeEmpty('Имя:');
            $formIsCorrect = false;
        }
        if (strlenTrim($_POST['contacts']) == 0) {
            $emptyContactsError = fieldShouldNotBeEmpty('Контакты:');
            $formIsCorrect = false;
        }
        if (strlenTrim($_POST['email']) == 0) {
            $emptyEmailError = fieldShouldNotBeEmpty('Почта:');
            $formIsCorrect = false;
        }
        if ($formIsCorrect) {
            $mailSentStatus = sendCallRequestByEmail($name, $contacts, $message, $email);
        }
    }

    function strlenTrim($str)
    {
        return strlen(trim($str));
    }

    function fieldShouldNotBeEmpty($field)
    {
        return "Поле '{$field}' не должно быть пустым!";
    }

    function sendCallRequestByEmail($name, $contacts, $message, $email): string
    {
        $subject = "$name хочет, чтобы ему(ей) перезвонили";
        $htmlMessage = "
                    <html>
                    <head></head>
                    <body>
                      <table>
                        <tr>
                          <td>Имя:</td><td>$name</td>
                        </tr>
                        <tr>
                          <td>Контакты:</td><td>$contacts</td>
                        </tr>
                        <tr>
                          <td>Сообщение:</td><td>$message</td>
                        </tr>
                      </table>
                    </body>
                    </html>
                ";

        if (sendMessageByGmail($subject, $htmlMessage, $email)) {
            $mailSentStatus = "С вами свяжутся в ближайшее время!";
        } else {
            $mailSentStatus = "К сожалению, не удалась отравить ваши контакты.";
        }

        return $mailSentStatus;
    }

    function sendMessageByGmail($subject, $htmlMessage, $email)
    {
        $mail = new PHPMailer(); // create a new object
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = "mboychenko129@gmail.com";
        $mail->Password = "mario123";
        $mail->SetFrom("mboychenko129@gmail.com");
        $mail->CharSet = "UTF-8";
        $mail->Subject = $subject;
        $mail->Body = $htmlMessage;
        $mail->AddAddress($email);

        return $mail->Send();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf8">
    <title>Форма заказа звонка</title>
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <script>
        $(function() {
            var dialog, form,
                name = $("#name"),
                contacts = $("#contacts"),
                email = $("#email"),
                allFields = $( [] ).add( name ).add( contacts ).add( email ),
                tips = $( ".validateTips" )

            function updateTips(t) {
                tips
                    .text( t )
                    .addClass( "ui-state-highlight" );
                setTimeout(function() {
                    tips.removeClass( "ui-state-highlight", 1500 );
                }, 500 );
            }

            function checkEmpty(o, n) {
                if (o.val().length == 0) {
                    o.addClass( "ui-state-error" );
                    updateTips( "Поле '" + n + "' не должно быть пустым" );
                    return false;
                }

                return true;
            }

            dialog = $("#callRequestForm").dialog({
                autoOpen: false,
                height: 550,
                width: 400,
                modal: true,
                buttons: {
                    "Заказать звонок": doCallRequest,
                    "Отмена": function() {
                        dialog.dialog( "close" );
                    }
                },
                close: function() {
                    form[ 0 ].reset();
                    allFields.removeClass("ui-state-error");
                }
            });
            $("#openCallRequestForm").button().on("click", function() {
                dialog.dialog("open");
            });
            form = dialog.find("form").on("submit", function(event) {
                event.preventDefault();
                doCallRequest();
            });
            function doCallRequest() {
                var valid = true;
                allFields.removeClass( "ui-state-error" );

                valid = valid && checkEmpty( name, "Имя");
                valid = valid && checkEmpty( contacts, "Контакты");
                valid = valid && checkEmpty( email, "Почта");

                if (valid) {
                    $.ajax({
                        type: 'POST',
                        url: 'index.php',
                        data: form.serialize()
                    })
                    .done(function(data){
                        alert(data);
                    })
                    .fail(function() {
                        // just in case posting your form failed
                        alert( "Posting failed." );
                    });

                    dialog.dialog( "close" );
                }
                return valid;
            }
        });
    </script>
</head>
<body>
    <style>
        textarea {
            resize: none;
            margin-bottom: 10px;
        }
        input { margin-bottom: 10px; }
        p {
            margin: 0;
            margin-bottom: 10px;
        }
    </style>

    <div>
        <a href="..">Портфолио</a> &bull; <a href="#">Форма - "Заказать звонок"</a>
        <hr>
    </div>

    <div class="js-enabled">
        <style>
            label, input {
                display: block;
            }
            fieldset {
                padding: 0;
                border: 0;
                margin-top: 25px;
            }
        </style>
        <div id="callRequestForm" title="Форма заказа звонка">
            <p class="validateTips">Поля 'Имя', 'Контакты' и 'Почта' обязательны для заполнения</p>
            <form>
                <fieldset>
                    <label for="name">Имя:</label>
                    <input type="text" name="name" id="name" value="">
                    <label for="contacts">Контакты:</label>
                    <input type="text" name="contacts" id="contacts" value="">
                    <label for="message">Сообщение:</label>
                    <textarea rows="8" cols="37" name="message" value=""></textarea>
                    <label for="name">Почта: (укажите свою почту для проверки отправки письма)</label>
                    <input type="text" name="email" id="email" value="">
                    <input type="hidden" name="ajaxRequest">

                    <!-- Allow form submission with keyboard without duplicating the dialog button -->
                    <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                </fieldset>
            </form>
        </div>

        <button id="openCallRequestForm">Заказать звонок</button>
    </div>
    <noscript>
        <style type="text/css">
            .js-enabled { display: none; }
            form { width: 360px; }
        </style>
        <p>Поля 'Имя', 'Контакты' и 'Почта' обязательны для заполнения</p>
        <form method="POST" action="index.php">
            Имя: <input type="text" name="name" value="<?=$name?>">
            Контакты: <input type="text" name="contacts" value="<?=$contacts?>">
            Сообщение: <textarea rows="8" cols="50" name="message"><?=$message?></textarea>
            Почта: (укажите свою почту для проверки отправки письма) <input type="text" name="email" value="<?=$email?>">
            <input type="submit" value="Заказать звонок">
        </form>
        <div><?=$emptyNameError?></div>
        <div><?=$emptyContactsError?></div>
        <div><?=$emptyEmailError?></div>
        <div><?=$mailSentStatus?></div>
    </noscript>
</body>
</html>
