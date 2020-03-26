//document.getElementsByTagName('body').style.display = 'none';
/*jQuery(window).load(function() {
    jQuery(".is_flatep.single-product").hide();
});*/
/*var x = document.getElementsByTagName("body"), z;
if(x){
    z = '.is_flatep'
}*/

jQuery( function( $ ) {
    var LevelLog=0, is_e= '.is_flatep', o_opts, o_view, o_size;
    // o_opts['gallery_sels']['_view_thumb_pri'] tep-sp-view-title
    o_opts={
        gallery_sels:{
            _header: is_e+' #header',
            _product_title: is_e+' .tep-sp-view-title',
            _content: is_e+'.single-product',
            _view_gals: is_e+'.single-product .product-type-simple .tep-sp-col-gallery .product-images .product-gallery-slider .flickity-viewport .flickity-slider',
            _view_thumbs: is_e+'.single-product .product-type-simple .tep-sp-col-gallery .product-thumbnails .flickity-viewport .flickity-slider',
            _view_gal_active: is_e+'.single-product .product-type-simple .tep-sp-col-gallery',
            _view_img_active: is_e+'.single-product .product-type-simple .tep-sp-col-gallery .product-images .product-gallery-slider',
            _view_thumb_active: is_e+'.single-product .product-type-simple .tep-sp-col-gallery .product-thumbnails',
            _view_inf_active: is_e+'.single-product .product-type-simple .tep-sp-col-info',
            _imgP: is_e+'.single-product .product-type-simple .tep-sp-col-gallery .product-images .woocommerce-product-gallery__image a img.wp-post-image',
            _thumbs: is_e+'.single-product .product-type-simple .tep-sp-col-gallery .product-thumbnails',
            _info: is_e+'.single-product .product-type-simple .tep-sp-col-info .tep-single-product-info',
            _info_title: is_e+'.single-product .product-type-simple .tep-sp-col-info .tep-sp-view-info-row .tep-sp-view-info-title',
            _info_content: is_e+'.single-product .product-type-simple .tep-sp-col-info .tep-sp-view-info-row .tep-sp-view-info-tab'
        },
        gallery_views:['_view_w', '_view_h', '_view_v']
        
    }

    o_size={
        sel: '',
        row_cols: {},
        width: 0,
        max_width: 0,
        height:0,
        max_height: 0,
        base_prop: 0,
        init: function (width, height){
            this.width = width;
            this.height = height;
        },
        init_obj_size: function (obj){
            if(is_content($(obj))){
                this.sel = obj;
                this.width = $(obj).width();
                this.height = $(obj).height();
                this.base_prop = this.get_img_proportion();
                this.scan_row_cols_css();
            }
            else{
                msg(2, "Error : Unable to get size of null object "+$(obj), 'init_obj_size')
            }
            return this;
        },
        is_sel: function (){
            return (not_null(this.sel) && is_content($(this.sel)));
        },
        is_size: function (){
            return (not_null(this.width) && not_null(this.height) && this.height > 0 && this.width > 0);
        },
        set_max_height: function (max){
            if(is_object($(sel))){
                
            }
        },
        get_size: function (){
            if(this.is_sel()){
                this.width = $(obj).width();
                this.height = $(obj).height();
            }
            return this;
        },
        split_str: function (str, sep, c=-1){
            var as, v;
            if(is_string(str), is_string(sep)){
                s = str.split(sep);
                if(is_array(s)){
                    if(c >= 0 && c < s.length){ return s[c]; }
                    else{ return s }
                }
                
            }
        },
        is_row_cols_css: function (rel){
            var r = this.row_cols;
            return(is_object(r) && is_string(rel) && is_content(r[rel]))
        },
        get_row_cols: function (rel){
            return (this.is_row_cols_css(rel)) ? this.row_cols[rel] : null;
        },
        set_row_cols: function (nobj){
            var t;
            if(is_object(nobj)){
                for (const key in nobj) {
                    if (nobj.hasOwnProperty(key) && this.is_row_cols_css(key)) {
                        t = key + '-' + this.row_cols[key]; $(this.sel).removeClass(t);
                        
                        t = key + '-' + nobj[key]; $(this.sel).addClass(t);
                        
                    }
                }
            }
        },
        scan_row_cols_css: function (){
            var t, c, s, ns=0, i=0;
            this.row_cols = {}
            if(this.is_sel()){
                c = $(this.sel).attr('class');
                if(is_string(c)){
                    s = this.split_str(c, ' ');
                    if(is_array(s)){
                        ns = s.length;
                        for (i = 0; i < ns; i++) {
                            if(is_string(s[i])){
                                t = s[i];
                                if(t.indexOf('small-') >= 0){this.row_cols['small'] = this.split_str(t, '-', 1)}
                                if(t.indexOf('medium-') >= 0){this.row_cols['medium'] = this.split_str(t, '-', 1)}
                                if(t.indexOf('large-') >= 0){this.row_cols['large'] = this.split_str(t, '-', 1)}
                            }                            
                        }
                        msg(4, 'Rows detection result : '+print_object(this.row_cols), 'scan_row_cols_css');
                    }
                    else{
                        msg(2, 'Error unable to detect row cols : ', 'scan_row_cols_css');
                    }
                }
            }
        },
        get_img_width: function (max_height){
            var w, h;
            if(max_height > 0 && this.height > max_height){
                ratio = max_height/this.height;
                w = this.width * ratio, h = this.height * ratio;
                if(w > 0 && h > 0){
                    this.width = w , this.height = h;
                    $(this.sel).width(this.width); $(this.sel).parent().width(this.width);
                    $(this.sel).height(this.height); $(this.sel).parent().height(this.height);
                    msg(3, 'Image height is recalculated -> h : '+this.height+' max height : '+max_height, 'get_img_width');
                }
            }
            else{
                msg(3, 'Image height is ok  -> h : '+this.height+' max height : '+max_height, 'get_img_width');
            }
        },
        get_img_proportion: function (width = 0, height = 0){
            width = parseFloat(width), height = parseFloat(height);
            this.base_prop =  0;
            if(width > 0 && height > 0){
                this.base_prop =  width / height;
            }
            else if(this.width > 0 && this.height > 0){
                this.base_prop =  this.width / this.height;
            }
            return this.base_prop;
        }
    }

    o_gallery = {
        status: false,
        selectedIndex: 0,
        view_type: false,
        img_frm: false,
        win_type: false,
        img_max_height: 0,
        gallery: 0,
        imgP: 0,
        thumbs: 0,
        info: 0,
        info_title: 0,
        info_tab: 0,
        init: function (){
            this.status = false;
            msg(2, 'Product gallery initialisation', 'o_gallery::init');
            //-> register gallery selectors
            this.selectedIndex = 0;
            //-> initialyse Gallery home image size
            this.header = Object.create(o_size);
            //-> initialyse Gallery home image size
            this.title = Object.create(o_size);
            //-> initialyse Gallery home image size
            this.gallery = Object.create(o_size);
            //-> initialyse Gallery home image size
            this.imgP = Object.create(o_size);
            //-> initialyse Gallery thumbs size
            this.thumbs = Object.create(o_size);
            this.thumbs.init_obj_size(o_opts['gallery_sels']['_thumbs']);
            //-> initialyse Gallery info size
            this.info = Object.create(o_size);
            this.info.init_obj_size(o_opts['gallery_sels']['_info']);

            this.info_title = Object.create(o_size);
            this.info_title.init_obj_size(o_opts['gallery_sels']['_info_title']);

            this.info_cont = Object.create(o_size);
            this.info_cont.init_obj_size(o_opts['gallery_sels']['_info_content']);
            //-> update view
            this.init_view();
            
        },
        update: function (){
            this.status = false;
            if(is_content($(this.sel))){
                
            }
        },
        is_ready: function (){
            return (this.is_view_type() && this.is_imgP())
        },
        is_imgP: function (){
            return (is_object(this.imgP) && this.imgP.is_size())
        },
        is_thumbs: function (){
            return (is_object(this.thumbs) && this.thumbs.is_size())
        },
        is_info: function (){
            return (is_object(this.info) && this.info.is_size())
        },
        is_view_type: function (){
            return (is_string(this.view_type) && (this.view_type == 'vertical' || this.view_type == 'horizontal' || this.view_type == 'wide'))
        },
        is_win_type: function (){
            return (is_string(this.win_type) && (this.win_type == 'large' || this.win_type == 'medium' || this.win_type == 'small'))
        },
        init_view: function (){
            this.update_view();
            this.evt_pan_gallery();
            
        },
        get_rows: function (){
            var res={};
            if(is_object(this.gallery) && is_object(this.info)){
                res['gal'] = this.gallery.get_row_cols(this.win_type);
                res['inf'] = this.info.get_row_cols(this.win_type);
                msg(4, 'Rows : '+print_object(res), 'get_rows');
            }
            else{
                msg(3, 'Unable to get rows '+print_object(res), 'get_rows');
            }
        },
        update_header: function (){
            if(!is_object(this.header)){this.header = Object.create(o_size);}
            if(!is_object(this.title)){this.title = Object.create(o_size);}
            //-> update image size and view type
            this.header.init_obj_size(o_opts['gallery_sels']['_header']);
            this.title.init_obj_size(o_opts['gallery_sels']['_product_title']);
        },
        update_gallery: function (){
            if(!is_object(this.imgP)){this.imgP = Object.create(o_size);}
            //-> update image size and view type
            this.gallery.init_obj_size(o_opts['gallery_sels']['_view_gal_active']);
        },
        update_info: function (){
            if(!is_object(this.imgP)){this.imgP = Object.create(o_size);}
            //-> update image size and view type
            this.info.init_obj_size(o_opts['gallery_sels']['_view_inf_active']);
        },
        update_imgP: function (){
            if(!is_object(this.imgP)){this.imgP = Object.create(o_size);}
            

            //-> update image size and view type
            this.imgP.init_obj_size(o_opts['gallery_sels']['_view_img_active']);
            //-> Update max img height
            this.get_max_img_height();
            this.get_gal_view_type();
            this.imgP.get_img_width(this.img_max_height);
        },
        update_view: function (){
            var g, i, i_tit, i_cont, csel, r;
            this.get_window_type();
            this.update_imgP();
            this.update_gallery();
            this.update_info();
            if(this.is_ready() && this.is_win_type()){
                
                r = this.get_rows();
                switch (this.view_type) {
                    case 'horizontal':
                        msg(4, 'Horizontal view detected'+print_object(this.gallery.row_cols), 'update_view');
                        g = {'large': 8, 'medium': 8, 'small':12};
                        i = {'large': 4, 'medium': 4, 'small':12};
                        i_tit = {'large': 12, 'medium': 12, 'small':12};
                        i_cont = {'large': 12, 'medium': 12, 'small':12};
                        break;
                    case 'vertical':
                        msg(4, 'Vertical view detected'+print_object(this.gallery.row_cols), 'update_view');
                        g = {'large': 7, 'medium': 7, 'small':12};
                        i = {'large': 5, 'medium': 5, 'small':12};
                        i_tit = {'large': 12, 'medium': 12, 'small':12};
                        i_cont = {'large': 12, 'medium': 12, 'small':12};
                        break;
                    case 'wide':
                        msg(4, 'Wide view detected'+print_object(this.gallery.row_cols), 'update_view');
                        g = {'large': 12, 'medium': 12, 'small':12};
                        i = {'large': 12, 'medium': 12, 'small':12};
                        i_tit = {'large': 4, 'medium': 4, 'small':12};
                        i_cont = {'large': 8, 'medium': 8, 'small':12};
                        break;
                    default:
                        msg(2, 'Unable to detect view type', 'update_view' );
                        break;
                }

                if(is_object(g) && is_object(i)){
                    this.gallery.set_row_cols(g);
                    this.info.set_row_cols(i);
                    this.info_title.set_row_cols(i_tit);
                    this.info_cont.set_row_cols(i_cont);
                    //-> get flickity data from jquery element
                    ft = this.get_flickity_data(o_opts['gallery_sels']['_view_thumb_active']);
                    fa = this.get_flickity_data(o_opts['gallery_sels']['_view_img_active']);
                    if(is_object(fa)){fa.resize(); fa.reposition();}
                    else{ msg(2, 'Unable to resize flickity  : is img : '+is_object(fa), 'update_view');}
                    
                    if(is_object(ft)){ft.resize(); ft.reposition();}
                    else{ msg(3, 'Unable to resize flickity  : is thumb : '+is_object(ft), 'update_view');}
                    
                }
                else{
                    msg(2, 'Unable to update view - bad view type : '+this.view_type, 'update_view');
                }
                
            }
            else{
                msg(4, 'Unable to update view : ready - '+this.is_ready()+' --- win type - '+this.is_win_type(), 'update_view' );
            }
        },
        get_max_img_height: function (){
            var h = $(window).height(), t;
            this.img_max_height = 0;
            this.update_header();
            if(h > 0 && is_object(this.header) && this.header.height > 0 && is_object(this.title) && this.title.height > 0 ){
                t = (is_object($(this.header.sel)) && is_object($(this.header.sel).offset())) ? $(this.header.sel).offset().top: 0;
                this.img_max_height = (this.header.height > 0) ? h - (this.header.height + this.title.height+t)  : h;
                msg(3, 'new max img height : win h - '+h+' --- top - '+t+' --- header - '+this.header.height+' --- title - '+this.title.height+' --- img_max_height - '+this.img_max_height, 'get_max_img_height' );
            }
            else{
                msg(2, 'Unable to calculate max img height : h - '+h+' --- header - '+this.header.height+' --- title - '+this.title.height, 'get_max_img_height' );
            }
        },
        get_window_type: function (){
            var w = $(window).width(), h = $(window).height();
            if(w>0 && h > 0){
                
                if(w >= 850){
                    this.win_type = 'large';
                }
                else if(w >= 550 && w < 850){
                    this.win_type = 'medium';
                }
                else{
                    this.win_type = 'small';
                }
                msg(3, 'Calculating window type : (w: '+w+' - h: '+h+') -> ' + this.win_type + ' - max img height -> ' + this.img_max_height, 'get_window_type' );
            }
            else{
                msg(4, 'Unable to Calculate window type : (w: '+w+' - h: '+h+')' , 'get_window_type' );
            }
        },
        get_gal_view_type: function (){
            if (this.is_imgP()){
                if(this.imgP.base_prop <= 0.85){
                    this.view_type = 'vertical';
                    this.img_frm = 'vertical';
                }
                else if(this.imgP.base_prop > 0.85 && this.imgP.base_prop < 1.3){
                    this.view_type = 'horizontal';
                    this.img_frm = 'cuadrado';
                }
                else if(this.imgP.base_prop >= 1.3 && this.imgP.base_prop <= 2){
                    this.view_type = 'horizontal';
                    this.img_frm = 'horizontal';
                }
                else if(this.imgP.base_prop >= 2){
                    this.view_type = 'wide';
                    this.img_frm = 'horizontal';
                }
                else{

                }
            }
        },
        get_flickity_data: function (obj){
            return (is_string(obj) && is_jq_obj($(obj))) ? $(obj).data('flickity') : false;
        },
        evt_pan_gallery: function (){
            var fa, fp, t = this;
            //-> get flickity data from jquery element
            ft = this.get_flickity_data(o_opts['gallery_sels']['_view_thumb_active']);
            fa = this.get_flickity_data(o_opts['gallery_sels']['_view_img_active']);
            //-> if is objects
            if(is_object(fa) && is_object(ft)){
               msg(4, 'Thumbs carousel at ' + ft.selectedIndex + ' --- active carousel at ' + fa.selectedIndex, 'evt_pan_gallery') 
                    ft.on('change', function( index ) {
                            msg(6, 'Thumbs Slide changed to ' + index, 'evt_pan_gallery' );
                            if( index >= 0 && ft.selectedIndex != fa.selectedIndex) { 
                                fa.select(index);
                            }
                            t.update_view(); 
                            fa.resize(); fa.reposition();
                            ft.resize(); ft.reposition();
                        });
                    fa.on('change', function( index ) {
                            msg(6, 'Pri Slide changed to ' + index, 'evt_pan_gallery' );
                            if( index >= 0 && ft.selectedIndex != fa.selectedIndex) { 
                                ft.select(index);
                            }
                            t.update_view(); 
                            fa.resize(); fa.reposition();
                            ft.resize(); ft.reposition();
                        });
            }
            else { msg(2, 'Error : Unable to locate active or pri carousel... act : ' + fa + ' -- pri : ' + fp, 'evt_pan_gallery') }
        }
    }

    

    function init(){
        o_gallery.init();
        msg(4, o_gallery.status, 'init');
        //set_flickity(is_e+' .vertical-thumbnails .product-thumbnails.thumbnails.slider');
    }

    //-> is data not null
    function print_object(o, lv = 4){
        if(is_object(o)){
            for (const key in o) {
                if (o.hasOwnProperty(key)) {
                    msg(lv, '   - key : '+key+' -> '+o[key], 'print_object');
                }
            }
        }
    }

    //-> is data not null
    function get_attr(o, a){
        if(is_content($(o))){
            return (is_content($(o).attr(a))) ? $(o).attr(a): $(o).prop(a);
        }
    }

    //-> is data not null
    function is_content(d){
        return (d != '' && d != undefined && d != null);
    }

    function not_null(obj){
        return (is_content(obj) && obj != 0)
    }

    //-> is data an array
    function is_array(d){
        return (is_content(d) && Array.isArray(d) && d.length > 0);
    }

    //-> is data an object
    function is_object(d, req=false){
        return (is_content(d) && typeof d === 'object');
    }

    //-> is data an object
    function is_jq_obj(d, len=false){
        return (is_content(d) && typeof d === 'object' && d.length > 0 );
    }

    //-> is data a string
    function is_string(d){
        return (is_content(d) && typeof d === 'string');
    }

    //-> gestion des messages de log
    function msg(level, msg, fnc="NaN")
    {
        if(level<=LevelLog)
        {
            console.log(level+' -- tmpChild::'+fnc+' -- '+msg);
        }
    }

    
    jQuery( document ).on( 'ready', function() {
        "use strict";
        // Woo display cart
        init();
    } );

    jQuery( window ).on( 'resize', function() {
        "use strict";
        // Woo display cart
        //o_gallery.update();
    } );

    jQuery( window ).on( 'load', function() {
        "use strict";
        // Woo display cart _content
        //init();
        //$(o_opts.gallery_sels._content).trigger('change');
    } );
    
});