function createSize() {
    var url = `${__PATH__}/sizes/create`
    getFormModal(url, 'modal-size')
}
function editSize(id) {
    var url = `${__PATH__}/sizes/${id}/edit`
    getFormModal(url, 'modal-size')
}

function updateSizeStatus(id,$dispatch) {
    var url = `${__PATH__}/sizes/${id}/status`;
    sendForm(url,{_method: 'PUT'},'',$dispatch)
}
