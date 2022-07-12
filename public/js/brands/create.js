function storeBrand($dispatch, modal = false) {
    var url =  `${__PATH__}/brands`;
    var formData = new FormData(document.getElementById('storeBrand'));
    modal = modal === false ? '' : 'modal-brand';
    sendForm(url,formData, modal,$dispatch).then((data)=>{
        if (data.status==1) {
            resetForm('storeBrand')
        }
    });
}
