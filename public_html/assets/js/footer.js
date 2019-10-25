var JsPure = (function (doc) {

    var log = console.log;

    function getById(id) {
        return doc.getElementById(id);
    }

    function initital() {
        log('JsPure initial');
    }

    initital();

    /**
     * public methods
     */
    return {
        confirmAndDelete: function (formId) {
            if (confirm('Xóa bản ghi này?')) {
                getById(formId).submit();
            }
        }
    }

})(document);