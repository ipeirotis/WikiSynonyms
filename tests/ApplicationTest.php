<?php

require_once '/Applications/MAMP/bin/php5/lib/php/PHPUnit/Extensions/Database/TestCase.php';
require_once 'config/config.php';
require_once dirname(dirname(__FILE__)) . '/library/application.php';

class ApplicationTest extends PHPUnit_Extensions_Database_TestCase
{

  var $App;
  static $conn = null;
  static $pdo = null;

  function setUp()
  {
    parent::setUp();
    $this->App = new Application();
  }

  final public function getConnection()
  {
    if ($this->conn === null) {
      if (self::$pdo == null) {
        self::$pdo = new PDO(DB_DSN, DB_USER, DB_PASS);
      }
      $this->conn = $this->createDefaultDBConnection(self::$pdo, DB_CATALOG);
    }

    return $this->conn;
  }

  public function getDataSet()
  {

    $ds1 = $this->createMySQLXMLDataSet(dirname(__FILE__) . '/files/fixtures/page.xml');
    $ds2 = $this->createMySQLXMLDataSet(dirname(__FILE__) . '/files/fixtures/page_relation.xml');
    $ds3 = $this->createMySQLXMLDataSet(dirname(__FILE__) . '/files/fixtures/pagelinks.xml');
    $ds4 = $this->createMySQLXMLDataSet(dirname(__FILE__) . '/files/fixtures/categorylinks.xml');

    $compositeDs = new PHPUnit_Extensions_Database_DataSet_CompositeDataSet(
        array($ds1, $ds2, $ds3, $ds4)
    );

    return $compositeDs;
  }

  function testCheckDisambiguation1()
  {
    $r = $this->App->checkDisambiguation('Ajax');

    $this->assertEquals(1, $r);
  }
  function testCheckDisambiguation2()
  {
    $r = $this->App->checkDisambiguation('Ajax_(programming)');

    $this->assertEquals(0, $r);
  }

}