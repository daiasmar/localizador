const removeLocations = document.querySelectorAll('.row-actions .trash a') || null

removeLocations.forEach(removeLocation => {
    removeLocation.addEventListener('click', e => {

        e.preventDefault();

        let row = e.target.closest('tr');
        let data = new FormData();
      
        data.append('action', 'remove_location');
        data.append('id', e.target.dataset.id);
        data.append('nonce', admin_ajax.nonce);

        fetch(admin_ajax.url, {
            method: 'POST',
            body : data,
        })
        .then(response => response.json())
        .then(response => {
            console.log(response);
            if(response.result == 'ok'){
                return row.remove();
            }
        });
    })
})