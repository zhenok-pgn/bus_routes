window.onload = async () => {
    var input = document.querySelector(".form-control");
    input.oninput = loadRoutesWithFilter;
    loadRoutesWithFilter();
} 

const loadRoutesWithFilter = async () => {
    var input = document.querySelector(".form-control");
    var table = document.querySelector(".routes-table");
    var cookie = getCookie("city-code");
    if(cookie === undefined){
        table.innerHTML = "<h1>Город не выбран</h1>";
    }
    let response = await fetch(`phpScripts/LoadRoutes.php?city-code=${cookie}&filter=${input.value}`);

    let list = await response.json();

    let dom = document.querySelector(".routes");
    dom.innerHTML = renderSection(list.content);
}

const renderSection = (list) => {
    let htmlCode = "";
    for (const key in list) {
        let value = list[key];
        htmlCode += `<a class="col p-3" href="route.php?route-id=${key}">${value}</a>`;
    }   
    htmlCode += '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditRoute">Добавить</button>';
    return htmlCode;
}

function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
      "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}