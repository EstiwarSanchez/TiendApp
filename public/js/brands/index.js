function createBrand() {
    var url = `${__PATH__}/brands/create`
    getFormModal(url, 'modal-brand')
}
function editBrand(id) {
    var url = `${__PATH__}/brands/${id}/edit`
    getFormModal(url, 'modal-brand')
}

function deleteBrand(id,$dispatch) {
    var url = `${__PATH__}/brands/${id}`;
    sendForm(url,{_method: 'DELETE'},'',$dispatch)
}
