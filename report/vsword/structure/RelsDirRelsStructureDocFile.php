<?php
/**
 * Class RelsDirRelsStructureDocFile
 * @version 1.0.2
 * @author v.raskin
 * @package vsword.structure
*/
class RelsDirRelsStructureDocFile extends StructureDocFile {
	public function __construct() {
		$this->name = '.rels';
	}
	
	public function getContent() {
		return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/extended-properties" Target="docProps/app.xml"/><Relationship Id="rId2" Type="http://schemas.openxmlformats.org/package/2006/relationships/metadata/core-properties" Target="docProps/core.xml"/><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/></Relationships>';
	}
}