function createProduct() {
    var url = `${__PATH__}/products/create`
    getFormModal(url, 'modal-product')
}
function editProduct(id) {
    var url = `${__PATH__}/products/${id}/edit`
    getFormModal(url, 'modal-product')
}

function deleteProduct(id,$dispatch) {
    var url = `${__PATH__}/products/${id}`;
    sendForm(url,{_method: 'DELETE'},'',$dispatch)
}
