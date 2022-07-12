function updateProduct($dispatch, id, modal = false) {
    var url =  `${__PATH__}/products/${id}`;
    var formData = new FormData(document.getElementById('updateProduct'));
    modal = modal === false ? '' : 'modal-product';
    sendForm(url,formData, modal,$dispatch).then((data)=>{
        if (data.status==1) {
            resetForm('updateProduct')
        }
    });
}
