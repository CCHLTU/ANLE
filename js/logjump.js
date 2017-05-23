// JavaScript Document
     $(function() {
       $( "#dialog" ).dialog({
          autoOpen: false,
          show: "blind",
          hide: "explode",
 
          buttons: {
              
              "Cancel": function() {
                    $(this).dialog("close");
              }
          }
       });
 
      $( "#opener" ).click(function() {
          $( "#dialog" ).dialog( "open" );
          return false;
          });
    });
	 function chk_form()
{ 
  if(document.getElementById("username").value=="") 
  { 
    alert("帳號不能為空哦"); 
    return false; 
  } 
  if(document.form1.password.value=="") 
  { 
    alert("密碼不能為空!"); 
    return false; 
  }
	  return true;
	  
} 	 
     $(function() {
       $( "#dialog2" ).dialog({
          autoOpen: false,
          show: "blind",
          hide: "explode",
 
          buttons: {
             
              "Cancel": function() {
                    $(this).dialog("close");
              }
          }
       });
 
      $( "#opener2" ).click(function() {
          $( "#dialog2" ).dialog( "open" );
          return false;
          });
    });
	 function chk_form2()
{ 
  if(document.getElementById("ruser").value=="") 
  { 
    alert("註冊帳號要填哦"); 
    return false; 
  } 
  if(document.form2.rpass.value=="") 
  { 
    alert("註冊密碼不能為空!"); 
    return false; 
  }
  if(document.getElementById("stuid").value=="") 
  { 
    alert("學號不能為空!"); 
    return false; 
  }
	  return true;
	  
} 	 
 