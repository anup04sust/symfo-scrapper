<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPInterface.php to edit this template
 */
namespace App\Scraper\Companies;

/**
 *
 * @author anup
 */
interface SourceInterface {

    public function getUrl(): string;

    public function getName(): string;
//
//    public function getWrapperSelector(): string;
//
//    public function getTitleSelector(): string;
//
//    public function getDescSelector(): string;
//
//    public function getDateSelector(): string;
//
//    public function getLinkSelector(): string;
}
