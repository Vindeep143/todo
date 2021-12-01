<html>
    <body>
    <script>
        url = '/user';
        function register() {
            const json = {
                "username": document.getElementById("username").value,
                "password": document.getElementById("password").value,
                "email": document.getElementById("email").value
            };
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST",url,true);
            xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xmlhttp.onreadystatechange = function() {
                if(xmlhttp.readyState ===4 ){
                    if(xmlhttp.status ===201) {
                        var response = JSON.parse(xmlhttp.responseText);
                        document.getElementById("status").innerHTML = "User " + response.username + " successfully created";
                    } else {
                          var response = JSON.parse(xmlhttp.responseText);
                          document.getElementById("status").innerHTML = response.status;
                      }
                }
            };
            xmlhttp.send(JSON.stringify(json));
        }
    </script>
        <h1>Create new ToDo user</h1>
          <label for="username">User Name:</label><br>
          <input type="text" id="username" name="username" value="John"><br>
          <label for="email">Email:</label><br>
          <input type="text" id="email" name="email" value="test@todo.com"><br>
          <label for="password">Password:</label><br>
          <input type="password" id="password" name="password" value="Doe"><br><br>
          <input type="submit" value="Register" onClick = "register()">
          <button value="login" onClick = "location.href = '/login'">Login</button>
        <form id="redirectForm" action="/dashboard" method="GET">
          <input type="hidden" id="api_token" name="api_token" value="John"><br>
        </form>
        <div id="status"> </div>
    </body>
</html>
