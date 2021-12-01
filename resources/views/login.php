<html>
    <body onload="redirect()">
        <script>
            url = '/user/authenticate';
            function authenticate() {
                const json = {
                    "username": document.getElementById("username").value,
                    "password": document.getElementById("password").value
                };
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("POST",url,true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState ===4 ){
                        if(xmlhttp.status ===200) {
                            var response = JSON.parse(xmlhttp.responseText);
                            sessionStorage.apiToken = response.api_token;
                            window.location.href = 'login';
                        } else {
                              var response = JSON.parse(xmlhttp.responseText);
                              document.getElementById("status").innerHTML = response.status;
                          }
                    }
                };
                xmlhttp.send(JSON.stringify(json));
            }

            function redirect(formdata) {
                if (typeof(Storage) !== "undefined") {
                    if(sessionStorage.apiToken) {
                        document.getElementById("api_token").value = sessionStorage.apiToken;
                        document.getElementById("redirectForm").submit();
                    }
                } else {
                    document.getElementById("status").innerHTML = "Sorry, your browser does not support web storage...";
                }
            }
        </script>
        <h1>ToDo Login Page</h1>
          <label for="username">User Name:</label><br>
          <input type="text" id="username" name="username" value="John"><br>
          <label for="password">Password:</label><br>
          <input type="password" id="password" name="password" value="Doe"><br><br>
          <input type="submit" value="Submit" onClick = "authenticate()">
        <form id="redirectForm" action="/dashboard" method="GET">
          <input type="hidden" id="api_token" name="api_token" value="John"><br>
        </form>
        <div id="status"> </div>
    </body>
</html>
