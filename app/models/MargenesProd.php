<?php
namespace App\Models;
use Core\Model;
use Core\DB;
use Core\H;
use Core\Validators\RequiredValidator;
use Core\Validators\UniqueValidator;

class MargenesProd extends Model {

    public $Code, $Name, $U_CardCode, $U_Estado=1;
    public $U_MargenBaseBuc,$U_MargenBaseCuc,$U_MargenBaseValle,$U_MargenBaseDui;
    public $U_MargenTatBuc,$U_MargenTatCuc,$U_MargenTatValle,$U_MargenTatDui;

	protected static $_table='[@DPJD_MARGENES_PROD]';
	const blackList = ['Code'];

	public function validator(){
		
		$camposRequeridos=[
			'U_CardCode'=>"Línea/casa",

			'U_MargenBaseBuc'=>"U_MargenBaseBuc",
			'U_MargenBaseCuc'=>"U_MargenBaseCuc",
			'U_MargenBaseValle'=>"U_MargenBaseValle",
			'U_MargenBaseDui'=>"U_MargenBaseDui",

			'U_MargenTatBuc'=>"U_MargenTatBuc",
			'U_MargenTatCuc'=>"U_MargenTatCuc",
			'U_MargenTatValle'=>"U_MargenTatValle",
			'U_MargenTatDui'=>"U_MargenTatDui"
		];
		foreach($camposRequeridos as $campo => $msn){
			$this->runValidation(new RequiredValidator($this,['field'=>$campo,'msg'=>$msn." es requerido."]));
		}
	}

	public static function listarMargenes(){

	  	$sql = "SELECT Code,Name AS Sucursal,U_Cardcode AS Casa,CardName AS NombreCasa,U_MargenBase,U_MargenTat,U_Estado FROM [@DPJD_MARGENES_PROD] AS Margenes
				INNER JOIN OCRD AS Proveedores ON Margenes.U_CardCode=Proveedores.CardCode
				WHERE CardType <> 'C' AND GroupCode='10' ORDER BY Sucursal;";

	  	$db = DB::getInstance('SqlServer');

	  	if($db->query($sql)->count()>0)
	  	{
	  		//H::dnd(json_encode($db->query($sql)->results()));
	  		return json_encode($db->query($sql)->results());
	  	}
	  	else{
	  		return [];
	  	}
	}

	public static function listarMargenes2(){

	  	$sql = "SELECT U_CardCode as Casa,CardName as NombreCasa,U_Estado as Estado,
					cast(SUM(BaseBUC) as numeric(19,4))as BaseBUC, cast(SUM(TatBUC)as numeric(19,4))as TatBUC,
					cast(SUM(BaseCUC) as numeric(19,4)) as BaseCUC,cast(SUM(TatCUC)as numeric(19,4)) as TatCUC,
					cast(SUM(BaseVAL) as numeric(19,4)) as BaseVAL,cast(SUM(TatVAL)as numeric(19,4)) as TatVAL,
					cast(SUM(BaseDUI) as numeric(19,4)) as BaseDUI,cast(SUM(TatDUI)as numeric(19,4)) as TatDUI
				FROM (
					SELECT U_CardCode,CardName,U_estado,'Base'+Name as CasaBase,'Tat'+Name as CasaTat,U_MargenBase,U_MargenTat
					FROM [@DPJD_MARGENES_PROD] as Margenes
					INNER JOIN OCRD as Proveedores on Margenes.U_CardCode=Proveedores.CardCode and CardType<>'C' and GroupCode='10'
				) as s
				pivot(
					max(U_MargenBase) for [CasaBase] in ([BaseBUC],[BaseCUC],[BaseVAL],[BaseDUI])
				) As p1
				pivot(
					max(U_MargenTat) for [CasaTat] in([TatBUC],[TatCUC],[TatVAL],[TatDUI])
				)AS p2
				GROUP BY U_CardCode,CardName,U_Estado;";

	  	$db = DB::getInstance('SqlServer');

	  	if($db->query($sql)->count()>0)
	  	{
	  		//H::dnd(json_encode($db->query($sql)->results()));
	  		return json_encode($db->query($sql)->results());
	  	}
	  	else{
	  		return [];
	  	}
	}	
  	
  	public static function obtenerSucursal($sucursal){
  		switch ($sucursal) {
  			case 'BUC':
  				return 'Bucaramanga';
  				break;
			case 'CUC':
				return 'Cucuta';
				break;
			case 'DUI':
				return 'Duitama';
				break;
			case 'DIS':
				return 'Dismen';
				break;
			case 'VAL':
				return 'Valledupar';
				break;
  			default:
  				return 'NA';
  				break;
  		}
  	}

  	public static function listarCasas(){
  		
  		$sql="SELECT DISTINCT CardCode,CardName FROM OCRD WHERE CardType<>'C' and GroupCode='10' ORDER BY CardName;";
  		$db = DB::getInstance('SqlServer');

  		if($db->query($sql)->count()>0)
  			return json_encode($db->query($sql)->results());
  		else
  			return [];
  	}

  	public static function buscarId($id){
  		$sql="SELECT Name,U_CardCode,U_Estado,cast(U_MargenBase as numeric(19,4))as U_MargenBase,cast(U_MargenTat as numeric(19,4)) as U_MargenTat FROM [@DPJD_MARGENES_PROD] WHERE U_CardCode=?;";
  		$db = DB::getInstance('SqlServer');
	  	if($db->query($sql,[$id])->count()>0)
	  	{
	  		//H::dnd(($db->query($sql,[$id],'App\Models\MargenesProd')->results()));
	  		return ($db->query($sql,[$id],'App\Models\MargenesProd')->results());
	  	}
	  	else{
	  		return [];
	  	}
  	}

  	public static function guardar($name,$card_code,$margen_base,$margen_tat,$estado){
  		$sql="INSERT INTO [dbo].[@DPJD_MARGENES_PROD]([Name],[U_CardCode],[U_MargenBase],[U_MargenTat],[U_Estado])VALUES(?,?,?,?,?);";
  		$db = DB::getInstance('SqlServer');

  		if($db->query($sql,[$name,$card_code,$margen_base,$margen_tat,$estado])->count()>0)
  			return true;
  		else
  			return false;
  	}

  	public static function actualizar($name,$card_code,$margen_base,$margen_tat){
  		$sql="UPDATE [dbo].[@DPJD_MARGENES_PROD] SET [U_MargenBase]=?,[U_MargenTat]=? WHERE Name=? and U_CardCode=?;";
  		$db = DB::getInstance('SqlServer');

  		if($db->query($sql,[$margen_base,$margen_tat,$name,$card_code])->count()>0)
  			return true;
  		else
  			return false;
  	}

  	public static function activar($estado,$card_code){
  		$sql="UPDATE [dbo].[@DPJD_MARGENES_PROD] SET [U_Estado]=? WHERE U_CardCode=?;";
  		$db = DB::getInstance('SqlServer');	

  		if($db->query($sql,[$estado,$card_code])->count()>0)
  			return true;
  		else
  			return false;
  	}
}