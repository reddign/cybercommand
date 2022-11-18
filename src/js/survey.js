window.addEventListener('load', exp);
window.addEventListener('load', exp2);

function exp(){
    document.getElementById('submit').classList.add('nodisplay');

    const cb = document.querySelectorAll('.learnExp');
    cb.forEach((elem) => {
        elem.addEventListener('change', onRadioChange);
    });
}

function onRadioChange() {
    const cb = document.querySelectorAll('.learnExp');

    for (let i = 0; i < cb.length; i++){
        if(cb[i].checked && cb[i].value != "None") {
            document.getElementById("hiddenDiv").classList.remove("nodisplay");
            return;
        }
    }
    document.getElementById("hiddenDiv").classList.add("nodisplay");
}

function exp2(){
    document.getElementById('submit').classList.add('nodisplay');

    const cb2 = document.querySelectorAll('.learningExp');
    cb2.forEach((elem) => {
        elem.addEventListener('change', onRadioChange2);
    });
}

function onRadioChange2() {
    const cb2 = document.querySelectorAll('.learningExp');

    for (let i = 0; i < cb2.length; i++){
        if(cb2[i].checked && cb2[i].value != "None") {
            document.getElementById("hiddenDiv2").classList.remove("nodisplay");
            return;
        }
    }
    document.getElementById("hiddenDiv2").classList.add("nodisplay");
}