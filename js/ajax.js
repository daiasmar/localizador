const removeLocations = document.querySelectorAll('.row-actions .trash a') || null
const editLocations = document.querySelectorAll('.row-actions .edit button') || null

removeLocations.forEach(removeLocation => {
    removeLocation.addEventListener('click', e => {

        e.preventDefault();

        let row = e.target.closest('tr');
        let data = new FormData();
      
        data.append('action', 'remove_location');
        data.append('id', row.dataset.id);
        data.append('nonce', admin_ajax.nonce);

        fetch(admin_ajax.url, {
            method: 'POST',
            body : data,
        })
        .then(response => response.json())
        .then(response => {
            if(response.result == 'ok'){
                return row.remove();
            }
        });
    })
})

editLocations.forEach(editLocation => {
    editLocation.addEventListener('click', e => {

        e.preventDefault();
        let row = e.target.closest('tr');
        let thead = e.target.closest('tbody');
        let data = new FormData();
      
        data.append('action', 'edit_location');
        data.append('id', row.dataset.id);
        data.append('nonce', admin_ajax.nonce);

        fetch(admin_ajax.url, {
            method: 'POST',
            body : data,
        })
        .then(response => response.json())
        .then(response => {
            if(response.result == 'ok'){
                console.log(response.data)
                console.log(response.pages)
                new Edit(response.data, thead, row, response.pages);
            }
        });
    })
})