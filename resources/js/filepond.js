import * as FilePond from 'filepond';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import es_ES from 'filepond/locale/es-es';

FilePond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginFileValidateType,
    FilePondPluginFileValidateSize
);
if ((document.documentElement.lang || document.getElementsByTagName("html")[0].getAttribute("lang"))=='es') {
    es_ES.labelTapToRetry = "Reintentar →";
    es_ES.labelTapToUndo = "Deshacer →";
    es_ES.labelTapToCancel = "Cancelar →";
    es_ES.labelFileLoadError = "Error al cargar"
    es_ES.labelFileProcessingError = "Error al cargar"
    FilePond.setOptions(es_ES);
}
window.FilePond = FilePond
