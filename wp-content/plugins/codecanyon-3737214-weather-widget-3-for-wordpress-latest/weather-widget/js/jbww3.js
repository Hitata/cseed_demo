function WW3() {
    
    var glob = {
        params   : [],
        ajax     : null,
        data     : null,
        instance : null,
        tries    : 3
    };
    
    
    this.init = function(params) {
        glob.params   = params;
        glob.instance = "." + glob.params.unique + " " + ".jb-weather-widget-3 ";
        
        if (glob.params.apikey === "" || typeof glob.params.apikey === "undefined") {
            alert("Weather Widget Error: No API Key provided! Obtain API Key from https://developers.forecast.io");
            return;
        }
        
        glob.skycons = new Skycons({"color": glob.params.icons});
        
        ww3.setColors();
        ww3.bindControls();
        ajax.getData();
    };
    
    var ajax = {
        getData : function() {
            if (glob.ajax) glob.ajax.abort();
            
            var data  = "location="    + glob.params.location;
                data += "&apikey="     + glob.params.apikey;
            
            jQuery.ajax({
                type: "POST",
                url: glob.params.ajaxURL,
                data: data,
                success: function(data){
                    glob.data = data;
                },
                complete: function(){
                    ww3.refresh();
                    glob.ajax = null;
                },
                error: function( jqXHR,textStatus, errorThrown ) {
                    if (glob.tries <= 0) {
                        alert("Weather Widget Error: AJAX error! ("+errorThrown+")");
                    } else {
                        console.log("Weather Widget Error: AJAX error! ("+errorThrown+")");
                        glob.tries--;
                        setTimeout(function(){
                            ajax.getData();
                        },3000);
                    }  
                },
                dataType: "xml"
            });
        }
    };
    
    var ww3 = {
        
        bindControls: function(){
            jQuery(glob.instance).on("mouseenter", function(){
                jQuery(this).find(".ww3_container").stop().animate({
                    marginTop:-200 
                },{
                    queue:false, 
                    duration:750, 
                    easing: "easeOutExpo"
                });
            });
    
            jQuery(glob.instance).on("mouseleave", function(){
                var th = this;
                jQuery(th).find(".ww3_container").stop().animate({
                    marginTop: 0
                },{
                    queue:false, 
                    duration:750, 
                    easing: "easeOutExpo"
                });
            });
            
        },

        refresh: function(){
            if (!glob.data) return;
            
            var error = jQuery(glob.data).find("error").text();
            
            if (error) {
                if (error !== "nodata") {
                    alert(error);
                } 
                ww3.noData();
                return;
            }
            
            var current, forecast = {};
                    
            current = {
                location     : glob.params.locationname,
                date         : helper.translate(jQuery(glob.data).find("current date").text()),
                time         : jQuery(glob.data).find("current time").text(),
                temperature  : {
                    c : jQuery(glob.data).find("current temperature c").text(),
                    f : jQuery(glob.data).find("current temperature f").text()
                },
                icon : jQuery(glob.data).find("current icon").text()
            };

            forecast.day = [];
            jQuery(glob.data).find("day").each(function(i){
                forecast.day[i] = {
                    date         : helper.translate(jQuery(this).find("date").text()),
                    time         : jQuery(this).find("time").text(),
                    temperature  : {
                        max : {
                            c : jQuery(this).find("temperature max c").text(),
                            f : jQuery(this).find("temperature max f").text()
                        },
                        min : {
                            c : jQuery(this).find("temperature min c").text(),
                            f : jQuery(this).find("temperature min f").text()
                        }
                    },
                    icon : jQuery(this).find("icon").text()
                };
            });
            
            jQuery(glob.instance + ".ww3_front_degree p").text(glob.params.units === "C" ? current.temperature.c  + "\u00B0" + "C" : current.temperature.f + "\u00B0" + "F");
            jQuery(glob.instance + ".ww3_location p").text(current.location);
            helper.iconToClass(current.icon, glob.instance + ".ww3_big_icon span");
            
            jQuery(glob.instance + ".ww3_data_day").each(function(i){
                i = i + 1;
                jQuery(this).find(".ww3_data_day_date p").text(forecast.day[i].date);
                jQuery(this).find(".ww3_data_day_degree p").text(glob.params.units === "C" ? forecast.day[i].temperature.min.c + "\u00B0" + "C" + " / " + forecast.day[i].temperature.max.c + "\u00B0" + "C": forecast.day[i].temperature.min.f + "\u00B0" + "F" + " / " + forecast.day[i].temperature.max.f + "\u00B0" + "F" );
                helper.iconToClass(forecast.day[i].icon, jQuery(this).find(".ww3_data_day_icon span"));
            });
            
            if (helper.isCanvasSupported()) {
                glob.skycons.play();
            }
        },
        
        noData: function(){
            jQuery(glob.instance + ".ww3_front_degree p").text("N/A");
            jQuery(glob.instance + ".ww3_location p").text("N/A");
            helper.iconToClass("NA",glob.instance + ".ww3_big_icon span");
            
            jQuery(glob.instance + ".ww3_data_day").each(function(){
                jQuery(this).find(".ww3_data_day_date p").text("N/A");
                jQuery(this).find(".ww3_data_day_degree p").text("N/A");
                helper.iconToClass("NA",glob.instance + ".ww3_data_day_icon span");
            });
        },
        
        setColors: function(){
            jQuery(glob.instance).find(".ww3_front_degree p").css({
               color: glob.params.fronttxt 
            });
            jQuery(glob.instance).find(".ww3_location p").css({
               color: glob.params.fronttxt 
            });
            jQuery(glob.instance).find(".ww3_container").css({
               backgroundColor: glob.params.frontbg 
            });
            
            jQuery(glob.instance).find(".ww3_data_day_date p").css({
               color: glob.params.backtxt 
            });
            jQuery(glob.instance).find(".ww3_data_day_degree p").css({
               color: glob.params.backtxt 
            });
            jQuery(glob.instance).find(".ww3_container_back").css({
               backgroundColor: glob.params.backbg 
            });
            jQuery(glob.instance).find(".ww3_data_header").css({
               backgroundColor: glob.params.backtopbg 
            });
            jQuery(glob.instance).show();
        }
    };

    var helper = {
        
        translate: function(str) {
            str = str.replace("Monday",ww3lang.Monday);
            str = str.replace("Tuesday",ww3lang.Tuesday);
            str = str.replace("Wednesday",ww3lang.Wednesday);
            str = str.replace("Thursday",ww3lang.Thursday);
            str = str.replace("Friday",ww3lang.Friday);
            str = str.replace("Saturday",ww3lang.Saturday);
            str = str.replace("Sunday",ww3lang.Sunday);
            return str;
        },
        
        isCanvasSupported: function() {
            var elem = document.createElement('canvas');
            return !!(elem.getContext && elem.getContext('2d'));
        },
        
        iconToClass: function(icon, element) {
            switch (icon) {
                
                
                case "clear-night" :
                    if (helper.isCanvasSupported()) {
                        var w = jQuery(element).width();
                        var h = jQuery(element).height();
                        jQuery(element).hide();
                        jQuery(element).after("<canvas width=" + w + " height=" + h + "></canvas>");
                        glob.skycons.set(jQuery(element).next().get(0), Skycons.CLEAR_NIGHT);
                    } else {
                        jQuery(element).attr("class", glob.params.icons + "clearnight");
                    }
                    break;
                    
                    
                case "clear-day" :
                    if (helper.isCanvasSupported()) {
                        var w = jQuery(element).width();
                        var h = jQuery(element).height();
                        jQuery(element).hide();
                        jQuery(element).after("<canvas width=" + w + " height=" + h + "></canvas>");
                        glob.skycons.set(jQuery(element).next().get(0), Skycons.CLEAR_DAY);
                    } else {
                        jQuery(element).attr("class", glob.params.icons + "sunny");
                    }
                    break;
                    
                    
                case "rain" :
                    if (helper.isCanvasSupported()) {
                        var w = jQuery(element).width();
                        var h = jQuery(element).height();
                        jQuery(element).hide();
                        jQuery(element).after("<canvas width=" + w + " height=" + h + "></canvas>");
                        glob.skycons.set(jQuery(element).next().get(0), Skycons.RAIN);
                    } else {
                        jQuery(element).attr("class", glob.params.icons + "rainy");
                    }
                    break;
                    
                    
                case "snow" :
                    if (helper.isCanvasSupported()) {
                        var w = jQuery(element).width();
                        var h = jQuery(element).height();
                        jQuery(element).hide();
                        jQuery(element).after("<canvas width=" + w + " height=" + h + "></canvas>");
                        glob.skycons.set(jQuery(element).next().get(0), Skycons.SNOW);
                    } else {
                        jQuery(element).attr("class", glob.params.icons + "snowly");
                    }
                    break;
                    
                    
                case "sleet" :
                    if (helper.isCanvasSupported()) {
                        var w = jQuery(element).width();
                        var h = jQuery(element).height();
                        jQuery(element).hide();
                        jQuery(element).after("<canvas width=" + w + " height=" + h + "></canvas>");
                        glob.skycons.set(jQuery(element).next().get(0), Skycons.SLEET);
                    } else {
                        jQuery(element).attr("class", glob.params.icons + "sleet");
                    }
                    break;
                    
                    
                case "wind" :
                    if (helper.isCanvasSupported()) {
                        var w = jQuery(element).width();
                        var h = jQuery(element).height();
                        jQuery(element).hide();
                        jQuery(element).after("<canvas width=" + w + " height=" + h + "></canvas>");
                        glob.skycons.set(jQuery(element).next().get(0), Skycons.WIND);
                    } else {
                        jQuery(element).attr("class", glob.params.icons + "wind");
                    }
                    break;
                    
                    
                case "fog" :
                    if (helper.isCanvasSupported()) {
                        var w = jQuery(element).width();
                        var h = jQuery(element).height();
                        jQuery(element).hide();
                        jQuery(element).after("<canvas width=" + w + " height=" + h + "></canvas>");
                        glob.skycons.set(jQuery(element).next().get(0), Skycons.FOG);
                    } else {
                        jQuery(element).attr("class", glob.params.icons + "fog");
                    }
                    break;
                    
                    
                    
                case "cloudy" :
                    if (helper.isCanvasSupported()) {
                        var w = jQuery(element).width();
                        var h = jQuery(element).height();
                        jQuery(element).hide();
                        jQuery(element).after("<canvas width=" + w + " height=" + h + "></canvas>");
                        glob.skycons.set(jQuery(element).next().get(0), Skycons.CLOUDY);
                        
                    } else {
                        jQuery(element).attr("class", glob.params.icons + "cloudy");
                    }
                    break;
                    
                case "partly-cloudy-day" :
                    if (helper.isCanvasSupported()) {
                        var w = jQuery(element).width();
                        var h = jQuery(element).height();
                        jQuery(element).hide();
                        jQuery(element).after("<canvas width="+w+" height="+h+"></canvas>");
                        glob.skycons.set(jQuery(element).next().get(0), Skycons.PARTLY_CLOUDY_DAY);
                    } else {
                        jQuery(element).attr("class", glob.params.icons + "partlycloudy");
                    }
                    break;
                    
                    
                case "partly-cloudy-night" :
                    if (helper.isCanvasSupported()) {
                        var w = jQuery(element).width();
                        var h = jQuery(element).height();
                        jQuery(element).hide();
                        jQuery(element).after("<canvas width="+w+" height="+h+"></canvas>");
                        glob.skycons.set(jQuery(element).next().get(0), Skycons.PARTLY_CLOUDY_NIGHT);
                    } else {
                        jQuery(element).attr("class", glob.params.icons + "partlycloudynight");
                    }
                    break;
                    
                    
                case "thunderstorm" :
                    if (helper.isCanvasSupported()) {
                        var w = jQuery(element).width();
                        var h = jQuery(element).height();
                        jQuery(element).hide();
                        jQuery(element).after("<canvas width=" + w + " height=" + h + "></canvas>");
                        glob.skycons.set(jQuery(element).next().get(0), Skycons.RAIN);
                    } else {
                        jQuery(element).attr("class", glob.params.icons + "thunder");
                    }
                    break;
                default:
                    jQuery(element).attr("class", glob.params.icons + "na");
                    break;
            }
        }
    };
}