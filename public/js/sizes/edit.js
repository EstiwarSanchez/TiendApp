function updateSize($dispatch, id, modal = false) {
    var url =  `${__PATH__}/sizes/${id}`;
    var formData = new FormData(document.getElementById('updateSize'));
    modal = modal === false ? '' : 'modal-size';
    sendForm(url,formData, modal,$dispatch).then((data)=>{
        if (data.status==1) {
            resetForm('updateSize')
        }
    });
}
