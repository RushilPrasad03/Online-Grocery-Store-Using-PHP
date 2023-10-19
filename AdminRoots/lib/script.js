let adminPfp = document.querySelector('.body .main header .admin-display img');
if(adminPfp != null){
    adminPfp.onclick = () =>{
        document.querySelector('.admin-display').classList.toggle('admin-active');
    }
}
let perc1 = document.querySelector('#oCompValue');
let perc2 = document.querySelector('#oConfValue');
let star1 = document.querySelector('#star1');
let star2 = document.querySelector('#star2');
let star3 = document.querySelector('#star3');
let star4 = document.querySelector('#star4');
let star5 = document.querySelector('#star5');
window.onload = function() {
    if(perc1 != null && perc2 != null){
        var styleElem = document.head.appendChild(document.createElement("style"));
        styleElem.innerHTML = "#oComp::before{width:"+ perc1.innerHTML + "} #oConf::before{width:"+ perc2.innerHTML + "}";
    }
    if(star1 != null){
        var styleElem = document.head.appendChild(document.createElement("style"));
        styleElem.innerHTML = "#starbar1::before{width:"+ star1.innerHTML + "} #starbar2::before{width:"+ star2.innerHTML + "} #starbar3::before{width:"+ star3.innerHTML + "} #starbar4::before{width:"+ star4.innerHTML + "} #starbar5::before{width:"+ star5.innerHTML + "} ";
    }
}

let orderTable = document.querySelector('.order-display table');
function disableScrolling(){
    console.log('disableScrolling');
    setTimeout(function() {
        orderTable.style.overflow = 'hidden';
    }, 2000);
}

function enableScrolling(){
    console.log('enable scrolling');
    orderTable.style.overflow = '';
}

var loadFile = function(event) {
    var output = document.getElementById('output');

    document.querySelector('#form-add-label').style.display = 'none';
    document.querySelector('#form-add-image').src = URL.createObjectURL(event.target.files[0]);
    document.querySelector('#form-add-image').style.display = 'block';

    output.onload = function() {
      URL.revokeObjectURL(output.src)
    }
  };