<?php
use pendalf89\filemanager\Module;
use pendalf89\filemanager\assets\ModalAsset;
use yii\helpers\Url;

ModalAsset::register($this);
/*
use pendalf89\filemanager\widgets\FileInput;
use pendalf89\filemanager\models\Mediafile;


echo FileInput::widget([
    'name' => 'mediafile',
    'buttonTag' => 'button',
    'buttonName' => 'Browse',
    'buttonOptions' => ['class' => 'btn btn-default'],
    'options' => ['class' => 'form-control'],
    // Widget template
    'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
    // Optional, if set, only this image can be selected by user
    'thumb' => 'original',
    // Optional, if set, in container will be inserted selected image
    'imageContainer' => '.img',
    // Default to FileInput::DATA_IDL. This data will be inserted in input field
    'pasteData' => FileInput::DATA_ID,
    // JavaScript function, which will be called before insert file data to input.
    // Argument data contains file data.
    // data example: [alt: "Ведьма с кошкой", description: "123", url: "/uploads/2014/12/vedma-100x100.jpeg", id: "45"]
    'callbackBeforeInsert' => 'function(e, data) {
        console.log( data );
    }',
]);


$mediafile = Mediafile::loadOneByOwner('post', 1, 'thumbnail');

// Ok, we have mediafile object! Let's do something with him:
// return url for small thumbnail, for example: '/uploads/2014/12/flying-cats.jpg'
echo $mediafile->getThumbUrl('small');
// return image tag for thumbnail, for example: '<img src="/uploads/2014/12/flying-cats.jpg" alt="Летающие коты">'
echo $mediafile->getThumbImage('small'); // return url for small thumbnail
*/
?>


<iframe src="/filemanager/file/filemanager" id="post-original_thumbnail-frame" frameborder="0" role="filemanager-frame"></iframe>
