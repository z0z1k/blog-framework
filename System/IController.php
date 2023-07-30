<?php
namespace System;

interface IController{
	public function setEnviroment(array $urlParams) : void;
	public function render() : string;
}