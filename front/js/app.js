const BACKEND_URL = 'http://pruebatecnicaback.local/article';
getAll();

document.getElementById('buttonCreate').addEventListener('click', () => {
    create({
        id: document.getElementById('id').value,
        name: document.getElementById('name').value,
        price: document.getElementById('price').value,
    });
});

function sendXML(url, method='GET', params = ''){
    if(!url){ return; }

    let xml = new XMLHttpRequest();

    return new Promise((resolve, reject) => {

        params = new URLSearchParams(params);

        xml.addEventListener('loadend', () => {
            
            if(xml.readyState == 1){
                if(method == 'PUT'){
                    xml.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
                } else {
                    xml.setRequestHeader('Content-Type','application/json');
                }
            }

            if(xml.readyState == 4){
                if(xml.status == 200){
                    resolve(JSON.parse(xml.responseText));
                } else {
                    reject(xml.responseText);
                }
            }
        });

        xml.open(method, url);
        xml.send(params);
    });
}

function getAll(){
    let mainList = document.getElementById('mainlist');
    let ulListGroup = document.createElement('ul');
    ulListGroup.classList.add('list-group');
    
    sendXML(BACKEND_URL)
    .then(articles => {
        mainList.innerHTML = '';
        if(articles.length > 0){
            articles.forEach(article => {
                let linkListGroup = document.createElement('ul');
                linkListGroup.classList.add('list-group-item', 'list-group-item-action');
                linkListGroup.innerText = article.name;

                linkListGroup.addEventListener('click', () => {
                    
                    get(article.id);

                    document.getElementById('buttonSave').addEventListener('click', () => {
                        edit(new FormData(document.getElementById('formArticle')));
                    });

                });

                ulListGroup.insertAdjacentElement('beforeend',linkListGroup);
            });

            mainList.insertAdjacentElement('beforeend',ulListGroup);
        }
    }).catch(error => {
        console.error(error);
    });
}

function get(articleId){
    sendXML(BACKEND_URL + '?id=' + articleId, 'GET')
    .then(article => {
        document.getElementById('name').value = article.name;
        document.getElementById('price').value = article.price;
        document.getElementById('price_dolar').value = article.price_dolar;
        document.getElementById('id').value = article.id;
    })
    .catch(error => console.error(error));
}

function edit(params){
    if(!params){ return; }
    sendXML(BACKEND_URL, 'PUT', params)
    .then(response => {
        getAll();
        get(response.data.id);
        showReponse(response.message ?? 'Artículo actualizado');
    }).catch(error => {
        console.log('El artículo no se pudo editar. ' + error);
    });
}

function create(params){
    if(!params){ return; }
    sendXML(BACKEND_URL, 'POST', params)
    .then(response => {
        getAll();
        showReponse(response.message ?? 'Artículo creado');
    }).catch(error => {
        console.log('El artículo no se pudo editar. ' + error);
    });
}

function showReponse(message){
    let alert = document.getElementById('responseAlert');
    alert.removeAttribute('hidden');
    alert.innerHTML = message;
    setTimeout(() => { alert.setAttribute('hidden', 'true'); }, 1000);
}