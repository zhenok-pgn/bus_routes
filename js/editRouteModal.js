const addPaymentEvent = async (ev) => {
    let butt = ev.target;
    const amount = localStorage.getItem('paymentCount') == 'null' ? butt.dataset.paymentid / 1 : localStorage.getItem('paymentCount') /1;
    const block = document.querySelector('.payment-block');
    const select = document.querySelector('.payment-block select');
    const input = document.querySelector('.payment-block input');

    localStorage.setItem('paymentCount', amount+1);
    block.innerHTML += `
        <select class="data-paymentid-${amount}">
            ${select.innerHTML}
        </select>
        <input class="data-paymentid-${amount}" type="number" name="tentacles" min="0" max="10000"/>
        <input type="button" class="del-payment-btn" data-paymentid="${amount}" value="X">
    `;

    document.querySelectorAll(".del-payment-btn").forEach(el => el.onclick = clickDelPaymentEvent);
}

const clickDelPaymentEvent = (ev) => {
    let butt = ev.target;
    const delId = butt.dataset.paymentid;
    if(document.querySelectorAll('.payment-block select').length == 1)
        return;
    document.querySelectorAll(`.data-paymentid-${delId}`).forEach(el => el.remove());
    butt.remove();
}

const addBusClassEvent = async (ev) => {
    let butt = ev.target;
    const amount = localStorage.getItem('busClassCount') == 'null' ? butt.dataset.busclassid / 1 : localStorage.getItem('busClassCount') /1;
    const block = document.querySelector('.bus-classes-block');
    const select = document.querySelector('.bus-classes-block select');

    localStorage.setItem('busClassCount', amount+1);
    block.innerHTML += `
        <select class="data-busclassid-${amount}">
            ${select.innerHTML}
        </select>
        <input type="button" class="del-busclass-btn" data-busclassid="${amount}" value="X">
    `;

    document.querySelectorAll(".del-busclass-btn").forEach(el => el.onclick = clickDelBusClassEvent);
}

const clickDelBusClassEvent = (ev) => {
    let butt = ev.target;
    const delId = butt.dataset.busclassid;
    if(document.querySelectorAll('.bus-classes-block select').length == 1)
        return;

    document.querySelectorAll(`.data-busclassid-${delId}`).forEach(el => el.remove());
    butt.remove();
}

const routeChangesSaveEvent = async (ev) => {
    const isAdd = ev.target.dataset.isadd;
    const payments = document.querySelectorAll('.payment-block select');
    const inputs = document.querySelectorAll('.payment-block input');
    const busClasses = document.querySelectorAll('.bus-classes-block select');
    const carrier = document.querySelector('.carrier-select');
    const routeNum = document.querySelector('.route-number-modal');
    const routeName = document.querySelector('.route-name-modal');
    const cityCode = getCookie('city-code');
    let params = (new URL(document.location)).searchParams; 
    let routeId = params.get("route-id");
    let query = `routeId=${routeId}&routeNum=${routeNum.value}&routeName=${routeName.value}&carrier=${carrier.value}&cityCode=${cityCode}`;
    busClasses.forEach(element => {
        query+=`&busClasses[]=${element.value}`;
    });
    for(let i = 0, j = 0; i < payments.length; i++, j+=2){
        query+=`&payments[]=${payments[i].value}&prices[]=${inputs[j].value}`;
    }
    let route = isAdd == 0 ? 'phpScripts/updateBusRoute.php' : 'phpScripts/addBusRoute.php';
    let response = await fetch(`${route}?${query}`); 
    let list = await response.json();
    if(!list.content)
        alert('Ошибка выполнения запроса');
    location.reload();
}

const init2 = () => {
    document.querySelector(".save-route-params-btn").onclick = routeChangesSaveEvent;
    document.querySelector(".add-payment-btn").onclick = addPaymentEvent;
    document.querySelector(".add-busclass-btn").onclick = addBusClassEvent;
    document.querySelectorAll(".del-payment-btn").forEach(el => el.onclick = clickDelPaymentEvent);
    document.querySelectorAll(".del-busclass-btn").forEach(el => el.onclick = clickDelPaymentEvent);
    localStorage.setItem('paymentCount', null);
    localStorage.setItem('busClassCount', null);
}

init2();