<?php

namespace common\widgets\inquid\signature;

/**
 * This is just an example.
 */
class SignatureWidget extends \yii\base\Widget
{
    public $url;
    public $width;
    public $height;
    public $save_png;
    public $save_jpg;
    public $save_svg;
    public $save_server;
    public $clear;
    public $change_color;
    public $undo;
    public $description;
    private $save_buttons;
    private $action_buttons;

    public function init()
    {
        if ($this->width === null)
            $this->width = '500px';
        if ($this->height === null)
            $this->height = '300px';
        if ($this->save_png == true) {
            $this->save_buttons .= ' <button type="button" class="button save" data-action="save-png">' . \Yii::t('app', 'Save as PNG') . '</button>';
        }
        if ($this->save_jpg == true) {
            $this->save_buttons .= ' <button type="button" class="button save" data-action="save-jpg">' . \Yii::t('app', 'Save as JPG') . '</button>';
        }
        if ($this->save_svg == true) {
            $this->save_buttons .= ' <button type="button" class="button save" data-action="save-svg">' . \Yii::t('app', 'Save as SVG') . '</button>';
        }
        if ($this->save_server == true) {
            $this->save_buttons .= ' <button type="button" class="cursor-pointer py-3 px-3 bg-green-400 rounded-lg !text-white signature-pad-button" data-action="save-server" onclick="saveToServer(\'' . $this->url . '\')">' . \Yii::t('app', 'Save') . '</button>';
        }
        if ($this->clear == true) {
            $this->action_buttons .= ' <button type="button" class="button clear red" data-action="clear">' . \Yii::t('app', 'Delete') . '</button>';
        }
        if ($this->change_color == true) {
            $this->action_buttons .= ' <button type="button" class="button" data-action="change-color">' . \Yii::t('app', 'Change color') . '</button>';
        }
        if ($this->undo == true) {
            $this->action_buttons .= ' <button type="button" class="button yellow" data-action="undo">' . \Yii::t('app', 'Undo') . '</button>';
        }
        SignatureAsset::register($this->view);
    }

    public function run()
    {
        $signature = '
        <style>
        canvas{
            width: ' . $this->width . ';
            height: ' . $this->height . ';
        }
        </style>
         <div id="signature-pad" class="signature-pad">
                ' . \Yii::t("app", "Quyidagi maydonga imzo qo'ying") . '<span style="color: red">*</span>
            <div class="signature-pad--body">
                <canvas></canvas>
            </div>
            <div class="signature-pad--footer">
                <div class="description">' . $this->description . '</div>

                <div class="signature-pad--actions">
                        ' . $this->action_buttons . '
                    ' . $this->save_buttons . '
                </div>
            </div>
        </div>';
        return $signature;
    }
}
