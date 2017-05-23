
//便當
function showHide() {
        var ele = document.getElementById("showHideDiv");
        var ele1 = document.getElementById("showHideDiv1");
		var ele2 = document.getElementById("showHideDiv2");
		var ele3 = document.getElementById("showHideDiv3");
		var ele4 = document.getElementById("showHideDiv4");
        ele1.style.display = "none";
		ele2.style.display = "none";
		ele3.style.display = "none";
		ele4.style.display = "none";
		
        if(ele.style.display == "block") {
                ele.style.display = "none";             
          }
        else {
            ele.style.display = "block";            
        }
    }
//炒飯
    function showHide1() {
        var ele = document.getElementById("showHideDiv");
        var ele1 = document.getElementById("showHideDiv1");
		var ele2 = document.getElementById("showHideDiv2");
		var ele3 = document.getElementById("showHideDiv3");
		var ele4 = document.getElementById("showHideDiv4");
        ele.style.display = "none";
		ele2.style.display = "none";
		ele3.style.display = "none";
		ele4.style.display = "none";
        if(ele1.style.display == "block") {
                ele1.style.display = "none";
          }
        else {
            ele1.style.display = "block";
        }
    }
	//麵食
	function showHide2() {
        var ele = document.getElementById("showHideDiv");
        var ele1 = document.getElementById("showHideDiv1");
		var ele2 = document.getElementById("showHideDiv2");
		var ele3 = document.getElementById("showHideDiv3");
		var ele4 = document.getElementById("showHideDiv4");
        ele.style.display = "none";
		ele1.style.display = "none";
		ele3.style.display = "none";
		ele4.style.display = "none";
        if(ele2.style.display == "block"){
			ele2.style.display="none";
			}else{
				ele2.style.display="block";
				}
	}
	//水餃
	 function showHide3() {
        var ele = document.getElementById("showHideDiv");
        var ele1 = document.getElementById("showHideDiv1");
		var ele2 = document.getElementById("showHideDiv2");
		var ele3 = document.getElementById("showHideDiv3");
		var ele4 = document.getElementById("showHideDiv4");
        ele.style.display = "none";
		ele1.style.display = "none";
		ele2.style.display = "none";
		ele4.style.display = "none";
        if(ele3.style.display == "block") {
                ele3.style.display = "none";
          }
        else {
            ele3.style.display = "block";
        }
    }
	//其他
	 function showHide4() {
        var ele = document.getElementById("showHideDiv");
        var ele1 = document.getElementById("showHideDiv1");
		var ele2 = document.getElementById("showHideDiv2");
		var ele3 = document.getElementById("showHideDiv3");
		var ele4 = document.getElementById("showHideDiv4");
        ele.style.display = "none";
		ele1.style.display = "none";
		ele2.style.display = "none";
		ele3.style.display = "none";
        if(ele4.style.display == "block") {
                ele4.style.display = "none";
          }
        else {
            ele4.style.display = "block";
        }
    }