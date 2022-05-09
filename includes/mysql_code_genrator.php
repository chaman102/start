<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH . DS . 'database.php');

class Mysql_code_genrator
{


  public static function showlist($table, $formx)
  {
    global $database;

    $result = $database::getSchemaBuilder()->getColumnListing($table);
    $x = '';
    $t = 0;
    $fieldnames = array();
    if (count($result) > 0) {
      while ($t != count($result)) {
        $fieldnames[] = $result[$t];
        $t++;
      }
    }

    $f = '';
    $i = 0;
    $x1 = 0;
    $xp = '';
    $fo = '';
    $type = '$type';
    $data = '$data';
    $id = '$id';
    $pp = '$pp';
    $sl = '$sl';
    $fo = '$fo';
    $rw = '$rw';
    $_GET = '$_GET';
    $_POST = '$_POST';
    $message = '$message';
    $me = "'.TP_BACK.'";
    $x = implode("','", $fieldnames);

    $x = "'" . $x . "'";
    $db_fields = '';
    $x1 = '';
    $x1 .= "<?php
	use Illuminate\Database\Eloquent\Model;";

    $x1 .= "
	use Intervention\Image\ImageManager;";
    $x1 .= "
	class " . ucfirst($table) . " extends Model {
	";
    $x1 .= "protected $" . 'table="' . $table . '";
	';
    $x1 .= "public $" . "timestamps=false;";

    foreach ($fieldnames as $f) {
      $f;
    }
    if ($f == 'image') {
      self::create_dir($table);
    }
    $x1 .= '
    protected $folder="' . $table . '";';
    $x1 .= '
   
  
    public static function call_cl_fun() {
    return (new ' . ucfirst($table) . '());
    }
	 public static function table() {	
        return with(new static)->getTable();    
  }
  public static function tableclass()
    {
        return static::class;
    }
    ';
    $path = LIB_PATH . "/temp/header.txt";
    $myfile = fopen("$path", "r") or die("Unable to open file!");
    while (!feof($myfile)) {
      $xp .= fgets($myfile);
    }
    fclose($myfile);
    $x1 .= $xp;


    $xp = '';
    $path = LIB_PATH . "/temp/showtable.txt";
    $myfile = fopen("$path", "r") or die("Unable to open file!");
    while (!feof($myfile)) {
      $xp .= fgets($myfile);
    }
    fclose($myfile);
    $x1 .= $xp;
    $x1 .= "public static function form_data() {
	echo $fo=Forms::form_start();
	if(" . '$_GET' . "['action']=='add')
	{
	self::action_data('','add');";

    foreach ($fieldnames as $f) {
      if ($f != 'id'  && $f != 'status'  && $f != 'created' && $f != 'updated') {
        $x1 .= "
    $" . $f . "='';
	";
      }
      if ($f == 'image') {
        $x1 .= "$" . "impath='';";
      }
    }
    $x1 .= "
    }
	else
	{";
    $xpb = '';

    $x1 .= $xpb;
    $x1 .= "
	self::action_data($_GET" . "['id'],'edit');
	";
    $x1 .= "
    $rw=self::findOrFail($_GET" . "['id']);
	  ";

    foreach ($fieldnames as $f) {
      if ($f != 'id'  && $f != 'status'  && $f != 'created_at' && $f != 'updated_at') {
        $x1 .= "
        $" . $f . "=$rw->" . $f . ";";
      }
      if ($f == 'image') {
        $x1 .= "
		$" . "impath=$" . "rw->image_path();";
      }
    }
    $x1 .= "
		}
		";

    $x1 .= "";
    $x1 .= $formx;
    $x1 .= "";
    $x1 .= "
	 echo $fo=Forms::submit();
	 echo $fo=Forms::form_end();
	 }	
      ";

    $x1 .= 'protected static function action_data(' . '$id' . ',$type) {
        ';
    $x1 .= 'if ($type == "edit")
		 ';
    $x1 .= "{
			  ";
    $x1 .= '$data=self::find($id);
		 ';
    $x1 .= "}else{
			 ";
    $x1 .= '$data=self::call_cl_fun();
	   
        ';
    $x1 .= "}";

    $x1 .= "
	  if(" . 'isset($_REQUEST' . "['submit']))
        {
      extract($_POST);
          ";
    $images_found = 0;

    foreach ($fieldnames as $f) {
      if ($f != 'id'  && $f != 'status'  && $f != 'created_at' && $f != 'updated_at') {
        if ($f != 'image') {
          $x1 .=
            '$data->' . $f . "=$" . $f . ";
      ";
        }

        if ($f == 'image') {
          $images_found = 1;
          $fls = 'size';

          $fl = '$_FILES';
          $typ = '$_POST';
          $ty = "tpimg_image";
          $vs = "$" . "id";
          $x1 .= "if(" . $fl . "['" . $f . "']['" . $fls . "']!=0)
		   {
			   ";

          $cx = "data" . "->image_maker(" . $fl . "['" . $f . "'],1,$vs,'" . $f . "')";
          $x1 .=
            '$data->' . $f . "=$" . $cx . ";
      ";
          $x1 .= "
			}";
          $x1 .= "elseif(isset(" . $typ . "['" . $ty . "']))
		   {
			   ";


          $x1 .=
            '$data->' . $f . "=" . $typ . "['" . $ty . "'];
      ";
          $x1 .= "}else{";
          $x1 .=
            '$data->' . $f . "='';
      ";
          $x1 .= "}";
        }
      }
    }

    $x1 .= "
	  if($type=='edit')
{ 
";

    if ($images_found == 1) {
      $f = "empty_image()";

      $pres = "data->image!='' && ";
      $pres = "$" . $pres;

      $mps = "REQUEST" . "['check_image']";
      $mps = "$" . "_" . $mps;
      $rt = "SERVER" . "['DOCUMENT_ROOT'].";
      $rts = "$" . "_" . $rt . "'/'.MYF.$" . "data->image_path()";

      $x1 .= "if(isset(" . $mps . "))
			 {
				 ";
      // unlink($_SERVER['DOCUMENT_ROOT']."/".MYF.$datas->image_path());
      $cxs = "unlink(" . $rts . ")";
      $fs = '';
      $x1 .=  $cxs . ";
	 ";

      $x1 .=

        '$data->' . $f . ";
      ";
      $x1 .= "}";
    }


    if (in_array("updated_at", $fieldnames)) {

      $x1 .= '
	   $data->updated_at=date("Y-m-d H:i:s");
	   ';
    }
    $x1 .= "
  ";
    $x1 .= '$pp=$data->save();';
    $x1 .= "
  ";
    $x1 .= "$message='" . '<div align="center">' .
      '<h4 class="alert alert-success">Success! Record Updated Successfully</h4>' .
      '<span><img src="' . $me . 'assets/loaders/c_loader_re.gif" title="c_loader_re.gif"></span>
' . "
</div>';";
    $x1 .= "
  echo output_message($message);
redirect_by_js($id,100);
}else
{
";

    if (in_array("status", $fieldnames)) {
      $x1 .= '
	 $data->status="Active";
  ';
    }
    if (in_array("created_at", $fieldnames)) {
      $x1 .= '
	   $data->created_at=date("Y-m-d H:i:s");
	   ';
      $x1 .= '
	   $data->updated_at=date("Y-m-d H:i:s");
	   ';
    }
    $x1 .= '$pp=$data->save();
';
    $x1 .= "$message='" . '<div align="center">' .
      '<h4 class="alert alert-success">Success! New Record Added Successfully</h4>' .
      '<span><img src="' . $me . 'assets/loaders/c_loader_re.gif" title="c_loader_re.gif"></span>
' . "
</div>';";
    $x1 .= "
echo output_message($message);
redirect_by_js('add',1000);
	}
	  }";

    $x1 .= "
}
}";
    return $x1;
  }


  public static function cc($table, $formx)
  {
    $xp = '';
    $path = LIB_PATH . "/temp/ajax_sample.txt";
    $myfile = fopen("$path", "r") or die("Unable to open file!");
    while (!feof($myfile)) {
      $xp .= fgets($myfile);
    }
    fclose($myfile);
    $path = SITE_ROOT . DS . "public" . DS . "resources" . DS . "ajax_" . $table . ".php";

    if (file_exists($path)) {
      echo "<br><strong>The file Path :</strong> <span style='color:red'>" . $path . "</span> <strong>already exists</strong><br>";
    } else {
      $myfile = fopen("$path", "w") or die("Unable to open file!");
      fwrite($myfile, $xp);
      echo "<br><strong>" . ucfirst($table) . ".php</strong> is created";
      fclose($myfile);
    }
    //Genrate Class
    $text = Mysql_code_genrator::showlist($table, $formx);
    $path = LIB_PATH . "/" . $table . ".php";
    if (file_exists($path)) {
      echo "<br><strong>The file Path :</strong> <span style='color:red'>" . $path . "</span> <strong>already exists</strong><br>";
    } else {
      $myfile = fopen("$path", "w") or die("Unable to open file!");
      fwrite($myfile, $text);
      echo "<br><strong>" . ucfirst($table) . ".php</strong> is created";
      fclose($myfile);
    }
  }


  public static function showfields($table)
  {
    global $database;
    $x1 = '';
    $result = $database->query("SHOW COLUMNS FROM " . $table);
    $x = '';
    $fieldnames = array();
    if ($database->num_rows($result) > 0) {
      while ($row = $database->fetch_assoc($result)) {
        $fieldnames[] = $row['Field'];
      }
    }
    $i = 0;
    $z = sizeof($fieldnames);
    return $x1;
  }
  public static function blueprint($table, $path, $value)
  {
    if (file_exists($path)) {
      $myfile = fopen($path . "" . $table . ".txt", "w") or die("Unable to open file!");

      $txt = $value;
      fwrite($myfile, $txt);
      fclose($myfile);
    } else {
      echo "<br><strong>The Blueprint File of " . $table . " :</strong> <span style='color:red'>" . $path . "</span> <strong>already exists</strong><br>";
    }
  }
  public static function createmodel($table, $path)
  {
    if (file_exists($path)) {
      $x1 = "<?php
	require_once(LIB_PATH.DS.'database.php');";
      $x1 .= "
	use Intervention\Image\ImageManager;";
      $x1 .= "
	class " . ucfirst($table) . "_mo extends " . ucfirst($table) . " {
	}";
      $myfile = fopen($path . "" . $table . "_mo.php", "w") or die("Unable to open file!");
      $txt = $x1;
      fwrite($myfile, $txt);
      fclose($myfile);
    } else {
      echo "<br><strong>The Model File of " . $table . " :</strong> <span style='color:red'>" . $path . "</span> <strong>already exists</strong><br>";
      echo "<br>";
    }
  }
  public static function clearall($table)
  {
    global $database;
    $n = 0;
    $class_name = "includes" . DS . $table . ".php";
    $class_model = "includes" . DS . "model" . DS . $table . "_mo.php";
    $blueprint = "includes" . DS . "blueprint" . DS . $table . ".txt";
    $ajax_file = "public" . DS . "resources" . DS . "ajax_" . $table . ".php";
    if (file_exists($class_name)) {
      echo "Class File Found" . "<br>";
      unlink($class_name) ? true : false;
      $n++;
    }
    if (file_exists($ajax_file)) {
      echo "Class Ajax File Found" . "<br>";
      unlink($ajax_file) ? true : false;
      $n++;
    }
    if (file_exists($blueprint)) {
      echo "Class Blueprint File Found" . "<br>";
      unlink($blueprint) ? true : false;
      $n++;
    }
    if (file_exists($class_model)) {
      echo "Class Model File Found" . "<br>";
      unlink($class_model) ? true : false;
      $n++;
    }
    $val = $database->query('select 1 from `' . $table . '` LIMIT 1');
    if ($val !== FALSE) {
      echo 'DO SOMETHING! IT EXISTS!<br>';
      $val = $database->query('Drop TABLE `' . $table . '`');
      if ($val) {
        echo  "All good";
      }
    } else {
      echo "Table Not Found";
    }
  }
  public static function vc($l)
  {
    $x = "varchar(" . $l . ")NOT NULL";
    return $x;
  }
  public static function int()
  {
    $x = "int(11)NOT NULL";
    return $x;
  }
  public static function ints($l)
  {
    $x = "int(" . $l . ")NOT NULL";
    return $x;
  }
  public static function text()
  {
    $x = "text NOT NULL";
    return $x;
  }
  public static function mtext()
  {
    $x = "mediumtext NOT NULL";
    return $x;
  }
  public static function date()
  {
    $x = "date DEFAULT '0000-00-00'";
    return $x;
  }
  public static function datetime()
  {
    $x = "DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP";
    return $x;
  }
  public static function create_dir($dirname = '')
  {

    mkdir(SITE_ROOT . DS . "public" . DS . "editor" . DS . "files" . DS . "Uploads" . DS . $dirname);
  }
  public static function enum($values)
  {
    $out = self::converts($values);
    $x = "enum(" . $out . ") NOT NULL";
    return $x;
  }
  public function converts($values)
  {
    //print_r($values);
    $i = 0;
    $count = sizeof($values);
    $x = '';
    while ($i != $count) {
      $x .= "'" . $values[$i] . "'";
      if ($i != $count - 1) {
        $x .= ",";
      }

      $i++;
    }
    return $x;
  }
  public static function input($n)
  {
    $x = '$fo=Forms::input2("' . ucfirst($n) . '","' . $n . '",$' . $n . ');';
    return $x;
  }
  public static function textarea($n)
  {
    $x = '$fo=Forms::textarea("' . ucfirst($n) . '","' . $n . '",$' . $n . ',"");';
    return $x;
  }
}
