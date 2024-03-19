/*window.onload = async () => {
    loadSells();
    loadBrands();
    loadThemes();
} 

const loadSells = async () => {
    let response = await fetch('LoadSells.php', {
        method: "GET",
    });

    let sellsList = await response.json();

    let sellsSelect = document.querySelector(".carousel-inner");
    sellsSelect.innerHTML = renderSellSection(sellsList.content);
}

const loadThemes = async () => {
    let response = await fetch('loadThemes.php', {
        method: "GET",
    });
    let list = await response.json();

    let selector = document.querySelector(".themes");
    selector.innerHTML = renderSelect(list.content, "Тема");
}

const loadBrands = async () => {
    let response = await fetch('LoadBrands.php', {
        method: "GET",
    });

    let list = await response.json();

    let selector1 = document.querySelector(".brand-select-1");
    let selector2 = document.querySelector(".brand-select-2");
    let selector3 = document.querySelector(".brands-block-1");
    let selector4 = document.querySelector(".brands-block-2");
    selector1.onchange = loadModels1;
    selector2.onchange = loadModels2;
    selector1.innerHTML = renderSelect(list.content, "Марка");
    selector2.innerHTML = renderSelect(list.content, "Марка");
    selector3.innerHTML = renderBrandsBlock(list.content, "new");
    selector4.innerHTML = renderBrandsBlock(list.content, "used");
}

const loadModels1 = async (ev) => {
    const selectedOption = ev.target;
    const id = selectedOption.value;

    const formData = new FormData();
    formData.append("Id", id);

    let response = await fetch('LoadModelsByBrand.php', {
        method: "POST",
        body: formData,
    });

    let list = await response.json();
    let selector = document.querySelector(".model-select-1");
    selector.innerHTML = renderSelect(list.content, "Модель");
}

const loadModels2 = async (ev) => {
    const selectedOption = ev.target;
    const id = selectedOption.value;

    const formData = new FormData();
    formData.append("Id", id);

    let response = await fetch('LoadModelsByBrand.php', {
        method: "POST",
        body: formData,
    });

    let list = await response.json();

    let selector = document.querySelector(".model-select-2");
    selector.innerHTML = renderSelect(list.content, "Модель");
}

const loadCarBodies = async () => {}


const renderSellSection = (sellsList) => {
    let divs = "";
    for (const key in sellsList) {
        let value = sellsList[key];
        if(divs == "")
        {
            divs += `<div class="carousel-item active h-100"><img src='${value}' id='`+key+`' class='d-block carousel-img'/></div>`
        }
        else
        {
            divs += `<div class="carousel-item h-100"><img src='${value}' id='`+key+`' class='d-block carousel-img'/></div>`
        }
    }    
    
    return divs;
}

const renderSelect = (list, addition) => {
    let htmlCode = `<option selected disabled>${addition}</option>`;
    for (const key in list) {
        let value = list[key];
        htmlCode += `<option value='`+key+`'>${value}</option>`;
    }   
    console.log(list);

    return htmlCode;
}

const renderBrandsBlock = (list, condition) => {
    let htmlCode = "";
    for (const key in list) {
        let value = list[key];
        htmlCode += `<a class="col p-3" href="catalog.php?brand=${key}&condition=${condition}#">${value}</a>`;
    }   
    
    return htmlCode;
}*/