// TinyMCE
require('tinymce');

// theme icons
require('tinymce/icons/default');

// plugins
require('tinymce/plugins/advlist');
require('tinymce/plugins/autolink');
require('tinymce/plugins/link');
require('tinymce/plugins/image');
require('tinymce/plugins/lists');
require('tinymce/plugins/charmap');
// require('tinymce/plugins/print');
require('tinymce/plugins/preview');
require('tinymce/plugins/hr');
require('tinymce/plugins/anchor');
require('tinymce/plugins/pagebreak');
require('tinymce/plugins/spellchecker');
require('tinymce/plugins/searchreplace');
require('tinymce/plugins/wordcount');
require('tinymce/plugins/visualblocks');
require('tinymce/plugins/visualchars');
require('tinymce/plugins/code');
require('tinymce/plugins/fullscreen');
require('tinymce/plugins/insertdatetime');
require('tinymce/plugins/media');
require('tinymce/plugins/nonbreaking');
// require('tinymce/plugins/save');
require('tinymce/plugins/table');
require('tinymce/plugins/contextmenu');
require('tinymce/plugins/directionality');
// require('tinymce/plugins/emoticons');
// require('tinymce/plugins/template');
require('tinymce/plugins/paste');
require('tinymce/plugins/textcolor');

// init
tinymce.init({
    skin: false,
    content_css: document.querySelector('meta[name="assets-path"]').content + 'backend-module/vendor/tinymce/skins/content/default/content.min.css',

    selector: 'textarea.wysiwyg',
    height: 250,
    menubar: 'edit insert format table',
    plugins: [
        "advlist autolink link image lists charmap preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "table contextmenu directionality paste textcolor"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image | forecolor backcolor",
    resize: false,
});
