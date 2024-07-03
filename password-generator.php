<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            animation: fadeIn 1s ease-in-out;
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px 0 5px;
        }

        input[type="number"],
        input[type="checkbox"],
        button {
            margin-bottom: 15px;
        }

        input[type="number"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
        }

        .checkbox-group div {
            flex: 1;
            min-width: 50%;
        }

        button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        .generated-password {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            background-color: #f4f4f9;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .generated-password span {
            flex: 1;
        }

        .copy-btn {
            margin-left: 10px;
            padding: 5px 10px;
            background-color: #008CBA;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .copy-btn:hover {
            background-color: #007B9E;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }

            button {
                padding: 15px;
            }
        }
    </style>
    <script>
        function copyToClipboard() {
            var passwordText = document.getElementById('generatedPassword');
            navigator.clipboard.writeText(passwordText.innerText).then(function() {
                alert('Password copied to clipboard');
            }, function(err) {
                alert('Could not copy text: ', err);
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Password Generator</h1>
        <form method="post" action="">
            <label for="length">Password Length:</label>
            <input type="number" id="length" name="length" min="1" max="128" value="12" required>
            <br><br>

            <div class="checkbox-group">
                <div>
                    <input type="checkbox" id="includeUppercase" name="includeUppercase" checked>
                    <label for="includeUppercase">Include Uppercase Letters</label>
                </div>
                <div>
                    <input type="checkbox" id="includeLowercase" name="includeLowercase" checked>
                    <label for="includeLowercase">Include Lowercase Letters</label>
                </div>
                <div>
                    <input type="checkbox" id="includeNumbers" name="includeNumbers" checked>
                    <label for="includeNumbers">Include Numbers</label>
                </div>
                <div>
                    <input type="checkbox" id="includeSymbols" name="includeSymbols" checked>
                    <label for="includeSymbols">Include Symbols</label>
                </div>
            </div>

            <button type="submit" name="generate">Generate Password</button>
        </form>

        <?php
        if (isset($_POST['generate'])) {
            $length = isset($_POST['length']) ? intval($_POST['length']) : 12;
            $includeUppercase = isset($_POST['includeUppercase']);
            $includeLowercase = isset($_POST['includeLowercase']);
            $includeNumbers = isset($_POST['includeNumbers']);
            $includeSymbols = isset($_POST['includeSymbols']);

            $generatedPassword = generatePassword($length, $includeUppercase, $includeLowercase, $includeNumbers, $includeSymbols);
            echo "<div class='generated-password'><span id='generatedPassword'>{$generatedPassword}</span><button class='copy-btn' onclick='copyToClipboard()'>Copy</button></div>";
        }

        function generatePassword($length = 12, $includeUppercase = true, $includeLowercase = true, $includeNumbers = true, $includeSymbols = true) {
            $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $lowercase = 'abcdefghijklmnopqrstuvwxyz';
            $numbers = '0123456789';
            $symbols = '!@#$%^&*()-_=+<>?';

            $allCharacters = '';
            if ($includeUppercase) {
                $allCharacters .= $uppercase;
            }
            if ($includeLowercase) {
                $allCharacters .= $lowercase;
            }
            if ($includeNumbers) {
                $allCharacters .= $numbers;
            }
            if ($includeSymbols) {
                $allCharacters .= $symbols;
            }

            if ($allCharacters === '') {
                return 'Please select at least one character set.';
            }

            $password = '';
            $allCharactersLength = strlen($allCharacters);
            for ($i = 0; $i < $length; $i++) {
                $randomIndex = rand(0, $allCharactersLength - 1);
                $password .= $allCharacters[$randomIndex];
            }

            return $password;
        }
        ?>
    </div>
</body>
</html>
