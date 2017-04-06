(function() {
    $(".dropzone").dropzone({
        url: '/import',
        margin: 20,
        width: '100%',
        params: {
            'action': 'save'
        },
        allowedFileTypes: 'xml',
        success: function(res, index){
            console.log(res, index);
        }
    });
}());
