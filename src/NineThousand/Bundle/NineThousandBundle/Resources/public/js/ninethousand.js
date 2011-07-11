jQuery(document).ready(function(){
    $('#featurePanel div').click(function() {
        window.location.href = $target.find('a').attr('href');
        return false;
    }); 
});
