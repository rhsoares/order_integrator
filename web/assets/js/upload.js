(function() {
    $(".dropzone").dropzone({
        url: '/import',
        margin: 20,
        width: '100%',
        params: {
            'action': 'save'
        },
        addedfile: function(file) {
            alert("Added file.");
        },
        success: function(res, index){
            console.log(res, index);
        }
    });
}());
