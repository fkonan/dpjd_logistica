<?php
namespace App\Models;
use Core\Model;
use Core\DB;
use Core\Validators\RequiredValidator;
use Core\Validators\UniqueValidator;
use Core\H;
use App\Models\Users;


class LogisticaPdaPickingDetalle extends Model {

	public $id,$IdPicking,$CasaEntrega,$Codigo,$Descripcion,$UnEmpaque,$UnVenta,$Embalaje,$Cajas,$Unidades,$Estado,$Auxiliar,$FechaInicio,$FechaFin,$CodeBars;
	protected static $_table='logistica_pda_picking_detalle';
	const blackList = ['id'];
	
	public function validator(){
		$camposRequeridos=[
			'IdPicking'=>"IdPicking",
			'CasaEntrega'=>"CasaEntrega",
			'Codigo'=>"Codigo",
			'Descripcion'=>"Descripcion",
			'UnEmpaque'=>"UnEmpaque",
			'UnVenta'=>"UnVenta",
			'Embalaje'=>"Embalaje",
			'Cajas'=>"Cajas",
			'Unidades'=>"Unidades",
			'Estado'=>"Estado",
			'CodeBars'=>"CodeBars"
		];
		foreach($camposRequeridos as $campo => $msn){
			$this->runValidation(new RequiredValidator($this,['field'=>$campo,'msg'=>$msn." es requerido."]));
		}
	}

	public static function listarPickingPendientes($valor){
	  	
	  	$db_mysql = DB::getInstance();

		$sistema='';
		$serie='';
		$contador=1;

		if($valor=='B'){
			$serie=383;
			$sistema=684;
		}
		else{
			$serie=246;
			$sistema=401;
		}

		//busco si hay registros en la tabla mysql, si no hay defino el orden=1
		$sql = "SELECT count(id) as Orden FROM logistica_pda_picking";
		$datos_mysql=$db_mysql->query($sql)->results()[0];
		
		if($datos_mysql->Orden>0)
			$contador=(int)$datos_mysql->Orden+1;

		$datos_sql=self::cargarPickPendiente($serie,$sistema);
		//recorro los pickig y reviso si ya estan en la tabla de mysql
		foreach ($datos_sql as $key => $value) {
			$sql="SELECT DocNum FROM logistica_pda_picking WHERE DocNum=?";
			
			//si no estan en mysql los inserto en el ultimo orden
			if($db_mysql->query($sql,[$value->Picking])->count()==0){
				$datos_sql=self::insertPicking($value->Picking,$value->Cajas,$value->Unidades,$valor,$contador);
				if($datos_sql)
	  				$contador=$contador+1;
	  			else{
	  				H::dnd('else');		
	  			}
  			}
		}
		
		$sql="SELECT row_number()over (order by Orden)as Orden1,DocNum,Cajas,Unidades,Orden FROM logistica_pda_picking WHERE Estado IN(0,1) ORDER BY Orden";
  		$datos=$db_mysql->query($sql)->results();
  		return $datos;
	}

	public static function cargarPickPendiente($serie,$sistema){
		//selecciono  los pickings pendientes de sql server;
	  	$sql =
	  	"
		SELECT Picking,sum(CJ) AS Cajas,sum(UN) AS Unidades FROM (
			SELECT
				Picking,
				Linea,
				Codigo,
				Descripcion,
				UnEmpaque,
				UnVenta,
				Emb,
				SUM(Cajas) + (SUM(Unidades) / Emb) AS CJ,
				SUM(Unidades) % Emb AS UN,
				SUM(Precio) AS Precio
			FROM
				(SELECT
					T1.[U_HBT_CodAlistamient] AS Picking,
					T3.[CardCode] AS Linea,
					T3.[ItemCode] AS Codigo,
					T3.[ItemName] AS Descripcion,
					T3.[SWW] AS UnEmpaque,
					T3.[SalUnitMsr] AS UnVenta,
					CONVERT(INT,T3.[NumInBuy]) AS Emb,
					CONVERT(INT,(T2.[Quantity] - ISNULL((SELECT SUM(TA.[Quantity]) FROM [RDN1] TA WHERE T1.[DocEntry] = TA.[BaseEntry] AND T2.[ItemCode] = TA.[ItemCode]), 0)) / (T3.[NumInBuy] / T3.[NumInSale])) AS Cajas,
					CONVERT(INT,(T2.[Quantity] - ISNULL((SELECT SUM(TA.[Quantity]) FROM [RDN1] TA WHERE T1.[DocEntry] = TA.[BaseEntry] AND T2.[ItemCode] = TA.[ItemCode]), 0)) % (T3.[NumInBuy] / T3.[NumInSale])) AS Unidades,
					CONVERT(INT,T2.[LineTotal] - ISNULL((SELECT SUM(TA.[LineTotal]) FROM [RDN1] TA WHERE T1.[DocEntry] = TA.[BaseEntry] AND T2.[ItemCode] = TA.[ItemCode]), 0)) AS Precio
				FROM
					[ODLN] T1
				INNER JOIN
					[DLN1] T2
						ON T1.[DocEntry] = T2.[DocEntry]
				LEFT JOIN
					[OITM] T3
						ON T2.[ItemCode] = T3.[ItemCode]
						AND T3.[ItmsGrpCod] <> '{$sistema}'
				LEFT JOIN
					[OCRD] T4
						ON T1.[CardCode] = T4.[CardCode]
				LEFT JOIN
					[OBPP] T5
						ON T4.[Priority] = T5.[PrioCode]
				WHERE
					T1.[U_HBT_CodAlistamient] IN (SELECT [DocNum] AS Picking FROM	[@GESTIONRUTAS]WHERE [U_EstadoRuta] = '2' AND [Series] = '{$serie}')
						
				UNION ALL
							
				SELECT
					T1.[U_HBT_CodAlistamient] AS Picking,
					T12.[CardCode] AS Linea,
					T12.[ItemCode] AS Codigo,
					T12.[ItemName] AS Descripcion,
					T12.[SWW] AS UnEmpaque,
					T12.[SalUnitMsr] AS UnVenta,
					CONVERT(INT,T12.[NumInBuy]) AS Emb,
					CONVERT(INT,((T2.[Quantity] - ISNULL((SELECT SUM(TA.[Quantity]) FROM [RDN1] TA WHERE T1.[DocEntry] = TA.[BaseEntry] AND T2.[ItemCode] = TA.[ItemCode]), 0)) * T12.[Quantity]) / T12.[NumInBuy]) AS Cajas,
					CONVERT(INT,((T2.[Quantity] - ISNULL((SELECT SUM(TA.[Quantity]) FROM [RDN1] TA WHERE T1.[DocEntry] = TA.[BaseEntry] AND T2.[ItemCode] = TA.[ItemCode]), 0)) * T12.[Quantity]) % T12.[NumInBuy]) AS Unidades,
					0 AS Precio
				FROM
					[ODLN] T1
				INNER JOIN
					[DLN1] T2
						ON T1.[DocEntry] = T2.[DocEntry]
				LEFT JOIN
					[OITM] T3
						ON T2.[ItemCode] = T3.[ItemCode]
						AND T3.[ItmsGrpCod] = '{$sistema}'
				LEFT JOIN
					[OCRD] T4
						ON T1.[CardCode] = T4.[CardCode]
				LEFT JOIN
					[OBPP] T5
						ON T4.[Priority] = T5.[PrioCode]
				LEFT JOIN(
					SELECT
						T1.[Code],
						T3.[U_Pasillo],
						T3.[U_Nivel],
						T3.[U_Columna],
						T3.[ItemCode],
						T3.[ItemName],
						T3.[SWW],
						T3.[SalUnitMsr],
						T3.[NumInBuy],
						T2.[Quantity],
						T3.[CardCode]
					FROM
						[OITT] T1
					INNER JOIN
						[ITT1] T2
							ON T1.[Code] = T2.[Father]
					LEFT JOIN
						[OITM] T3
							ON T2.[Code] = T3.[ItemCode]
					LEFT JOIN(
						SELECT
							T1.[Father],
							SUM(T1.[Quantity]) AS Total
						FROM
							[ITT1] T1
						GROUP BY
							T1.[Father]
						) AS T4
							ON T1.[Code] = T4.[Father]
					) AS T12
						ON T3.[ItemCode] = T12.[Code]
				WHERE
					T1.[U_HBT_CodAlistamient] IN (SELECT [DocNum] AS Picking FROM	[@GESTIONRUTAS]WHERE [U_EstadoRuta] = '2' AND [Series] = '{$serie}')
				) AS Picking
			WHERE
				Cajas > 0
				OR Unidades > 0
			GROUP BY
				Picking,Linea, Codigo, Descripcion, UnEmpaque, UnVenta, Emb
							
			UNION ALL
						
			SELECT
				'000' as Picking,
				'000' AS Linea,
				'000' AS Codigo,
				'' AS Descripcion,
				'' AS UnEmpaque,
				'' AS UnVenta,
				0 AS Emb,
				0 AS CJ,
				0 AS UN,
				CONVERT(INT,T2.[LineTotal] - ISNULL((SELECT SUM(TA.[LineTotal]) FROM [RDN1] TA WHERE T1.[DocEntry] = TA.[BaseEntry] AND T2.[ItemCode] = TA.[ItemCode]), 0)) AS Precio
			FROM
				[ODLN] T1
			INNER JOIN
				[DLN1] T2
					ON T1.[DocEntry] = T2.[DocEntry]
			LEFT JOIN
				[OITM] T3
					ON T2.[ItemCode] = T3.[ItemCode]
			WHERE
				T1.[U_HBT_CodAlistamient] IN (SELECT [DocNum] AS Picking FROM [@GESTIONRUTAS]WHERE [U_EstadoRuta] = '2' AND [Series] = '{$serie}')
				AND T3.[ItmsGrpCod] = '{$sistema}'
			)
			AS total WHERE Picking<>'0' GROUP BY Picking ORDER BY Picking;
	  	";

	  	$db_sql = DB::getInstance('SqlServer');
		$datos_sql=$db_sql->query($sql)->results();
		return $datos_sql;
	}

	public static function insertPicking($picking,$cajas,$unidades,$sistema,$orden){
		$model=new self();
		$model->DocNum=$picking;
		$model->Cajas=$cajas;
		$model->Unidades=$unidades;
		$model->Estado='false';
		$model->Separado='false';
		$model->IdSucursal=Users::currentUser()->IdSucursal;
		$model->Sistema=$sistema;
		$model->Orden=$orden;
		
		if($model->save()){
			return true;
		}else{
			H::dnd($model->getErrorMessages());
			return false;
		}
	}
}