<?php
/**
 * Created by PhpStorm.
 * User: Husayn Hasanov
 * Date: 10/31/19
 * Time: 6:56 PM
 */
?>

<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                <a href="{%=file.url%}" class="custom" title="{%=file.name%}" download="{%=file.name%}" data-gallery target="_blank"><img src="{%=file.thumbnailUrl%}"></a>
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" target="_blank" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.displayName%}</a>
                {% } else { %}
                    <span>{%=file.displayName%}</span>
                {% } %}
                <input type="hidden" name="ImageForm[imageField][]" value="{%=file.name%}">
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger"><?= Yii::t('fileupload', 'Error') ?></span> {%=file.error%}</div>
{% } %}
</td>
<td>
    <span class="size">{%=o.formatFileSize(file.size)%}</span>
</td>
<td>
    {% if (file.deleteUrl) { %}
    <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
        <i class="glyphicon glyphicon-trash"></i>
        <span><?= Yii::t('fileupload', 'Delete') ?></span>
    </button>
    <input type="checkbox" name="delete" value="1" class="toggle">
    {% } else { %}
    <button class="btn btn-warning cancel">
        <i class="glyphicon glyphicon-ban-circle"></i>
        <span><?= Yii::t('fileupload', 'Cancel') ?></span>
    </button>
    {% } %}
</td>
</tr>
{% } %}

</script>

