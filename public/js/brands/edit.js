function updateBrand($dispatch, id, modal = false) {
    var url =  `${__PATH__}/brands/${id}`;
    var formData = new FormData(document.getElementById('updateBrand'));
    modal = modal === false ? '' : 'modal-brand';
    sendForm(url,formData, modal,$dispatch).then((data)=>{
        if (data.status==1) {
            resetForm('updateBrand')
        }
    });
}
