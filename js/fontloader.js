var FontLoader = (function(){

    function load(paths){
        var count = paths.length;
        function checkDone(){
            count--;
            if(count == 0){
                $("<link />", {
                    'rel': 'stylesheet',
                    'href': '/css/font.css'
                }).appendTo('head');
                document.cookie = "fontloaded=1";
            }
        }

        for(var i = 0; i < count; i++){            
            $.ajax({
                url: "/fonts/" + paths[i],
                beforeSend: function ( xhr ) {
                  xhr.overrideMimeType("font/opentype");
                },
                success: checkDone
            });   
        }
    }

    return {
        load:load
    }
})();


FontLoader.load(["TpldKhangXiDictTrial.otf","TrajanPro-Bold.otf","TrajanPro-Regular.otf"]);

