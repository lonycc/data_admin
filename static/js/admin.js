function formCheck(el, name) {
    var elems = el.form.elements;
    for (var i = 0; i < elems.length; i++) {
        if (name.test(elems[i].name)) {
            elems[i].checked = el.checked;
            trCheck(elems[i]);
        }
    }
}

function formUncheck(id) {
    var el = document.getElementById(id);
    el.checked = false;
    trCheck(el);
}

function trCheck(el) {
    var tr = parentTag(el, 'tr');
    alterClass(tr, 'checked', el.checked);
    if (el.form && el.form['all'] && el.form['all'].onclick) {
        el.form['all'].onclick();
    }
}

function alterClass(el, className, enable) {
    if (el) {
        el.className = el.className.replace(RegExp('(^|\\s)' + className + '(\\s|$)'), '$2') + (enable ? ' ' + className : '');
    }
}

function parentTag(el, tag) {
    while (el && !isTag(el, tag)) {
        el = el.parentNode;
    }
    return el;
}

function isTag(el, tag) {
    var re = new RegExp('^(' + tag + ')$', 'i');
    return re.test(el.tagName);
}


if (typeof KindEditor !== 'undefined') {
    KindEditor.ready(function(K) {
        $('textarea[data-editor="kindeditor"]').each(function(k, item) {
            var $this = $(item);
            var allowUpload = $this.data('upload');
            var uploadUrl = $this.data('url');
            var width = $this.data('editor-width');
            var height = $this.data('editor-height');
            if ($this.data('editor-mode') == 'simple') {
                K.create(item, {
                    resizeType: 2,
                    allowPreviewEmoticons: true,
                    allowImageUpload: true,
                    width: width,
                    height: height,
                    items: [
                        'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                        'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                        'insertunorderedlist', '|', 'emoticons', 'image', 'link', '|', 'about'
                    ]
                });
            } else {
                K.create(item, {
                    resizeType: 2,
                    allowImageUpload: allowUpload,
                    allowFlashUpload: allowUpload,
                    allowMediaUpload: allowUpload,
                    allowFileUpload: allowUpload,
                    uploadJson: uploadUrl,
                    afterUpload: function(url, data) {
                        //after_editor_upload(data);
                        //alert(data.message);
                    },
                    width: width,
                    height: height,
                    items: [
                        'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
                        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
                        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
                        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
                        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
                        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image',
                        'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
                        'anchor', 'link', 'unlink', '|', 'about'
                    ]
                });
            }
        });
    });
}


function linked_menu_insert(container, target, num) {
    var valid = true;
    linked_menus = $('.' + container);
    var selected = { key: Array(), text: Array() };
    $.each(linked_menus.children('option:selected'), function(index, value) {
        value = $(this);
        if (!value.val()) {
            valid = false;
            return false;
        }
        selected.key.push(value.val());
        selected.text.push(value.text());
    });
    if (!valid) {
        alert('请填写完整!');
        return false;
    }
    list = $('#' + container + '_list');
    if (linked_menu_real_val_num(list) + 1 > num) {
        alert('最多只能选择' + num + '个!');
        return false;
    }
    targetInput = $('#' + target);
    selected.key = selected.key.join('-');
    selected.text = selected.text.join('-');
    if (targetInput.val().indexOf(',' + selected.key + ',') == '-1') {
        list.append('<li><em class="value">' + selected.key + '</em><em>' + selected.text + '</em><span onclick="linked_menu_delete(\'' + container + '\',\'' + target + '\',this)">删除</span></li>');
        targetInput.val(linked_menu_real_val(list));
    } else {
        alert('已经存在了');
    }
}

function linked_menu_delete(container, target, me) {
    $(me).parent().remove();
    list = $('#' + container + '_list');
    target = $('#' + target);
    target.val(linked_menu_real_val(list));
}

function linked_menu_real_val_num(container) {
    return container.children('li').length;
}

function linked_menu_real_val(container) {
    var val = Array();
    $.each(container.find('em.value'), function(index, value) {
        val.push(',' + $(this).text() + ',');
    });
    return val.join('|');
}
