// function for call web service for interest and interest
function getInterested( project_id ){

  var xhttp = new XMLHttpRequest();

  if (document.getElementById("interest-" + project_id).className == "btn btn-success") {

    url = "/projetSOA/public/api/v1/get-disinterested-in-project/" + project_id;
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var json = JSON.parse(this.responseText);

        if(json.status == true){
          interestButton = document.getElementById("interest-" + project_id).className = "btn btn-default";
          console.log( json.data );
        }else{
          alert("not ok, you are not interested");
          console.log( json.error );
        }
      }
    };
    xhttp.open("GET", url, true);
    xhttp.send();
  }
  else {
    url = "/projetSOA/public/api/v1/get-interested-in-project/" + project_id;
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var json = JSON.parse(this.responseText);

        if(json.status == true){
          interestButton = document.getElementById("interest-" + project_id).className = "btn btn-success";
          console.log( json.data );
        }else{
          alert("not ok, you are not interested");
          console.log( json.error );
        }
      }
    };
    xhttp.open("GET", url, true);
    xhttp.send();

  }
};

function lien(){
  console.log( window.location.href );
};


// function for update profile skills
function updateskill( skill_id ){

  var xhttp = new XMLHttpRequest();
  if (document.getElementById("skill-" + skill_id).className == "btn btn-success") {

    url = "/projetSOA/public/api/v1/delete-skill-by-id/" + skill_id;
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var json = JSON.parse(this.responseText);

        if(json.status == true){
          skillButton = document.getElementById("skill-" + skill_id).className = "btn btn-basic";
          console.log( json.data );
        }else{
          alert("not ok, your skill is not deleted");
          console.log( json.error );
        }
      }
    };
    xhttp.open("GET", url, true);
    xhttp.send();
  }
  else {
    url = "/projetSOA/public/api/v1/add-skill-by-id/" + skill_id;
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var json = JSON.parse(this.responseText);

        if(json.status == true){
          skillButton = document.getElementById("skill-" + skill_id).className = "btn btn-success";
          console.log( json.data );
        }else{
          alert("not ok, your skill is not added");
          console.log( json.error );
        }
      }
    };
    xhttp.open("GET", url, true);
    xhttp.send();

  }
};


function addskill( skill_id, skill_name ){

  var xhttp = new XMLHttpRequest();
  url = "/projetSOA/public/api/v1/add-skill-by-id/" + skill_id;
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var json = JSON.parse(this.responseText);

      if(json.status == true){
      skillDiv = document.getElementById("skill-group");
      var skill = document.createElement("BUTTON");
      var textnode = document.createTextNode(skill_name);
      skill.classList.add('btn');
      skill.classList.add('btn-success');
      skill.id = "skill-" + skill_id;
      skill.appendChild(textnode);
      document.getElementById("skill-group").appendChild(skill);
      console.log( json.data );
    }else{
      alert("not ok, your skill is not added");
      console.log( json.error );
    }
  }
};
xhttp.open("GET", url, true);
xhttp.send();
};


                function a(){
                  var xhttp = new XMLHttpRequest();
                  var display = 'malek';
                  url = "/projetSOA/public/api/v1/get-notifications";
                  xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                      var json = JSON.parse(this.responseText);


                // for (notification in myObj.data) {
                //     display +=  '<li class="well well-bg">';
                //     display += "<a href=\"{{ URL::asset('/enterprise/' . $notification->pivot->notifier_id) }}\">";
                //     display += "</a> ";
                //     display += '<a href="#" >{{ $notification->title }}</a>';
                //     display += "</li>";
                // }
                document.getElementById("notification-view-more").innerHTML = display;

              }else{
                alert("a problem has occured : malek");
                console.log( json.error );
              }

            };
            xhttp.open("GET", url, true);
            xhttp.send();


            console.log('function notifications');
          };

          function messages(){
            console.log("get notifications");
          };



          var page_notif = 0;
          function notifications(){
            var xhttp = new XMLHttpRequest();
            page_notif++;
            url = "/projetSOA/public/api/v1/get-notifications?page=" + 1;
            xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                var json = JSON.parse(this.responseText);
                if(json.status == true){
                  var data = json.data;
                  console.log(data);
                  console.log(page_notif);
                  var HTMLDATA = displayNotifications(data);
                     // console.log(this.responseText);
                     // console.log(typeof(data));
                     HTMLDATA += '<div class="row"><div class="col-md-2 col-md-offset-5"><div class="fa fa-circle-o-notch fa-spin"></div></div></div>';
                     document.getElementById("notification-view-more").innerHTML   = HTMLDATA  ;
                   }else{
                    alert("a problem has occured");
                    console.log( json.error );
                  }
                }
              };
              xhttp.open("GET", url, true);
              xhttp.send();
              console.log('function notifications');
            };

            function displayNotifications( notifications ){
             var display = '';
             for (i in notifications) {

              display +=  '<div class="row">';
              display +=  '<div class="col-md-3">';
              display += '<a href="http://localhost/enterprise/';
              display += '" >';
              display += '<img src="http://localhost/projetSOA/public/uploads/enterprise/images/';
              display += 'orange.png'
              display += '"  style="width:89px;height:89px;" />';
              display += "</a> ";
              display += "</div>";
              display += '<div class="col-md-9">';
              display += '<p>' + notifications[i].title + '</p>' ;
              display += '<p>' + notifications[i].created_at + '</p>' ;
              display += "</li>";
              display += "</div>";
              display += "</div>";
              display += "<hr />";
            }
            return display;
          };

          function messages(){
            var xhttp = new XMLHttpRequest();
            url = "/projetSOA/public/api/v1/get-all-messages/1?page=1";
            xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                var json = JSON.parse(this.responseText);
                if(json.status == true){
                  var data = displayMessages(this.responseText);
                  document.getElementById("message-view-more").innerHTML = data;
                }else{
                  alert("a problem has occured");
                  console.log( json.error );
                }
              }
            };
            xhttp.open("GET", url, true);
            xhttp.send();
          };


          function displayMessages( response ){
           var display = '';
           var myObj = JSON.parse(response);
           for (notification in myObj.data) {
            display +=  '<li class="well well-bg">';
            display +=  '<div class="row">';
            display += '<a href="/uploads/enterprise/images/';
            display += 'orange.png';
            display += '">';
            display += "</a> ";
            display += '<img src="/projetSOA/public/uploads/enterprise/images/';
            display += 'orange.png';
            display += '"  style="width:48px;height:48px;" />';
            display += "</a> ";
            display += '<a href="" >';
            display += myObj.data[notification].content;
            display += "</a> ";
            display += "</div>";
            display += "</li>";
          }
          return display;
        };


         function suggestions( destinationName ){


            var xhttp = new XMLHttpRequest();
            url = "/projetSOA/public/api/v1/get-all-suggestions-by-name/ " + destinationName ;
            xhttp.onreadystatechange = function() {

              if (this.readyState == 4 && this.status == 200) {
                var json = JSON.parse(this.responseText);
                if(json.status == true){
                  var data = displaysuggestions(this.responseText);
                   console.log("suggestions returned");
                  // console.log(data);

                  document.getElementById("destination").innerHTML = data;

                }else{

                   console.log("suggestions console false");
                  alert("a problem has occured");
                  console.log( json.error );
                }
              }
            };
            xhttp.open("GET", url, true);
            xhttp.send();
          };


        function displaysuggestions( response ){
           var display = '';
           var myObj = JSON.parse(response);
           for (destination in myObj.data) {
            display +=  '<option value="' ;
            display +=  myObj.data[destination].title;
            display +=  '">' ;
          }
          return display;
        };
        
//function for adding new skills to a project
function addProjectskill( skill_id, skill_name, project_id ){

  var xhttp = new XMLHttpRequest();
  url = "/projetSOA/public/api/v1/add-project/" + project_id +"/skill/" + skill_id;
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var json = JSON.parse(this.responseText);

      if(json.status == true){
      var skill = document.createElement("BUTTON");
      var textnode = document.createTextNode(skill_name);
      skill.classList.add('btn');
      skill.classList.add('btn-success');
      skill.id = "skill-" + skill_id;
      skill.appendChild(textnode);
      document.getElementById("project-skill-group").appendChild(skill);
      console.log( json.data );
    }else{
      alert("not ok, your skill is not added");
      console.log( json.error );
    }
  }
};
xhttp.open("GET", url, true);
xhttp.send();
};

// function for update project skills By the enterprise
function updateProjectskill( skill_id, project_id ){

  var xhttp = new XMLHttpRequest();
  if (document.getElementById("skill-" + skill_id).className == "btn btn-success") {

    url = "/projetSOA/public/api/v1/delete-project/" + project_id +"/skill/" + skill_id;

    
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var json = JSON.parse(this.responseText);

        if(json.status == true){
          skillButton = document.getElementById("skill-" + skill_id).className = "btn btn-basic";
          console.log( json.data );
        }else{
          alert("not ok, your skill is not deleted");
          console.log( json.error );
        }
      }
    };
    xhttp.open("GET", url, true);
    xhttp.send();
  }
  else {
    url = "/projetSOA/public/api/v1/add-project/" + project_id +"/skill/" + skill_id;
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var json = JSON.parse(this.responseText);

        if(json.status == true){
          skillButton = document.getElementById("skill-" + skill_id).className = "btn btn-success";
          console.log( json.data );
        }else{
          alert("not ok, your skill is not added");
          console.log( json.error );
        }
      }
    };
    xhttp.open("GET", url, true);
    xhttp.send();

  }
};