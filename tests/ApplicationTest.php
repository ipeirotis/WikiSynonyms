<?php

require_once 'config/config.php';
require_once PHPU_PATH.'Extensions/Database/TestCase.php';
require_once dirname(dirname(__FILE__)) . '/lib/application.php';

class ApplicationTest extends PHPUnit_Extensions_Database_TestCase
{

  var $App;
  static private $pdo = null;
  private $conn = null;

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

    $ds1 = $this->createMySQLXMLDataSet(dirname(__FILE__) . '/files/fixtures/odesk_skills.xml');
    $ds1 = $this->createMySQLXMLDataSet(dirname(__FILE__) . '/files/fixtures/page.xml');
    $ds2 = $this->createMySQLXMLDataSet(dirname(__FILE__) . '/files/fixtures/page_relation.xml');
    $ds3 = $this->createMySQLXMLDataSet(dirname(__FILE__) . '/files/fixtures/pagelinks.xml');
    $ds4 = $this->createMySQLXMLDataSet(dirname(__FILE__) . '/files/fixtures/categorylinks.xml');

    $compositeDs = new PHPUnit_Extensions_Database_DataSet_CompositeDataSet(
        array($ds1, $ds2, $ds3, $ds4)
    );

    return $compositeDs;
  }

  /**
   *  @expectedCheckDisambiguation1 Check for "Ajax" which is disambiguation page
   */
  function testCheckDisambiguation1()
  {
    $r = $this->App->checkDisambiguation('Ajax');
    $this->assertEquals(1, $r);
  }
  
  /**
   *  @expectedCheckDisambiguation2 Check for "Ajax_(programming)" which is NOT disambiguation page
   */
  function testCheckDisambiguation2()
  {
    $r = $this->App->checkDisambiguation('Ajax_(programming)');

    $this->assertEquals(0, $r);
  }
  
  /**
   *  @expectedCheckDisambiguations Check for "Ajax" and for "Ajax_(programming)" which is and is NOT disambiguation page respectively. Return 1 result.
   */
  function testCheckDisambiguations()
  {
    $r = $this->App->checkDisambiguations(array('Ajax', 'Ajax_(programming)'));

    $this->assertEquals(1, count($r));
  }
  
  /**
   *  @expectedGetDisambiguationLinks For "Ajax" which is disambiguation page with id: 1569, return 54 Page links
   */
  function testGetDisambiguationLinks()
  {
    $r = $this->App->getDisambiguationLinks(1569);

    $this->assertEquals(54, count($r));
  }
  
  /**
   *  @expectedGetAllOdeskSkills 2170 Skills on test DB
   */
  function testGetAllOdeskSkills()
  {
    $r = $this->App->getAllOdeskSkills();
    $this->assertEquals(2170, count($r));
  }
  
  /**
   *  @expectedGetAllOdeskSkillsWithExternalLink 2164 Skills on test DB
   */
  function testGetAllOdeskSkillsWithExternalLink()
  {
    $r = $this->App->getAllOdeskSkillsWithExternalLink();
    $this->assertEquals(2164, count($r));
  }
  
  /**
   *  @expectedGetOdeskSkillsByTerm For Ajax term return 1 odesk skill
   */
  function testGetOdeskSkillsByTerm()
  {
    $r = $this->App->getOdeskSkillsByTerm('Ajax');
    $this->assertEquals(1, count($r));
  }
  
  /**
   *  @expectedGetOdeskSkillsByTerms For Ajax and Java term return 2 odesk skill
   */
  function testGetOdeskSkillsByTerms()
  {
    $r = $this->App->getOdeskSkillsByTerms(array('Ajax', 'Java'));
    $this->assertEquals(2, count($r));
  }
  
  /**
   *  @expectedGetSynonyms_1 For Ajax witch is disambiguation page with 54 results and status 300
   */
  function testGetSynonyms_1()
  {
    $r = $this->App->getSynonyms('Ajax');
    $this->assertEquals(300, $r['http']);
    $this->assertEquals(54, count($r['terms']));
  }
  
  /**
   *  @expectedGetSynonyms_2 For 'Ajax (programming)' witch is NOT disambiguation page and it is a primary page. Sould return status 200 and 14 resutls.
   */
  function testGetSynonyms_2()
  {
    $r = $this->App->getSynonyms('Ajax (programming)');
    $this->assertEquals(200, $r['http']);
    $this->assertEquals(14, count($r['terms']));
  }
  
  /**
   *  @expectedGetSynonyms_3 For 'ajax' which produces a capitalization error!.
   */
  function testGetSynonyms_3()
  {
    $r = $this->App->getSynonyms('ajax');
    $this->assertEquals(300, $r['http']);
    $this->assertEquals('Multiple matches found because of ambiguous capitalization of the query. Please query again with one of the returned terms', $r['message']);
    $this->assertEquals(3, count($r['terms']));
  }

}