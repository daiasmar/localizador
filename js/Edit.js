function createElements(type, container, value, content, attr, clas){

    let elem = document.createElement(type);

    if(value){
        elem.value = value;
    }
    if(content){
        elem.innerHTML = content;
    }
    if(attr){
        for(let key in attr) {
            elem.setAttribute(key, attr[key]);
        }
    }
    if(clas){
        clas.forEach(val => {
            elem.classList.add(val);
        })
    }
    if(container){
        container.appendChild(elem);
    }
    
    return elem;
}

class Edit{

    constructor(data, container, closest, pages, nonce){
        this.editDom = null;
        this.buildEdit(data, container, closest, pages, nonce);
        this.containerChildren = null;
        this.previousEdit = null;
    }
    
    buildEdit(data, container, closest, pages, nonce){
        this.containerChildren = container.querySelectorAll('tr');

        this.containerChildren.forEach(child => {
            child.style.display = "table-row";
        })

        closest.style.display = "none";

        this.previousEdit = container.querySelector('tr.quick-edit-row');
        
        if(this.previousEdit){
            this.previousEdit.remove();
        }

        this.editDom = createElements('tr', false, false, false, {'id' : `edit-${data.id}`}, ['inline-edit-row', 'inline-edit-row-page', 'quick-edit-row', 'quick-edit-row-page', 'inline-edit-page', 'inline-editor'])

        let td = createElements('td', this.editDom, false, false, {'colspan' : 10}, ['colspanchange']);

        let form = createElements('form', td, false, false, {'method' : 'POST', 'action' : '?page=localizador-menu&tab=setting-locations'});

        let div = createElements('div', form, false, false, false, ['inline-edit-wrapper']);
        createElements('input', form, nonce, false, {'type' : 'hidden', 'id' : '_wpnonce', 'name' : '_wpnonce'});
        createElements('input', form, data.id, false, {'type' : 'hidden', 'id' : 'id', 'name' : 'id'});

        let leftFieldset = createElements('fieldset', div, false, false, false, ['inline-edit-col-left']);
        let rightFieldset = createElements('fieldset', div, false, false, false, ['inline-edit-col-right']);
        let buttonsDiv = createElements('div', div, false, false, false, ['submit','inline-edit-save']);

        createElements('legend', leftFieldset, false, 'Edición', false, ['inline-edit-legend']);
        let leftColumn = createElements('div', leftFieldset, false, false, false, ['inline-edit-col']);
        let rightColumn = createElements('div', rightFieldset, false, false, false, ['inline-edit-col']);

        let sedeLabel = createElements('label', leftColumn);
        createElements('span', sedeLabel, false, 'Sede', false, ['title']);
        let sedeSpan = createElements('span', sedeLabel, false, false, false, ['input-text-wrap']);
        createElements('input', sedeSpan, data.sede, false, {'type' : 'text', 'name' : '_localizador_locations[sede]'});

        let calleLabel = createElements('label', leftColumn);
        createElements('span', calleLabel, false, 'Calle', false, ['title']);
        let calleSpan = createElements('span', calleLabel, false, false, false, ['input-text-wrap']);
        createElements('input', calleSpan, data.calle, false, {'type' : 'text', 'name' : '_localizador_locations[calle]'});

        let cpLabel = createElements('label', leftColumn);
        createElements('span', cpLabel, false, 'CP', false, ['title']);
        let cpSpan = createElements('span', cpLabel, false, false, false, ['input-text-wrap']);
        createElements('input', cpSpan, data.cp, false, {'type' : 'text', 'name' : '_localizador_locations[cp]'});

        let localidadLabel = createElements('label', leftColumn);
        createElements('span', localidadLabel, false, 'Localidad', false, ['title']);
        let localidadSpan = createElements('span', localidadLabel, false, false, false, ['input-text-wrap']);
        createElements('input', localidadSpan, data.localidad, false, {'type' : 'text', 'name' : '_localizador_locations[localidad]'});

        let ciudadLabel = createElements('label', rightColumn);
        createElements('span', ciudadLabel, false, 'Ciudad', false, ['title']);
        let ciudadSpan = createElements('span', ciudadLabel, false, false, false, ['input-text-wrap']);
        createElements('input', ciudadSpan, data.ciudad, false, {'type' : 'text', 'name' : '_localizador_locations[ciudad]'});

        let latitudLabel = createElements('label', rightColumn);
        createElements('span', latitudLabel, false, 'Latitud', false, ['title']);
        let latitudSpan = createElements('span', latitudLabel, false, false, false, ['input-text-wrap']);
        createElements('input', latitudSpan, data.coordenadas[0], false, {'type' : 'text', 'name' : '_localizador_locations[latitud]'});

        let longitudLabel = createElements('label', rightColumn);
        createElements('span', longitudLabel, false, 'Longitud', false, ['title']);
        let longitudSpan = createElements('span', longitudLabel, false, false, false, ['input-text-wrap']);
        createElements('input', longitudSpan, data.coordenadas[1], false, {'type' : 'text', 'name' : '_localizador_locations[longitud]'});

        let paginaLabel = createElements('label', rightColumn);
        createElements('span', paginaLabel, false, 'Página', false, ['title']);
        let paginaSpan = createElements('span', paginaLabel, false, false, false, ['input-text-wrap']);
        let paginaSelect = createElements('select', paginaSpan, false, false, {'name' : '_localizador_locations[URL]'});
        createElements('option', paginaSelect, false, '— Elegir —', {'value' : 0})

        pages.forEach(page => {
            let option = document.createElement('option');
            option.innerHTML = page.post_title;
            paginaSelect.appendChild(option);
            option.value = page.ID;

            if(page.ID == data.URL){
                option.selected = true;
            }
        });

        let promocionLabel = createElements('label', rightColumn);
        let promocionInput = createElements('input', promocionLabel, false, false, {'type' : 'checkbox', 'name' : '_localizador_locations[promocion]'});
        createElements('span', promocionLabel, false, '¿Tiene promoción?', false, ['checkbox-title']);

        if(data.promocion){
            promocionInput.checked = true;
        }

        createElements('input', buttonsDiv, 'Actualizar', false, {'type' : 'submit', 'name' : 'submit'}, ['button', 'button-primary', 'save']);
        let buttonCancel = createElements('button', buttonsDiv, false, 'Cancelar', false, ['button', 'cancel']);


        container.insertBefore(this.editDom, closest);

        buttonCancel.addEventListener('click', () => {
            this.editDom.remove();
            closest.style.display = "table-row";
        })
    }
}