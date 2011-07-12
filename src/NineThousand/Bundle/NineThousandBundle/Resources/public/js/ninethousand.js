jQuery(document).ready(function(){
    $('#featurePanel div').click(function (event) {
        var $target = $(event.target);
        if ($target.is('#featurePanel div'))
        {
            window.location.href = $target.find('a').attr('href');
        }
    }); 
});
