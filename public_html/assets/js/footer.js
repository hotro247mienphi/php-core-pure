console.log('footer.js is loaded');

var JsPure = {
    confirmAndDelete: function (formId) {
        if (confirm('Xóa bản ghi này?')) {
            document.getElementById(formId).submit();
        }
    }
};