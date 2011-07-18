jQuery(document).ready(function(){
    $('#featurePanel div').click(function (event) {
        var $target = $(event.target);
        if ($target.is('#featurePanel div'))
        {
            window.location.href = $target.find('a').attr('href');
        }
    }); 
});

// array of images 
var imgs = new Array(4); 
    imgs[0] = "/bundles/ninethousandninethousand/images/blue-hover.png"; 
    imgs[1] = "/bundles/ninethousandninethousand/images/green-hover.png"; 
    imgs[2] = "/bundles/ninethousandninethousand/images/orange-hover.png";
    imgs[3] = "/bundles/ninethousandninethousand/images/button.gif";  
  
// preload the images 
function preload() { 
    var tmp = null; 
    for (var j = 0; j < imgs.length; j++) { 
        tmp = imgs[j]; 
        imgs[j] = new Image(); 
        imgs[j].src = tmp; 
    } 
} 

void(preload()); 
