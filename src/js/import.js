let idnum = 1;
let availableRecords = {};

window.addEventListener('load',function() {
    id('addTable').addEventListener("click",addTableOption);
    qsa('.chooseTable').forEach((elem) => {elem.addEventListener('change',tableChange);});
});

// Called when a table select changes and updates the columns of the columnSelect
function tableChange() {
    let tableName = this.selectedOptions[0].value;
    let idnum = this.id.substr("chooseTable".length);
    let colSel = id('chooseColumn'+idnum);
    colSel.innerHTML = '<option></option>';

    if(tableName == '') {
        return;
    }
    tables[tableName].columns.forEach((col) => {
        if(col.fk) {

        }
        else if(!col.pk) {
            colSel.innerHTML += '<option value="'+col.name+'">'+col.dispName+'</option>';
        }
    });
    
}

// Re-checks what records have been configured to be available
function recalculateAvailRecs() {
    availableRecords = {};
    qsa('.tableSelect').forEach((elem) => {
        let idnum = elem.id.substr("tableSelect".length);
        let selectedTable = elem.selectedOptions[0].value;
        if(selectedTable != "") {
            let recordMode = "create";
            //Get selected option from radio button group
            qsa('input[name="recordOption'+idnum+'"]').forEach((elem) => {
                if(elem.checked) {
                    recordMode = elem.value;
                }
            });
            if(recordMode == "create") {
                availableRecords[selectedTable] = null;
            }
            else {
                let constraints = {};
                if(recordMode == "createupdate") {
                    constraints[null] = null;
                }
                //TODO - Put constraints into array
                availableRecords[selectedTable] = constraints;
            }
        }
    });
    console.log(availableRecords);
    id("availableRecords").value = JSON.stringify(availableRecords);
    updateTableAvailability();
}

// Updates what tables the user can select from
function updateTableAvailability() {
    qsa('.chooseTable').forEach((elem) => {
        let selected = "";
        if(elem.selectedOptions[0].value in availableRecords) {
            selected = elem.selectedOptions[0].value;
        }
        elem.innerHTML = '<option></option>';
        for (const [key, value] of Object.entries(availableRecords)) {
            elem.innerHTML += `<option value="${key}">${tableNames[key]}</option>`;
        }
        for(let i=0; i<elem.length; i++) {
            if(elem.options[i].value == selected) {
                elem.selectedIndex = i;
            }
        }
        
        if(selected == "") {
            let idnum = elem.id.substr("chooseTable".length);
            let colSel = id('chooseColumn'+idnum);
            colSel.innerHTML = '<option></option>';
        }
    });
}

//Creates a new row in the 'Database Record Selection' table
function addTableOption() {
    let recordTable = id('recordSelection');
    let tr = document.createElement('tr');
    let td1 = document.createElement('td');

    let tableSelect = document.createElement('select');
    tableSelect.id = "tableSelect"+idnum;
    tableSelect.classList.add('tableSelect');
    tableSelect.appendChild(document.createElement("option"));
    tableSelect.addEventListener('change',tableSelectChange);
    for (const [key, value] of Object.entries(tableNames)) {
        let opt = document.createElement("option");
        opt.value = key;
        opt.innerText = value;
        tableSelect.appendChild(opt);
    }
    td1.innerHTML = 'Table: ';
    td1.appendChild(tableSelect);
    let deleteButton = document.createElement('button');
    deleteButton.innerText = "x";
    deleteButton.style = "color: firebrick; margin-left: 10px;";
    deleteButton.addEventListener('click',deleteTableOption);
    td1.appendChild(deleteButton);

    let td2 = document.createElement('td');
    td2.id = 'recordmode'+idnum;
    td2.innerHTML = '<input type="radio" id="createRadio'+idnum+'" name="recordOption'+idnum+'" value="create"><label for="createRadio'+idnum+'">Create new record</label>';
    td2.innerHTML += '<BR/><input type="radio" id="updateRadio'+idnum+'" name="recordOption'+idnum+'" value="update"><label for="updateRadio'+idnum+'">Update existing record</label>';
    td2.innerHTML += '<BR/><input type="radio" id="createupdateRadio'+idnum+'" name="recordOption'+idnum+'" value="createupdate"><label for="createupdateRadio'+idnum+'">Create or update record</label>';
    td2.classList.add('hidden');

    let td3 = document.createElement('td');
    td3.id = 'constraintslist'+idnum;
    td3.innerHTML = 'Based On:<BR/>';
    let addBtn = document.createElement('button');
    addBtn.innerText = "Add Constraint";
    addBtn.addEventListener("click",addConstraint);
    td3.appendChild(addBtn);
    td3.classList.add('hidden');
    
    tr.appendChild(td1);
    tr.appendChild(td2);
    tr.appendChild(td3);
    id('addTable').parentElement.parentElement.insertAdjacentElement('beforebegin',tr);
    idnum++;
}
//Removes a table option by deleting the <tr> that contains it
function deleteTableOption() {
    this.parentElement.parentElement.remove();
    recalculateAvailRecs();
}

function tableSelectChange(event) {
    let table = this.value;
    let idnum = this.id.substr("tableSelect".length);

    if(table != '') {
        id('createRadio'+idnum).checked = true;
        id('recordmode'+idnum).classList.remove("hidden");
    }
    else {
        //If no table is selected, hide/delete all configuration that was done for that table
        id('recordmode'+idnum).classList.add('hidden');
        let constraints = id('constraintslist'+idnum);
        constraints.classList.add('hidden');
        constraints.childNodes.forEach((elem) => {if(elem.tagName == 'DIV') elem.remove;});
    }
    recalculateAvailRecs();
}
function radioButtonChange(event) {
    //TODO
}
function addConstraint(event) {
    //TODO
    let btn = event.target;
    let div = document.createElement('div');
    div.innerHTML = "TODO";
    btn.insertAdjacentElement('beforebegin',div);
}
function deleteConstraint(event) {
    //TODO
}

// DOM function identities
function id(elemId) {
    return document.getElementById(elemId);
}
function qs(selector) {
    return document.querySelector(selector);
}
function qsa(selector) {
    return document.querySelectorAll(selector);
}