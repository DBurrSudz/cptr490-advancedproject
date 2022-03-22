<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .heading {
            padding: 8px;
            width: 100%
            bottom-border-width: medium;
            border-bottom-color: #dedede;
            color: black;
            font-size: 20px;
            font-family: 'Poppins';
            
        }

        .job {
            margin-top: 8px;
            font-family: 'Poppins';
            font-size: 14px;
        }

        .posted {
            margin-top: 2px;
            font-family: 'Poppins';
            font-style: italic;
            color: black;
            font-size: 14px;
        }

        .inner {
            width: 50%;
            height: 250px;
            border-radius: 24px;
            padding: 16px;
            border-width: medium;
            border-radius: 20px;
            border-color: black;
            background-color: #d4d4d4;
        }

        .shadow-md {
            --tw-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --tw-shadow-colored: 0 4px 6px -1px var(--tw-shadow-color), 0 2px 4px -2px var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
        }
        </style>
</head>
<body>
    <div class="container">
        <div class="inner .shadow-md">
            <h1 class="heading">Congrats! You have accepted for the following job.</h1>
            <h1 class="job">{{$job}}</h1>
            <p class="posted">Posted: {{$posted}}</p>
        </div>
    </div>
</body>
</html>




