<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login to <?php echo $AppName ?></title>
    <style>
        body {
            background-color: #FFFFFF;
        }

        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        #loader {
            display: block;
            position: relative;
            left: 50%;
            top: 50%;
            width: 150px;
            height: 150px;
            margin: -75px 0 0 -75px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #9370DB;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        #loader:before {
            content: "";
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #BA55D3;
            -webkit-animation: spin 3s linear infinite;
            animation: spin 3s linear infinite;
        }

        #loader:after {
            content: "";
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #FF00FF;
            -webkit-animation: spin 1.5s linear infinite;
            animation: spin 1.5s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="bg-white">

    <div id="preloader">
        <div id="loader"></div>
        
    </div>
    

    <form action="<?php echo $form_action_url ?>" method="post" id="myForm" name="myForm">
        <input type="hidden" name="username" value="<?php echo $user_and_time ?>" />
        <input type="hidden" name="continue" value="<?php echo $continue ?>" />

        <input type="submit" id='submit-btn' name="submit" value="OK" hidden>
    </form>

    <script>
        var seconds_left = 1;
        var interval = setInterval(function() {
           // document.getElementById('timer').innerHTML = --seconds_left;
            console.log( --seconds_left);
            if (seconds_left <= 0) {
                document.getElementById("submit-btn").click();
                clearInterval(interval);
            }
        }, 1000);
    </script>
</body>

</html>