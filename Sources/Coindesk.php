<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Sources;

/**
 * Description of Coindesk
 *
 * @author anup
 */
use App\Scraper\Contracts\SourceInterface;

class Coindesk implements SourceInterface {

    public function getUrl(): string {
        return 'http://localhost/rekvizitai.vz/301165577.html';
    }

    public function getName(): string {
        return 'Coinbase';
    }

//    public function getWrapperSelector(): string {
//        return 'section.list-body .list-item-wrapper';
//    }
//
//    public function getTitleSelector(): string {
//        return 'a h4.heading';
//    }
//
//    public function getDescSelector(): string {
//        return 'a p.card-text';
//    }
//
//    public function getDateSelector(): string {
//        return 'time.time';
//    }
//
//    public function getLinkSelector(): string {
//        return 'div.text-content a:nth-child(2)';
//    }
//
//    public function getImageSelector(): string {
//        return 'img.list-img';
//    }
}
