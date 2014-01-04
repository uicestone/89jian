(function($){
    $.fn.sticky = function(top,cb){
        var elem = this;
        var win = window;
        if(!elem.length){return false;}
        var placeholder = null;
        var top = $(this).attr("data-sticky-top") || 0;
        var elem_css_position = elem.css("position");
        var elem_css_top = elem.css("top");
        var elem_css_left = elem.css("left");
        var elem_css_float = elem.css("float");
        var elem_margin_top = elem.css("margin-top");
        var elem_top = $(elem).offset().top;

        if(elem_css_position === "static"){
            placeholder = elem.clone().css({
                "margin":elem.css("margin"),
                "padding":elem.css("padding"),
                "float":elem.css("float"),
                "visibility":"hidden"
            }).addClass("sticky-ghost");
        }


        function fix(elem,top){

            elem.css({
                "width":elem.css("width"),
                "top":top,
                "marginTop":0,
                "position":"fixed"
            });
            placeholder && elem.after(placeholder);
        }

        function unfix(elem){
            elem.css({
                "marginTop":elem_margin_top,
                "left":elem_css_left,
                "top":elem_css_top,
                "position":elem_css_position
            });
            placeholder && placeholder.remove();
        }

        var old_status = "unfix";

        function computeSticky(){
            var win_scroll_top = $(win).scrollTop();
            if(elem_top - win_scroll_top < top){

                fix(elem,top);
                if(old_status !== "fix" && cb){
                    cb({
                        status:"fix",
                        elem:elem
                    });
                    old_status = "fix";
                }
            }else{
                unfix(elem);
                if(old_status !== "unfix" && cb){
                    cb({
                        status:"unfix",
                        elem:elem
                    });
                    old_status = "unfix";
                }
            }
        }

        $(win).on("scroll",computeSticky);
        $(computeSticky);
    }
})(jQuery)