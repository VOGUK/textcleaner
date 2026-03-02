<?php
// Initialize variables
$inputText = '';
$outputText = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the text from the form submission
    $inputText = $_POST['markup_text'] ?? '';
    
    // Step 1: Remove HTML, PHP, and XML tags
    $outputText = strip_tags($inputText);
    
    // Step 2: Completely strip out Markdown symbols and specific punctuation
    // Note: We put the longest punctuation strings first so smaller ones don't 
    // trigger a partial replacement too early.
    $symbolsToRemove = [
        '#', 
        '*', 
        '.,,.', 
        ',,,', 
        ',,.', 
        ',.', 
        ',,'
    ];
    $outputText = str_replace($symbolsToRemove, '', $outputText);
    
    // Step 3: Clean up the leftover spaces
    // Remove spaces at the very beginning of any line
    $outputText = preg_replace('/^[ \t]+/m', '', $outputText);
    
    // Turn any double/multiple spaces into a single space
    $outputText = preg_replace('/[ \t]+/', ' ', $outputText);
    
    // Trim any extra empty lines or spaces from the very top and bottom
    $outputText = trim($outputText);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text Cleaner App</title>
    <style>
        :root {
            --primary-color: #0056b3;
            --bg-color: #f4f7f6;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            color: #333;
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        h1 {
            margin-top: 0;
            color: var(--primary-color);
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        textarea {
            width: 100%;
            height: 200px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: monospace;
            resize: vertical;
        }
        button {
            display: inline-block;
            background-color: var(--primary-color);
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 15px;
            transition: background 0.3s ease;
        }
        button:hover {
            background-color: #004494;
        }
        /* Style for the copy button */
        #copy_btn {
            background-color: #28a745; 
        }
        #copy_btn:hover {
            background-color: #218838;
        }
        /* Style for the clear button */
        #clear_btn {
            background-color: #6c757d;
            margin-left: 10px;
        }
        #clear_btn:hover {
            background-color: #5a6268;
        }
        .output-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px dashed #eee;
        }
        #plain_text {
            background-color: #fafafa;
            border-color: #bbb;
        }
        .button-group {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Text Cleaner App</h1>
        <p>Paste your text below. This tool will strip out HTML/XML tags, erase Markdown symbols, remove specific typos (like <strong>.,,.</strong>), and clean up formatting spaces.</p>

        <form method="POST" action="">
            <label for="markup_text">Text to Clean:</label>
            <textarea name="markup_text" id="markup_text" placeholder="Paste your text here..."><?php echo htmlspecialchars($inputText, ENT_QUOTES, 'UTF-8'); ?></textarea>
            
            <div class="button-group">
                <button type="submit">Clean Text</button>
                <button type="button" id="clear_btn" onclick="window.location.href=window.location.pathname;">Clear</button>
            </div>
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <div class="output-section">
                <label for="plain_text">Resulting Plain Text:</label>
                <textarea id="plain_text" readonly><?php echo htmlspecialchars($outputText, ENT_QUOTES, 'UTF-8'); ?></textarea>
                
                <button type="button" id="copy_btn" onclick="copyToClipboard()">Copy Text</button>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function copyToClipboard() {
            var copyText = document.getElementById("plain_text");
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            navigator.clipboard.writeText(copyText.value).then(function() {
                var btn = document.getElementById("copy_btn");
                var originalText = btn.innerText;
                btn.innerText = "Copied!";
                
                setTimeout(function() {
                    btn.innerText = originalText;
                }, 2000);
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
                alert("Failed to copy text. Please select and copy manually.");
            });
        }
    </script>
</body>
</html>
