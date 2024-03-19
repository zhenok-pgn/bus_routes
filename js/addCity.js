const addCityEventHandler = async () =>{
    const id = document.querySelector('.id');
    const name = document.querySelector('.name');

    let response = await fetch(`phpScripts/addCity.php?city-code=${id.value}&name=${name.value}`);

    let list = await response.json();
    if(!list.content)
        alert("Ошибка выполнеия запроса");
    else
        window.location.href = 'index.php';
}

const init3 = () =>{
    document.querySelector('.add-city').onclick = addCityEventHandler;
}

init3()