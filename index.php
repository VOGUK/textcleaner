<?php
// Initialize variables
$inputText = '';
$outputText = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the text from the form submission
    $inputText = $_POST['markup_text'] ?? '';
    
    // Step 1: Remove HTML and PHP tags
    $outputText = strip_tags($inputText);
    
    // Step 2: Completely strip out the Markdown symbols (# and *)
    $markdownSymbols = ['#', '*'];
    $outputText = str_replace($markdownSymbols, '', $outputText);
    
    // Step 3: Clean up the leftover spaces!
    // Remove spaces at the very beginning of any line (fixes the "### Heading" issue)
    $outputText = preg_replace('/^[ \t]+/m', '', $outputText);
    
    // Turn any double/multiple spaces into a single space (fixes the "** bold **" issue)
    $outputText = preg_replace('/[ \t]+/', ' ', $outputText);
    
    // Trim any extra empty lines or spaces from the very top and bottom of the text
    $outputText = trim($outputText);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Markup & Markdown Remover App</title>
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
        .output-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px dashed #eee;
        }
        #plain_text {
            background-color: #fafafa;
            border-color: #bbb;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Text Cleaner App</h1>
        <p>Paste your text below. This tool will strip out HTML/XML tags, erase Markdown symbols (<strong>#</strong>, <strong>*</strong>), and clean up any leftover weird spacing.</p>

        <form method="POST" action="">
            <label for="markup_text">Text with Markup:</label>
            <textarea name="markup_text" id="markup_text" placeholder="### Paste your **text** here..."><?php echo htmlspecialchars($inputText, ENT_QUOTES, 'UTF-8'); ?></textarea>
            
            <button type="submit">Erase Markup</button>
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <div class="output-section">
                <label for="plain_text">Resulting Plain Text:</label>
                <textarea id="plain_text" readonly><?php echo htmlspecialchars($outputText, ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
