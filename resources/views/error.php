<html>
    <body>
        <h1><?php echo $message; ?></h1>
        <button onclick="goBack()">Go Back</button>
        <script>
        function goBack() {
          window.history.back();
        }
        </script>
    </body>
</html>
