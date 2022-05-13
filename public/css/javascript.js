let button = document.querySelector('.lieubtn');
let div = document.querySelector('.lieu')
let hidden = true;



div.style.display = 'none';

button.addEventListener('click', () =>{
    if(hidden) { //qd text caché au click
        button.textContent ="-";
        div.style.display ='block';
        hidden =false;
    }
    else {
        button.textContent = "+";
        div.style.display ='none';
        hidden =true;

    }

})


$(document).ready(function(){
    $('#birth-date').mask('00/00/0000');
    $('#phone-number').mask('0000-0000');
})