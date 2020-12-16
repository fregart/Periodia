

// Checks if the input is letters only
function validate(textinput) {

    var alphaExp = /^[a-z���A-Z���0-9���]+$/;
    var e = document.getElementById(textinput.name + "-error");

    if (textinput.value.match(alphaExp) && textinput.value != null) {
        textinput.style.backgroundColor = "#ccffcc";
        e.innerHTML = "";

    } else {
        textinput.style.backgroundColor = "#ffcccc";
        e.innerHTML = "Får bara innehålla bokstäver och siffror";
    }
}

// Password, check if the password is the same as in the retype field
function validatePassword(textinput) {

    var pass1 = document.getElementById("pass1Input").value;
    var pass2 = document.getElementById("pass2Input").value;

    var pass1element = document.getElementById("pass1Input");
    var pass2element = document.getElementById("pass2Input");

    var e = document.getElementById(textinput.name + "-error");

    // If some of the fields are empty - do nothing
    if (pass1 == "" || pass2 == "") {

        return false;
    } else {

        if (pass1 == pass2) {

            pass1element.style.backgroundColor = "#ccffcc";
            pass2element.style.backgroundColor = "#ccffcc";

            e.innerHTML = "";

        } else {

            pass1element.style.backgroundColor = "#ffcccc";
            pass2element.style.backgroundColor = "#ffcccc";

            e.innerHTML = "Lösenorden stämmer inte";
        }
    }
}

// get user info
function showUser(cuserID) {
        
    if (cuserID == "") {
        document.getElementById("txtShowUser").innerHTML = "";
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtShowUser").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","content/getuser.php?q="+cuserID,true);
        xmlhttp.send();
    }

}

// project search input form
function searchProjectForm(str) {            

    var e = document.getElementById("projectResultList");
    e.innerHTML="";

    var xmlhttp=new XMLHttpRequest();        
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            e.innerHTML=this.responseText;             
        }
    }    

    if (str.length==0 || str=="getAll") {                        
        xmlhttp.open("GET","content/searchprojects.php?q=getAll",true);               
    }else{
        xmlhttp.open("GET","content/searchprojects.php?q="+str,true);               
    }    
    xmlhttp.send();                
        
}
    
// sidebar menu click listener
// will open the .PHP file matching the data-target name
// under content folder
$(".list-group>a").click(function (e) {            
    e.preventDefault();   
    e.stopPropagation();     
    var $target = $(this).data('target');           
    var $file = $target + '.php';
    var $path = 'content/';    
            
    $("#page-content").load($path + $file);  
    $("#wrapper").toggleClass("toggled");                
}); 