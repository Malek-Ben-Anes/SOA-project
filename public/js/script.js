// function for call web service for interest and interest
function getInterested( project_id ){

            var xhttp = new XMLHttpRequest();

            if (document.getElementById("interest-" + project_id).className == "btn btn-success") {
                
                url = "/flanci-preparation/public/api/v1/get-disinterested-in-project/" + project_id;
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
                url = "/flanci-preparation/public/api/v1/get-interested-in-project/" + project_id;
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
                
                url = "/flanci-preparation/public/api/v1/delete-skill-by-id/" + skill_id;
                xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var json = JSON.parse(this.responseText);

                    if(json.status == true){
                        skillButton = document.getElementById("skill-" + skill_id).className = "btn btn-default";
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
                url = "/flanci-preparation/public/api/v1/add-skill-by-id/" + skill_id;
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


  function addskill( skill_id ){

            var xhttp = new XMLHttpRequest();
         
        
                url = "/flanci-preparation/public/api/v1/add-skill-by-id/" + skill_id;
                xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var json = JSON.parse(this.responseText);

                    if(json.status == true){
                        // skillButton = document.getElementById("skill-" + skill_id).className = "btn btn-success";
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


function notifications(){
  var xhttp = new XMLHttpRequest();

  url = "/flanci-preparation/public/api/v1/get-notifications";
                xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var json = JSON.parse(this.responseText);

                    if(json.status == true){
                      var myObj = JSON.parse(this.responseText);

                // for (notification in myObj.data) {
                //     display +=  '<li class="well well-bg">';
                //     display += "<a href=\"{{ URL::asset('/enterprise/' . $notification->pivot->notifier_id) }}\">";
                //     display += "</a> ";
                //     display += '<a href="#" >{{ $notification->title }}</a>';
                //     display += "</li>";
                // }
                      document.getElementById("notification-view-more").innerHTML = this.responseText;

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

function messages(){
  console.log("get notifications");
};



 function notifications(){
  var xhttp = new XMLHttpRequest();
  url = "/flanci-preparation/public/api/v1/get-notifications";
                xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var json = JSON.parse(this.responseText);

                    if(json.status == true){
                      var myObj = JSON.parse(this.responseText);
                      var data = myObj.status;
                      console.log(data);
                     console.log(typeof(data));
               
                      document.getElementById("notification-view-more").innerHTML = this.responseText;

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

function notifications_display( text){

     var myObj = JSON.parse(this.responseText);
       var data = myObj.data;
                     alert(data);
                // for (notification in myObj.data) {
                //     display +=  '<li class="well well-bg">';
                //     display += "<a href=\"{{ URL::asset('/enterprise/' ) }}";
                //     display +=   notification.enterprise.logo ;
                //     display +=  "\">";
                //     display += notification.enterprise.enterprise_name;
                //     display += "</a> ";
                //     display += '<a href="#" >notification.title</a>';
                //     display += "</li>";
                // }
                return display;

}