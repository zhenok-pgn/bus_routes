const addBusStopEventHandler = async () =>{
    const name = document.querySelector('.name');
    const address = document.querySelector('.address');
    const city = getCookie('city-code');
    if(city === undefined){
        alert("Город не выбран");
        window.location.href = 'index.php';
    } 

    let response = await fetch(`phpScripts/addNewBusStop.php?name=${name.value}&address=${address.value}&city=${city}`);

    let list = await response.json();
    if(!list.content)
        alert("Ошибка выполнеия запроса");
    else
        window.location.href = 'index.php';
}

const init5 = () =>{
    document.querySelector('.add-new-bus-stop').onclick = addBusStopEventHandler;
}

init5()

function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
      "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}