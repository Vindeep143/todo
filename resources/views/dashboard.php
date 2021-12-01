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
            function logout() {
                sessionStorage.removeItem("apiToken");
                window.location.href = 'login';
            }
            function validate() {
                if(!sessionStorage.apiToken) {
                    window.location.href = 'login';
                }
            }
            function createNote() {
                validate();
                const json = {
                    "data": document.getElementById("data").value,
                    "isCompleted": "0"
                };
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("POST",'/note?api_token=' + sessionStorage.apiToken,true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState ===4 ){
                        if(xmlhttp.status ===201) {
                            var response = JSON.parse(xmlhttp.responseText);
                            document.getElementById("status").innerHTML = "Created new Note with id : " + response.id;
                        } else {
                              document.getElementById("status").innerHTML = "Failed to create note"
                          }
                    }
                };
                xmlhttp.send(JSON.stringify(json));
            }

            function findNote() {
                validate();
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET",'/note/' + document.getElementById("noteId").value + '?api_token=' +sessionStorage.apiToken,true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState ===4 ){
                        if(xmlhttp.status ===200) {
                            var response = JSON.parse(xmlhttp.responseText);
                            var tbltop = `<table>
                            			    <tr><th>Note Id</th><th>Content</th><th>Is Completed</th><th>Completed on</th></tr>`;
                            var tbldata = "<tr><td>"+response.id+"</td><td>"+response.data+"</td><td>"+response.isCompleted+"</td><td>"+response.completedAt+"</td></tr>";
                            var tblbottom = "</table>";
                            var tbl = tbltop + tbldata + tblbottom;
                            document.getElementById("findNoteResult").innerHTML = tbl;
                        } else {
                            var response = JSON.parse(xmlhttp.responseText);
                            document.getElementById("findNoteResult").innerHTML = response.status;
                          }
                    }
                };
                xmlhttp.send();
            }

            function allNotes() {
                validate();
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET",'/user/notes?api_token=' +sessionStorage.apiToken,true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
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

                              document.getElementById("allNotesResult").innerHTML = "Failed to create note"
                          }
                    }
                };
                xmlhttp.send();
            }

            function modifyNote(e) {
                e = e || window.event;
                var target = e.target || e.srcElement;
                validate();
                var baseUrl = "";
                var method = "";
                if (target.id === 'markCompleteButton') {
                    baseUrl = "/note/completed/";
                    method = "PUT";
                } else if (target.id === 'markInCompleteButton') {
                    method = "PUT";
                    baseUrl = "/note/incomplete/";
                } else if (target.id === 'deleteButton') {
                      method = "DELETE";
                      baseUrl = "/note/";
                  } else {
                    return;
                }
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open(method,baseUrl + document.getElementById("noteId").value + '?api_token=' +sessionStorage.apiToken,true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState ===4 ){
                        if(xmlhttp.status ===200) {
                            var response = JSON.parse(xmlhttp.responseText);
                            var tbltop = `<table>
                                            <tr><th>Note Id</th><th>Content</th><th>Is Completed</th><th>Completed on</th></tr>`;
                            var tbldata = "<tr><td>"+response.id+"</td><td>"+response.data+"</td><td>"+response.isCompleted+"</td><td>"+response.completedAt+"</td></tr>";
                            var tblbottom = "</table>";
                            var tbl = tbltop + tbldata + tblbottom;
                            document.getElementById("findNoteResult").innerHTML = tbl;
                        } else if(xmlhttp.status ===201) {
                              var response = JSON.parse(xmlhttp.responseText);
                               document.getElementById("findNoteResult").innerHTML = response.status;
                           } else {
                            var response = JSON.parse(xmlhttp.responseText);
                              document.getElementById("findNoteResult").innerHTML = response.status;
                          }
                    }
                };
                xmlhttp.send();

            }
        </script>
        <h1>Hi <?php echo $username; ?></h1>
        <button onclick="logout()">Log Out</button>
        <hr style="width:50%;text-align:left;margin-left:0">
        <div>
        <textarea id="data" name="data" rows="4">// Add note here
        </textarea><br>
        <div id="status"> </div>
        <button onclick="createNote()">Create Note</button>
        </div>
        <hr style="width:50%;text-align:left;margin-left:0">
        <div>
        <hr style="width:50%;text-align:left;margin-left:0">
        <div>
        <input id="noteId" name="noteId" value="0"><br>
        <button onclick="findNote()">Find Note</button>
        <button id="markCompleteButton" onclick="modifyNote(event)">Mark Completed</button>
        <button id="markInCompleteButton" onclick="modifyNote(event)">Mark Incomplete</button>
        <button id="deleteButton" onclick="modifyNote(event)">Delete Note</button>
        <div id="findNoteResult"> </div>
        </div>
        <hr style="width:50%;text-align:left;margin-left:0">
        <div>
        <button onclick="allNotes()">Get all Notes</button>
        <div id="allNotesResult"> </div>
        </div>
    </body>
</html>
