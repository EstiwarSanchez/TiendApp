function storeSize($dispatch, modal = false) {
    var url =  `${__PATH__}/sizes`;
    var formData = new FormData(document.getElementById('storeSize'));
    modal = modal === false ? '' : 'modal-size';
    sendForm(url,formData, modal,$dispatch).then((data)=>{
        if (data.status==1) {
            resetForm('storeSize')
        }
    });
}
