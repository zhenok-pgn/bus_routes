const addCarrierEventHandler = async () =>{
    const ogrn = document.querySelector('.ogrn');
    const inn = document.querySelector('.inn');
    const name = document.querySelector('.name');
    const address = document.querySelector('.address');
    const phone = document.querySelector('.phone');
    const email = document.querySelector('.email');
    const website = document.querySelector('.website');

    let response = await fetch(`phpScripts/addCarrier.php?ogrn=${ogrn.value}&inn=${inn.value}&name=${name.value}&address=${address.value}&phone=${phone.value}&email=${email.value}&website=${website.value}`);

    let list = await response.json();
    if(!list.content)
        alert("Ошибка выполнеия запроса");
    else
        window.location.href = 'index.php';
}

const init4 = () =>{
    document.querySelector('.add-carrier').onclick = addCarrierEventHandler;
}

init4()