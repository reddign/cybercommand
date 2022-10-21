window.addEventListener("load",init);

function init() {
    let selects = document.querySelectorAll("select.fillSelect");
    selects.forEach(elem => elem.addEventListener("change",selectChange));
}

function selectChange() {
    let optionText = this.options[this.selectedIndex].value;
    if(optionText == "")
        return;

    let assocTextElem = document.getElementById(this.id.substr(0,this.id.length-"_select".length));
    if(assocTextElem.tagName == "TEXTAREA") {
        assocTextElem.innerHTML = optionText;
    }
    else if(assocTextElem.tagName == "INPUT") {
        assocTextElem.value = optionText;
    }
    this.selectedIndex = 0;
}