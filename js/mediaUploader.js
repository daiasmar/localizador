document.querySelectorAll('#media-uploader-button').forEach(element => {

    element.addEventListener('click', e => {

        e.preventDefault();
    
        let frame = wp.media({
            title: 'Selecciona o sube medio',
            button: {
                text: 'Seleccionar'
            },
            multiple: false  
        })

        frame.on('select', () => {
            
            let attachment = frame.state().get('selection').first().toJSON();
            e.target.closest('.structure-selection').querySelector('#attachment_id').value = attachment.id;
            e.target.closest('.structure-selection').querySelector('#attachment_preview').setAttribute('src', attachment.url);
        })
    
        frame.open();
    });
})

document.querySelectorAll('#media-delete-icon').forEach(element => {
    
    element.addEventListener('click', e => {

        e.target.closest('.structure-selection').querySelector('#attachment_id').value = 0;
    })
})