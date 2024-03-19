/*const eventHandler = async (ev) => {
    const selectedOption = ev.target;
    const directionId = selectedOption.value;

    let params = new URLSearchParams(document.location.search);
    let routeId = params.get("route-id");
    let date = document.getElementById('date-view').valueAsDate.toISOString().slice(0, 19).replace('T', ' ');

    let response = await fetch(`phpScripts/loadRoutesScheduleInfo.php?dirId=${directionId}&date=${date}&routeId=${routeId}`);

    let list = await response.json();
    //console.log(cityList);
    let routeSchedule = document.querySelector(".start-time");
    routeSchedule.innerHTML = renderSelect(list.content);

    //let cityBodyTable = document.querySelector(".table-city-body-js");
    //cityBodyTable.innerHTML = renderCityTable(cityList.content);

    //setCityDelButtonsEvents();
}*/

const turnEditMode = async () => {
    let butt = document.querySelector('.edit-mode-button');
    if(butt.innerHTML == 'Редактировать')
        showEditableElements();
    else
        hideEditableElements();
}

const eventClickDelRouteExecHandler = async (ev) => {
    const selected = ev.target;
    const id = selected.dataset.routeexecid;

    if (!confirm(`Вы действительно желаете удалить расписание выезда маршрута с id = ${id} ? С удалением времени выхода автобуса на рейс также удалятся расписание прибытия на остановочные пункты`))
        return;

    let response = await fetch(`phpScripts/delRouteExec.php?routeExecId=${id}`);

    let jsonAnswer = await response.json();
    if(jsonAnswer.content){
        alert("Удаление успешно завершено");
        document.querySelector(`.route-exec-${id}`).remove();
    }
    else
        alert("Во время удаления произошла ошибка");  
}

const eventClickDelBusStopScheduleHandler = async (ev) => {
    const selected = ev.target;
    const id = selected.dataset.busstopscheduleid;

    if (!confirm(`Вы действительно желаете удалить расписание прибытия на остановку ?`))
        return;

    let response = await fetch(`phpScripts/delBusStopSchedule.php?busStopSchedule=${id}`);

    let jsonAnswer = await response.json();
    if(jsonAnswer.content){
        alert("Удаление успешно завершено");
        document.querySelector(`.bus-stop-schedule-row-${id}`).remove();
    }
    else
        alert("Во время удаления произошла ошибка");  
}

const eventClickHandler = async (ev) => {
    let active = document.querySelector('.route-schedule-time.active');
    if(active != null)
        active.classList.remove('active');

    hideEditableElements()

    const selectedOption = ev.target;
    selectedOption.classList.add('active');
    const routeExecId = selectedOption.dataset.id;

    let response = await fetch(`phpScripts/loadRouteStopsScheduleInfo.php?routeExecId=${routeExecId}`);

    let list = await response.json();
    let routeSchedule = document.querySelector(".bus-stops-time");

    routeSchedule.innerHTML = renderTable(list.content);

    document.querySelectorAll(".del-bus-stop-schedule-btn").forEach(el => el.onclick = eventClickDelBusStopScheduleHandler);
    editButtonOnClick();
    //setCityDelButtonsEvents();
}

const eventHandler = async () => {
    hideEditableElements();
    clearScheduleTable();
    editButtonOnClick();
    let directionId = document.querySelector(".select-direction").value;
    if(isNaN(directionId))
        return;
    let params = new URLSearchParams(document.location.search);
    let routeId = params.get("route-id");
    let date = document.getElementById('date-view').valueAsDate.toISOString().slice(0, 19).replace('T', ' ');
    let selectedDirection = document.querySelector(".select-direction");
    document.cookie = `direction=${selectedDirection.value}`;

    let response = await fetch(`phpScripts/loadRoutesScheduleInfo.php?dirId=${directionId}&date=${date}&routeId=${routeId}`);

    let list = await response.json();
    //console.log(cityList);
    let routeSchedule = document.querySelector(".start-time");
    routeSchedule.innerHTML = renderSelect(list.content);

    //let cityBodyTable = document.querySelector(".table-city-body-js");
    //cityBodyTable.innerHTML = renderCityTable(cityList.content);

    //setCityDelButtonsEvents();
    document.querySelectorAll(".route-schedule-time").forEach(el => el.onclick = eventClickHandler);
    document.querySelectorAll(".del-route-exec-btn").forEach(el => el.onclick = eventClickDelRouteExecHandler);
}

const renderSelect = (list) => {
    let htmlCode = "";
    for (const key in list) {
        let value = list[key];
        htmlCode += `
        <div class="col route-exec-${key}">
            <a class="route-schedule-time p-3" href="#" data-id="${key}">${value.split(' ')[1]}</a>
            ${getRouteExecButtonDelete(key)}
            ${getRouteExecButtonChange(key, value)}
        </div>`;
    }   
    htmlCode += `<div class="col">${routeExecButtonAdd}</div>`;
    return htmlCode;
}

const renderSelectBusStops = (list, selectedBusStopId) => {
    let htmlCode = "";
    list.forEach(element => {
        if(element['busStopId'] == selectedBusStopId)
            htmlCode += `
            <option selected value="${element['busStopId']}">${element['busStopName']}</option>
            `;
        else
            htmlCode += `
            <option value="${element['busStopId']}">${element['busStopName']}</option>
            `;
    });     
    return htmlCode;
}

const renderTable = (list) => {
    let tr = "<table><tr><td>Остановкка</td><td>Время прибытия</td></tr>";
    if(list.length == 0)
        return tr+`</table>${busStopButtonAdd}<button type="button" class="edit-mode-button btn btn-primary col">Редактировать</button>`;
    list.forEach(element => {
        tr += `
            <tr class="bus-stop-schedule-row-${element['busStopScheduleId']}">
                <td><a href="">${element['busStopName']}</a></td>
                <td>${element['arrivingTime'].split(' ')[1]}</td>
                <td class="edit-hidden">
                    ${getBusStopScheduleButtonDelete(element['busStopScheduleId'])}
                    ${getBusStopButtonChange(element['arrivingTime'], element['busStopId'], element['busStopScheduleId'])}
                </td>
            </tr>
        `; 
    });
    tr += `
    </table>
    ${busStopButtonAdd}
    <button type="button" class="edit-mode-button btn btn-primary col">Редактировать</button>
    `;     
    return tr;
}

const busStopsEditEvent = async (ev) => {
    let exampleModal = ev.target;
    const button = event.relatedTarget;

    const title = button.getAttribute('data-bs-title');
    const date = button.getAttribute('data-bs-date');
    const selectedBusStopId = button.getAttribute('data-bs-bus-stop-id');
    const modalTitle = exampleModal.querySelector('.modal-title');
    const modalDate = exampleModal.querySelector('.date-bus-arriving');
    const busStopSelect = exampleModal.querySelector('.select-bus-stop');
    const modalBodyInput = exampleModal.querySelector('.modal-body input');
    document.cookie = `bus-stop-schedule-id=${button.getAttribute('data-bs-bus-stop-exec-id')}`;
    document.cookie = `is-add=${date == null ? 1 : 0}`;

    let response = await fetch(`phpScripts/loadBusStopsByCity.php?city-code=${getCookie('city-code')}`);
    let list = await response.json();

    modalDate.value = date == null ? (new Date()).toISOString().slice(0,16) : convertToDate(date).toISOString().slice(0,16);
    modalTitle.textContent = title;
    busStopSelect.innerHTML = renderSelectBusStops(list.content, selectedBusStopId);
}

const routeStartsEditEvent = async (ev) => {
    let exampleModal = ev.target;
    const button = event.relatedTarget;

    const recipient = button.getAttribute('data-bs-title');
    const time = button.getAttribute('data-bs-time');
    const routeExecId = button.getAttribute('data-bs-route-exec-id');
    const modalTime = exampleModal.querySelector('.time-start-route');
    const modalTitle = exampleModal.querySelector('.modal-title');
    document.cookie = `route-exec-id=${routeExecId}`;
    document.cookie = `is-add=${time == null ? 1 : 0}`;

    modalTime.value = time == null ? (new Date()).toISOString().slice(0,16) : convertToDate(time).toISOString().slice(0,16);
    modalTitle.textContent = recipient;
}

const busStopsSaveEvent = async () => {
    const modalDate = document.querySelector('.date-bus-arriving').value;
    const busStopSelect = document.querySelector('.select-bus-stop').value;
    const busStopScheduleId = getCookie('bus-stop-schedule-id');
    const routeExecId = document.querySelector('.route-schedule-time.active');
    let query = 
        getCookie('is-add') == 0 ? 
        `phpScripts/updateBusStops.php?bus-stop-exec-id=${busStopScheduleId}&bus-stop-id=${busStopSelect}&bus-arriving=${modalDate}` :
        `phpScripts/addBusStop.php?route-exec-id=${routeExecId.dataset.id}&bus-stop-id=${busStopSelect}&bus-arriving=${modalDate}`;
    let response = await fetch(query);
    let list = await response.json();
    checkError(list);    
    /*const table = document.querySelector('table');
    table.innerHTML += `
        <tr class="bus-stop-schedule-row-${busStopScheduleId}">
            <td><a href="">${busStopSelect}</a></td>
            <td>${modalDate.split(' ')[1]}</td>
            <td class="edit-hidden">
                ${getBusStopScheduleButtonDelete(busStopScheduleId)}
                ${getBusStopButtonChange(modalDate, busStopSelect, busStopScheduleId)}
            </td>
        </tr>
    `; */
}

const routeExecSaveEvent = async () => {
    const modalDate = document.querySelector('.time-start-route').value;
    const routeExecId = getCookie('route-exec-id');
    const direction = getCookie('direction');
    let params = (new URL(document.location)).searchParams; 
    let routeId = params.get("route-id");
    let query = 
        getCookie('is-add') == 0 ? 
        `phpScripts/updateRouteExecution.php?route-exec-id=${routeExecId}&bus-arriving=${modalDate}` :
        `phpScripts/addRouteExecution.php?route-id=${routeId}&direction-id=${direction}&time=${modalDate}`;
    let response = await fetch(query); 
    let list = await response.json();
    checkError(list);
}

const routeDeleteEvent = async () => {
    if (!confirm(`Вы действительно желаете удалить информацию о маршруте? Если расписание на этот маршрут уже существует, то удаление будет прервано`))
        return;

    let params = (new URL(document.location)).searchParams; 
    let routeId = params.get("route-id");

    let response = await fetch(`phpScripts/deleteBusRoute.php?route-id=${routeId}`); 
    let list = await response.json();
    if(!list.content)
        alert("Ошибка выполнения запроса");
    else
        window.location.href = 'index.php';
}

const init = () => {
    document.getElementById('date-view').valueAsDate = new Date();
    document.querySelector(".select-direction").onchange = eventHandler;
    document.querySelector(".save-btn").onclick = busStopsSaveEvent;
    document.querySelector(".save-route-btn").onclick = routeExecSaveEvent;
    document.querySelector(".delete-route-btn").onclick = routeDeleteEvent;
    document.getElementById('date-view').addEventListener('change',  eventHandler);
    document.getElementById('modalEditRouteStart').addEventListener('show.bs.modal',routeStartsEditEvent);
    document.getElementById('modalEditBusStop').addEventListener('show.bs.modal',busStopsEditEvent);
        //.forEach(el => el.onchange = eventHandler);    
        //window.onload = eventHandlerCountries;
        //window.addEventListener("load", eventHandlerCountriesXMLHTTP);                
        //window.addEventListener("load", eventHandlerCountries);        
}

init();





//------

//const busStopButtonChange = '<button type="button" class="edit-hidden btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditBusStop" data-bs-title="Изменить прибытие на остановку">Change</button>';
const busStopButtonAdd = '<button type="button" class="edit-hidden btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditBusStop" data-bs-title="Добавить прибытие на остановку">Добавить</button>';
const routeExecButtonAdd = '<button type="button" class="edit-hidden btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditRouteStart" data-bs-title="Добавить время начала рейса">Добавить</button>';
const getBusStopButtonChange = (date, busStopId, busStopScheduleId) => {
    return `<button type="button" class="edit-hidden btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditBusStop" data-bs-bus-stop-exec-id="${busStopScheduleId}" data-bs-bus-stop-id="${busStopId}" data-bs-date="${date}" data-bs-title="Изменить прибытие на остановку">Изменить прибытие на остановку</button>`;
}
const getRouteExecButtonChange = (routeExecId, time) => {
    return `<button type="button" class="edit-hidden btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditRouteStart" data-bs-route-exec-id="${routeExecId}" data-bs-time="${time}" data-bs-title="Изменить время начала рейса">Изменить</button>`;
}

const getRouteExecButtonDelete = (routeExecId) => {
    return `<input type="button" class="edit-hidden del-route-exec-btn" data-routeExecId="${routeExecId}" value="X">`;
}

const getBusStopScheduleButtonDelete = (busStopScheduleId) => {
    return `<input type="button" class="edit-hidden del-bus-stop-schedule-btn" data-busStopScheduleId="${busStopScheduleId}" value="X">`;
}

const hideEditableElements = () => {
    let butt = document.querySelector('.edit-mode-button');
    if(butt == null)
        return;
    butt.innerHTML = 'Редактировать';
    let activehidden = document.querySelectorAll('.edit-hidden.active');
    if(activehidden != null){
        activehidden.forEach(element => {
            element.classList.remove('active');
        });
    }
}

const showEditableElements = () => {
    let butt = document.querySelector('.edit-mode-button');
    if(butt == null)
        return;
    butt.innerHTML = 'Назад';
    let activehidden = document.querySelectorAll('.edit-hidden');
    if(activehidden != null){
        activehidden.forEach(element => {
            element.classList.add('active');
        });
    }
}

const clearScheduleTable = () => {
    let table = document.querySelector('.bus-stops-time');
    table.innerHTML = '<button type="button" class="edit-mode-button btn btn-primary col">Редактировать</button>';
    
}

const editButtonOnClick = () => {
    let butt = document.querySelector('.edit-mode-button');
    if(butt == null)
        return;
    butt.onclick = turnEditMode;
}

const convertToDate = (dateStr) => {
    var t = dateStr.split(/[- :]/);
    return new Date(Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]));
}

const convertToDateTime = (d) => {
    Number.prototype.AddZero= function(b,c){
        var  l= (String(b|| 10).length - String(this).length)+1;
        return l> 0? new Array(l).join(c|| '0')+this : this;
     }//to add zero to less than 10,

       localDateTime= [(d.getMonth()+1).AddZero(),
                d.getDate().AddZero(),
                d.getFullYear()].join('/') +', ' +
               [d.getHours().AddZero(),
                d.getMinutes().AddZero()].join(':');
       var elem=document.getElementById("1234"); 
       return localDateTime;
}

function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
      "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

const checkError = (log) => {
    if(!log.content)
        alert("Ошибка выполнения запроса");
}