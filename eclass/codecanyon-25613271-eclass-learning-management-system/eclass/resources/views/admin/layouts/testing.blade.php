<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disable Screenshots Example</title>
    <style>
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            color: white;
            text-align: center;
            padding-top: 20%;
            font-size: 24px;
        }
    </style>
</head>
<body>
    <div id="content">
        <!-- Your website content goes here -->
        <h1>Welcome to My Website</h1>
        <p>This is some example content.</p>
    </div>
    <div class="overlay" id="overlay">
        <!-- Overlay content to show when screenshots are disabled -->
        <div id="overlay-text">
            <p>Screenshots are disabled on this website.</p>
            <button onclick="reloadPage()">Click here to reload</button>
        </div>
    </div>

    <script>
        // Function to hide content and show overlay
        function hideContent() {
            document.querySelector('#content').style.display = 'none';
            document.querySelector('.overlay').style.display = 'block';
        }

        // Function to reload the page with an alert
        function reloadPage() {
            alert('Reloading the page...');
            location.reload();
        }

        // Event listener to detect PrintScreen key press
        document.addEventListener('keyup', function(e) {
            // Check if the key pressed is 'PrintScreen' or 'PrtScn'
            if (e.key === 'PrintScreen' || e.key === 'PrtScn') {
                hideContent();
            }
        });
    </script>
</body>
</html>
