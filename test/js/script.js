
//STARTING OF DYNAMIC RESPONSIVE CSS CHANGING JAVASCRIPT
function responsiveMaker() {
	//get these data according to the display size 
    var DOMS, device_size = [];
	
    //getting width of the device
    var device_width = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
	
	//get all the custom style having DOMS in nodelist
	DOMS = document.querySelectorAll("[-laptop],[-tablet],[-phone],[laptop],[tablet],[phone]");
	//console.log(DOMS);
	
	
	if(device_width >= 1025){
		device_size.push("laptop");
		device_size.push("-tablet");
		device_size.push("-phone");
	}else if(device_width >=768){
		device_size.push("-laptop");
		device_size.push("tablet");
		device_size.push("-phone");
	}else{
		device_size.push("-laptop");
		device_size.push("-tablet");
		device_size.push("phone");
	}
	
	
	//this loop breaks individual element 
    DOMS.forEach(function(DOM) {
		//this loop breaks individual attributes to apply in element
		device_size.forEach(function(attributes){
			//this condition checks if the element even has the attribute at first place?
			if(DOM.hasAttribute(attributes)){
				var datas = DOM.getAttribute(attributes).replace(/  +/g, ' ').split(" ");

				//creating classlist object of the selected element
				var elementClassList = DOM.classList;
				//this loop adds all the classes form the attributes to the element
				datas.forEach(function(data) {
					if(data.charAt(0) === '-')
					{
						data = data.substr(1);
						elementClassList.remove(data);
						
					}else{
						elementClassList.add(data);
					}
				});
			}//end if
		});
    });
}

//to apply css when page loads
window.addEventListener('DOMContentLoaded', responsiveMaker);
window.addEventListener('resize', function() {
    var new_device_width =  Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
    "use strict"; 
	if( typeof device_width != 'undefined' ){
		if(device_width > new_device_width){
			window.location.reload();
		}
	} 
});

//ENDING OF DYNAMIC RESPONSIVE CSS CHANGING JAVASCRIPT





//STARTING OF DYNAMIC STYLES OF CSS CHANGING JAVASCRIPT
function applyDynamicHover() {
		//get all the custom style having DOMS in nodelist
	DOMS = document.querySelectorAll("[on-hover]");
	
	//this loop breaks individual element 
    DOMS.forEach(function(DOM) {

    	//this loop breaks individual attributes to apply in element
    	DOM.addEventListener('mouseover', function() {
    		var datas = DOM.getAttribute("on-hover").replace(/  +/g, ' ').split(" ");
    		var elementClassList = DOM.classList;

    		datas.forEach(function(data) {
				if(data.charAt(0) === '-'){
					data = data.substr(1);
					elementClassList.remove(data);	
				}else{
					elementClassList.add(data);
				}
			});

		});

    	DOM.addEventListener('mouseout', function() {
    		var datas = DOM.getAttribute("on-hover").replace(/  +/g, ' ').split(" ");
    		var elementClassList = DOM.classList;

    		datas.forEach(function(data) {
				if(data.charAt(0) === '-'){
					data = data.substr(1);
					elementClassList.add(data);	
				}else{
					elementClassList.remove(data);
				}
			});

		});

    });
}

//to apply css when page loads
window.addEventListener('DOMContentLoaded', applyDynamicHover);

function applyDynamicClick() {
	//get all the custom style having DOMS in nodelist
	DOMS = document.querySelectorAll("[on-click]");
	
	//this loop breaks individual element 
    DOMS.forEach(function(DOM) {

    	//this loop breaks individual attributes to apply in element
    	DOM.addEventListener('click', function() {
    		var datas = DOM.getAttribute("on-click").replace(/  +/g, ' ').split(" ");
    		var elementClassList = DOM.classList;

    		datas.forEach(function(data) {
				if(data.charAt(0) === '-'){
					data = data.substr(1);
					elementClassList.remove(data);	
				}else{
					elementClassList.add(data);
				}
			});

		});
    });
}
window.addEventListener('DOMContentLoaded', applyDynamicClick);

//ENDING OF DYNAMIC STYLES OF CSS CHANGING JAVASCRIPT



//STARTING OF MODAL JAVASCRIPT
//modal closing function
function closeModal(modal) {
    "use strict";
	const terminators = modal.getElementsByClassName('close');
	for (const terminator of terminators) {
		terminator.addEventListener('click', () => { modal.style.display= "none"; });
	}
}

function showModal(id){
	const modal = document.getElementById(id);
	modal.style.display= "block"; 
	closeModal(modal);
}

function showOnLoadModal(){
	const modals = document.querySelectorAll("[open]");
	for (const modal of modals) {
		modal.style.display= "block"; 
		closeModal(modal);
	}
}

window.addEventListener('DOMContentLoaded', showOnLoadModal);
//ENDING OF MODAL JAVASCRIPT






//STARTING OF DROPDOWN JAVASCRIPT
// Close the dropdown if the user clicks outside of it
window.onclick = function(e) {
	if (!e.target.matches('.dropdown-button')) {
		const dropdowns = document.getElementsByClassName("dropdown-content");
		for (const dropdown of dropdowns) {
			if (dropdown.style.display == "block") {
		    	dropdown.style.display = "none";
		    }
		}
	}
}
function addHoverableLogic(button,content){
	let contentReached = false;
	let buttonReached = false;
	button.addEventListener('mouseenter', () => { 
			const x = content.style;
			x.display = "block";
		}
	);

	content.addEventListener('mouseleave', () => {
			const x = content.style;
			x.display = "none";
		}
	);
}
function addClickableLogic(button,content){
	button.addEventListener('click', () => { 
			const x = content.style;
			if(x.display == "none" || x.display === ""){ //second condition is for 1st click not working
				x.display = "block"
			}else{
				x.display = "none"
			}
		}
	);
}

function findDropdowns(){
	const dropdowns = document.getElementsByClassName("dropdown");
	for (const dropdown of dropdowns) {
		const button = dropdown.getElementsByClassName("dropdown-button");
		const content = dropdown.getElementsByClassName("dropdown-content");

		const buttonClassList = button[0].classList;

		if(buttonClassList.contains("clickable")){
			addClickableLogic(button[0],content[0])
		}

		if(buttonClassList.contains("hoverable")){
			addHoverableLogic(button[0],content[0]);
		}
	}
}

window.addEventListener('DOMContentLoaded', findDropdowns);
//ENDING OF DROPDOWN JAVASCRIPT






//STARTING OF DELETABLE ELEMENTS IN JAVASCRIPT
function applyCloseEvent(DOM) {
    "use strict";
	const terminators = DOM.getElementsByClassName('close');
	for (const terminator of terminators) {
		terminator.addEventListener('click', () => { DOM.parentNode.removeChild(DOM); });
	}
}

function findClosableElements(){
	var DOMS = document.getElementsByClassName('closable');

	for (const DOM of DOMS) {
		applyCloseEvent(DOM);
	}

}
window.addEventListener('DOMContentLoaded', findClosableElements);
//ENDING OF DELETABLE ELEMENTS IN JAVASCRIPT




//STARTING OF SLIDER JAVASCRIPT
function playSlider(){
	if(document.getElementsByClassName("slider").length > 0){
		var slideIndex = 0;
		carousel();

		function carousel() {
			var i;
			var x = document.getElementsByClassName("slide");
			for (i = 0; i < x.length; i++) {
				x[i].style.display = "none"; 
			}
			slideIndex++;
			if (slideIndex > x.length) {slideIndex = 1} 
			x[slideIndex-1].style.display = "inline-block"; 
			setTimeout(carousel, 2500); 
		}
	}
}

window.addEventListener('DOMContentLoaded', playSlider);
//ENDING OF SLIDER JAVASCRIPT





//STARTING OF ACCORDIAN JAVASCRIPT
function findAccordians() {
	var accordians = document.getElementsByClassName('accordian');
	for (const accordian of accordians) {
		var items = accordian.getElementsByClassName('item');
		for(const item of items){
			var title = item.getElementsByClassName('title');
			title[0].addEventListener('click', () => {
				var content = item.getElementsByClassName('content');
			    if (content[0].style.maxHeight){
			      content[0].style.maxHeight = null;
			    } else {
			      content[0].style.maxHeight = content[0].scrollHeight + "px";
			    } 
			});
		}
	}
}
window.addEventListener('DOMContentLoaded', findAccordians);
//ENDING OF ACCORDIAN JAVASCRIPT
