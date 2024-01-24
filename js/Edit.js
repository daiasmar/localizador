class Edit{
    constructor(data, container, closest, pages){
        this.editDom = null;
        this.buildEdit(data, container, closest, pages);
    }
    buildEdit(data, container, closest, pages){

        closest.style.display = "none";

        this.editDom = document.createElement('tr');
        this.editDom.setAttribute('id', `edit-${data.id}`);
        this.editDom.classList.add('inline-edit-row', 'inline-edit-row-page', 'quick-edit-row', 'quick-edit-row-page', 'inline-edit-page', 'inline-editor');
        this.editDom.dataset.id = data.id;

        let td = document.createElement('td');
        td.classList.add('colspanchange');
        td.setAttribute('colspan', 9);

        let div = document.createElement('div');
        div.classList.add('inline-edit-wrapper');

        let leftFieldset = document.createElement('fieldset');
        leftFieldset.classList.add('inline-edit-col-left');

        let rightFieldset = document.createElement('fieldset');
        rightFieldset.classList.add('inline-edit-col-right');

        let legend = document.createElement('legend');
        legend.classList.add('inline-edit-legend')
        legend.innerHTML = 'Edición';

        let leftColumn = document.createElement('div');
        leftColumn.classList.add('inline-edit-col');

        let rightColumn = document.createElement('div');
        rightColumn.classList.add('inline-edit-col');

        let sedeLabel = document.createElement('label');
        let sedeSpan = document.createElement('span');
        sedeSpan.classList.add('input-text-wrap');

        let sedeTitle =  document.createElement('span');
        sedeTitle.classList.add('title');
        sedeTitle.innerHTML = 'Sede';

        let sedeInput = document.createElement('input');
        sedeInput.setAttribute('type', 'text');
        sedeInput.setAttribute('name', '_localizador_locations[sede]');
        sedeInput.classList.add('title');
        sedeInput.value = data.sede;

        let calleLabel = document.createElement('label');
        let calleSpan = document.createElement('span');
        calleSpan.classList.add('input-text-wrap');

        let calleTitle =  document.createElement('span');
        calleTitle.classList.add('title');
        calleTitle.innerHTML = 'Calle';

        let calleInput = document.createElement('input');
        calleInput.setAttribute('type', 'text');
        calleInput.setAttribute('name', '_localizador_locations[calle]');
        calleInput.classList.add('title');
        calleInput.value = data.calle;

        let cpLabel = document.createElement('label');
        let cpSpan = document.createElement('span');
        cpSpan.classList.add('input-text-wrap');

        let cpTitle =  document.createElement('span');
        cpTitle.classList.add('title');
        cpTitle.innerHTML = 'CP';

        let cpInput = document.createElement('input');
        cpInput.setAttribute('type', 'text');
        cpInput.setAttribute('name', '_localizador_locations[cp]');
        cpInput.classList.add('title');
        cpInput.value = data.cp;

        let localidadLabel = document.createElement('label');
        let localidadSpan = document.createElement('span');
        localidadSpan.classList.add('input-text-wrap');

        let localidadTitle =  document.createElement('span');
        localidadTitle.classList.add('title');
        localidadTitle.innerHTML = 'Localidad';

        let localidadInput = document.createElement('input');
        localidadInput.setAttribute('type', 'text');
        localidadInput.setAttribute('name', '_localizador_locations[localidad]');
        localidadInput.classList.add('title');
        localidadInput.value = data.localidad;

        let ciudadLabel = document.createElement('label');
        let ciudadSpan = document.createElement('span');
        ciudadSpan.classList.add('input-text-wrap');

        let ciudadTitle =  document.createElement('span');
        ciudadTitle.classList.add('title');
        ciudadTitle.innerHTML = 'Ciudad';

        let ciudadInput = document.createElement('input');
        ciudadInput.setAttribute('type', 'text');
        ciudadInput.setAttribute('name', '_localizador_locations[ciudad]');
        ciudadInput.classList.add('title');
        ciudadInput.value = data.ciudad;

        let latitudLabel = document.createElement('label');
        let latitudSpan = document.createElement('span');
        latitudSpan.classList.add('input-text-wrap');

        let latitudTitle =  document.createElement('span');
        latitudTitle.classList.add('title');
        latitudTitle.innerHTML = 'Latitud';

        let latitudInput = document.createElement('input');
        latitudInput.setAttribute('type', 'text');
        latitudInput.setAttribute('name', '_localizador_locations[latitud]');
        latitudInput.classList.add('title');
        latitudInput.value = data.coordenadas[0];

        let longitudLabel = document.createElement('label');
        let longitudSpan = document.createElement('span');
        longitudSpan.classList.add('input-text-wrap');

        let longitudTitle =  document.createElement('span');
        longitudTitle.classList.add('title');
        longitudTitle.innerHTML = 'Longitud';

        let longitudInput = document.createElement('input');
        longitudInput.setAttribute('type', 'text');
        longitudInput.setAttribute('name', '_localizador_locations[longitud]');
        longitudInput.classList.add('title');
        longitudInput.value = data.coordenadas[1];

        let paginaLabel = document.createElement('label');
        let paginaSpan = document.createElement('span');
        paginaSpan.classList.add('input-text-wrap');

        let paginaTitle =  document.createElement('span');
        paginaTitle.classList.add('title');
        paginaTitle.innerHTML = 'Página';

        let paginaSelect =  document.createElement('select');
        paginaSelect.setAttribute('name', '_localizador_locations[URL]');

        let optionSelect =  document.createElement('option');
        optionSelect.setAttribute('name', '_localizador_locations[URL]');
        optionSelect.innerHTML = 'Selecciona la página';
        optionSelect.value = '';

        paginaSelect.appendChild(optionSelect);

        pages.forEach(page => {
            let option = document.createElement('option');
            option.innerHTML = page.post_title;
            paginaSelect.appendChild(option);
            optionSelect.value = page.ID;

            if(page.ID == data.URL){
                option.selected = true;
            }
        });

        let buttonsDiv = document.createElement('div');
        buttonsDiv.classList.add('submit', 'inline-edit-save');

        let buttonUpdate = document.createElement('button');
        buttonUpdate.classList.add('button', 'button-primary', 'save');
        buttonUpdate.innerHTML = 'Actualizar';

        let buttonCancel = document.createElement('button');
        buttonCancel.classList.add('button', 'cancel');
        buttonCancel.innerHTML = 'Cancelar';

        sedeLabel.appendChild(sedeTitle);
        sedeLabel.appendChild(sedeSpan);
        sedeSpan.appendChild(sedeInput);
        leftColumn.appendChild(sedeLabel);

        calleLabel.appendChild(calleTitle);
        calleLabel.appendChild(calleSpan);
        calleSpan.appendChild(calleInput)
        leftColumn.appendChild(calleLabel);

        cpLabel.appendChild(cpTitle);
        cpLabel.appendChild(cpSpan);
        cpSpan.appendChild(cpInput);
        leftColumn.appendChild(cpLabel);

        localidadLabel.appendChild(localidadTitle);
        localidadLabel.appendChild(localidadSpan);
        localidadSpan.appendChild(localidadInput)
        leftColumn.appendChild(localidadLabel);

        ciudadLabel.appendChild(ciudadTitle);
        ciudadLabel.appendChild(ciudadSpan);
        ciudadSpan.appendChild(ciudadInput)
        leftColumn.appendChild(ciudadLabel);

        latitudLabel.appendChild(latitudTitle);
        latitudLabel.appendChild(latitudSpan);
        latitudSpan.appendChild(latitudInput)
        rightColumn.appendChild(latitudLabel);

        longitudLabel.appendChild(longitudTitle);
        longitudLabel.appendChild(longitudSpan);
        longitudSpan.appendChild(longitudInput)
        rightColumn.appendChild(longitudLabel);

        paginaLabel.appendChild(paginaTitle);
        paginaLabel.appendChild(paginaSpan);
        paginaSpan.appendChild(paginaSelect)
        rightColumn.appendChild(paginaLabel);

        buttonsDiv.appendChild(buttonUpdate);
        buttonsDiv.appendChild(buttonCancel);

        leftFieldset.appendChild(legend);
        leftFieldset.appendChild(leftColumn);

        rightFieldset.appendChild(rightColumn);

        div.appendChild(leftFieldset);
        div.appendChild(rightFieldset);
        div.appendChild(buttonsDiv);
        td.appendChild(div);
        this.editDom.appendChild(td);
        container.insertBefore(this.editDom, closest);

        buttonCancel.addEventListener('click', () => {
            this.editDom.remove();
            closest.style.display = "table-row";
        })
    }

}