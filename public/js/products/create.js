function storeProduct($dispatch, modal = false) {
    var url =  `${__PATH__}/products`;
    var formData = new FormData(document.getElementById('storeProduct'));
    modal = modal === false ? '' : 'modal-product';
    sendForm(url,formData, modal,$dispatch).then((data)=>{
        if (data.status==1) {
            resetForm('storeProduct')
        }
    });
}
