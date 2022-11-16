window.addEventListener('load', exp);

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
