<html>
    <head>
        <style>
        table, th, td {
          border: 1px solid black;
        }
        </style>
        </head>
    <body>
        <script>
            function allNotes() {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET",'/admin/notes/' + document.getElementById("userId").value,true);
                xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState ===4 ){
                        if(xmlhttp.status ===200) {
                            var response = JSON.parse(xmlhttp.responseText);
                            var tbltop = `<table>
                                            <tr><th>Note Id</th><th>Content</th><th>Is Completed</th><th>Completed on</th></tr>`;
                            var tbldata ="";
                            for (i = 0; i < response.length; i++){
                                tbldata += "<tr><td>"+response[i].id+"</td><td>"+response[i].data+"</td><td>"+response[i].isCompleted+"</td><td>"+response[i].completedAt+"</td></tr>";
                                }
                            var tblbottom = "</table>";
                            var tbl = tbltop + tbldata + tblbottom;
                            document.getElementById("allNotesResult").innerHTML = tbl;
                        } else {
                              document.getElementById("allNotesResult").innerHTML = "Failed to get notes"
                          }
                    }
                };
                xmlhttp.send();
            }
        </script>
        <h1>Welcome to ToDo. Please select an option</h1>
        <button onclick="location.href = 'login';" id="myButton">Login</button>
        <button onclick="location.href = 'register';" id="myButton">Create new user</button>
        <hr style="width:50%;text-align:left;margin-left:0">
        <div>
        UserId : <input id="userId" name="userId" value="0"><br>
        <button onclick="allNotes()">Get all Notes</button>
        <div id="allNotesResult"> </div>
        </div>
    </body>
</html>
