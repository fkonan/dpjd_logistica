<?php
namespace App\Models;
use Core\Model;
use Core\DB;
use Core\Validators\RequiredValidator;
use Core\Validators\UniqueValidator;
use Core\H;
use App\Models\Users;
use App\Models\LogisticaPdaPickingDetalle;


class LogisticaPdaPicking extends Model {

	public $id,$DocNum,$Cajas,$Unidades,$Estado,$Auxiliar,$Separado,$FechaAsignacion,$FechaInicio,$FechaFin,$IdSucursal,$Sistema,$Orden;
	protected static $_table='logistica_pda_picking';
	const blackList = ['id'];
	
	public function validator(){
		$camposRequeridos=[
			'DocNum'=>"DocNum",
			'Cajas'=>"Cajas",
			'Unidades'=>"Unidades",
			'Estado'=>"Estado",
			'Separado'=>"Separado",
			'IdSucursal'=>"IdSucursal",
			'Sistema'=>"Sistema",
			'Orden'=>"Orden"
		];
		foreach($camposRequeridos as $campo => $msn){
			$this->runValidation(new RequiredValidator($this,['field'=>$campo,'msg'=>$msn." es requerido."]));
		}
	    
		$this->runValidation(new UniqueValidator($this,['field'=>'DocNum','msg'=>'Número de picking ya se encuentra registrado.']));
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
	  				H::dnd('error');		
	  			}
  			}
		}
		
		$sql="SELECT row_number()over (order by Orden1)as Orden,DocNum,Cajas,Unidades,Estado,Auxiliar,Separado,FechaInicio,Sistema,Orden as Orden1,id FROM logistica_pda_picking WHERE Estado IN(0,1) ORDER BY Orden1,Estado";
  		$datos=$db_mysql->query($sql)->results();
  		return $datos;
	}

	public static function listar(){
		$sql="SELECT row_number()over (order by Orden1)as Orden,DocNum,Cajas,Unidades,Estado,Auxiliar,Separado,FechaInicio,Sistema,Orden as Orden1,id FROM logistica_pda_picking WHERE Estado IN(0,1) ORDER BY Orden1,Estado";
	  	$db_mysql = DB::getInstance();
  		$datos=$db_mysql->query($sql)->results();
  		return $datos;
	}

	public static function cargarPickPendiente($serie,$sistema){
		//selecciono  los pickings pendientes de sql server;
	  	/*$sql =
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
	  	*/
	  $sql="SELECT Picking,sum(CJ) AS Cajas,sum(UN) AS Unidades FROM (
			SELECT
				Picking,
				Emb,
				SUM(Cajas) + (SUM(Unidades) / Emb) AS CJ,
				SUM(Unidades) % Emb AS UN,
				SUM(Precio) AS Precio
			FROM
				(
				SELECT
					T1.[U_HBT_CodAlistamient] AS Picking,
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
				WHERE T1.[U_HBT_CodAlistamient] IN (SELECT [DocNum] AS Picking FROM	[@GESTIONRUTAS]WHERE [U_EstadoRuta] = '2' AND [Series] = '{$serie}')
						
				UNION ALL
							
				SELECT
					T1.[U_HBT_CodAlistamient] AS Picking,	
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
				Picking, Emb
							
			UNION ALL
						
			SELECT
				'000' as Picking,
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
				T1.[U_HBT_CodAlistamient] IN (SELECT [DocNum] AS Picking FROM	[@GESTIONRUTAS]WHERE [U_EstadoRuta] = '2' AND [Series] = '{$serie}')
				AND T3.[ItmsGrpCod] = '{$sistema}'
			)AS total WHERE Picking<>'0' GROUP BY Picking ORDER BY Picking";

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
			$detalle=self::insertPickingDetalle($model->id,$picking,$sistema);
			if($detalle)
				return true;
			else
				H::dnd('error en el detalle');
		}else{
			H::dnd($model->getErrorMessages());
			return false;
		}
	}

	public static function insertPickingDetalle($id_pick,$DocNum,$sistema){
		if($sistema=='B')
			$sistema='684';
		else
			$sistema='401';

		$sql="
		SELECT
			Casa, Codigo, Descripcion,  UnEmpaque, UnVenta, Emb, SUM(Cajas) + (SUM(Unidades) / Emb) AS Cajas,
			SUM(Unidades) % Emb AS Unidades, SUM(Precio) AS Precio,(select codebars from oitm where itemcode=Codigo) as CodeBars
		FROM
			(SELECT
				T3.[CardCode] AS Casa,
				T5.PrioDesc AS Ruta,
				T3.[U_Pasillo] AS Pasillo,
				T3.[U_Nivel] AS Nivel,
				T3.[U_Columna] AS Columna,
				T3.[ItemCode] AS Codigo,
				'' AS C,
				T3.[ItemName] AS Descripcion,
				0 AS C1,
				T3.[SWW] AS UnEmpaque,
				T3.[SalUnitMsr] AS UnVenta,
				CONVERT(INT,(T3.[NumInBuy] / T3.[NumInSale])) AS Emb,
				CONVERT(INT,T2.[Quantity] / (T3.[NumInBuy] / T3.[NumInSale])) AS Cajas,
				CONVERT(INT,T2.[Quantity] % (T3.[NumInBuy] / T3.[NumInSale])) AS Unidades,
				CONVERT(INT,T2.[LineTotal]) AS Precio
			FROM
				[ODLN] T1
			INNER JOIN
				[DLN1] T2
					ON T1.[DocEntry] = T2.[DocEntry]
			LEFT JOIN
				[OITM] T3
					ON T2.[ItemCode] = T3.[ItemCode]
					AND T3.[ItmsGrpCod] <> {$sistema}
			LEFT JOIN
				[OCRD] T4
					ON T1.[CardCode] = T4.[CardCode]
			LEFT JOIN
				[OBPP] T5
					ON T4.[Priority] = T5.[PrioCode]
			WHERE
				T1.[U_HBT_CodAlistamient] IN ({$DocNum})

			UNION ALL

			SELECT
				T3.[CardCode] AS Casa,
				T5.PrioDesc AS Ruta,
				T3.[U_Pasillo] AS Pasillo,
				T3.[U_Nivel] AS Nivel,
				T3.[U_Columna] AS Columna,
				T3.[ItemCode] AS Codigo,
				'COMBO' AS C,
				T3.[ItemName] AS Descripcion,
				0 AS C1,
				T3.[SWW] AS UnEmpaque,
				T3.[SalUnitMsr] AS UnVenta,
				CONVERT(INT,(T3.[NumInBuy] / T3.[NumInSale])) AS Emb,
				CONVERT(INT,T2.[Quantity] / (T3.[NumInBuy] / T3.[NumInSale])) AS Cajas,
				CONVERT(INT,T2.[Quantity] % (T3.[NumInBuy] / T3.[NumInSale])) AS Unidades,
				CONVERT(INT,T2.[LineTotal]) AS Precio
			FROM
				[ODLN] T1
			INNER JOIN
				[DLN1] T2
					ON T1.[DocEntry] = T2.[DocEntry]
			LEFT JOIN
				[OITM] T3
					ON T2.[ItemCode] = T3.[ItemCode]
					AND T3.[ItmsGrpCod] = {$sistema}
			LEFT JOIN
				[OCRD] T4
					ON T1.[CardCode] = T4.[CardCode]
			LEFT JOIN
				[OBPP] T5
					ON T4.[Priority] = T5.[PrioCode]
			WHERE
				T1.[U_HBT_CodAlistamient] IN ({$DocNum})

			UNION ALL

			SELECT
				T3.[CardCode] AS Casa,
				T5.PrioDesc AS Ruta,
				T12.[U_Pasillo] AS Pasillo,
				T12.[U_Nivel] AS Nivel,
				T12.[U_Columna] AS Columna,
				T3.[ItemCode] AS Codigo,
				T12.[ItemCode] AS C,
				T12.[ItemName] AS Descripcion,
				CONVERT(INT,(T2.[Quantity] * T12.[Quantity]) / T12.[NumInSale]) AS C1,
				T12.[SWW] AS UnEmpaque,
				T12.[SalUnitMsr] AS UnVenta,
				CONVERT(INT,T12.[NumInBuy] / T12.[NumInSale]) AS Emb,
				0 AS Cajas,
				0 AS Unidades,
				0 AS Precio
			FROM
				[ODLN] T1
			INNER JOIN
				[DLN1] T2
					ON T1.[DocEntry] = T2.[DocEntry]
			LEFT JOIN
				[OITM] T3
					ON T2.[ItemCode] = T3.[ItemCode]
					AND T3.[ItmsGrpCod] = {$sistema}
			LEFT JOIN
				[OCRD] T4
					ON T1.[CardCode] = T4.[CardCode]
			LEFT JOIN
				[OBPP] T5
					ON T4.[Priority] = T5.[PrioCode]
			LEFT JOIN(
				SELECT
					T3.[CardCode],
					T1.[Code],
					T3.[U_Pasillo],
					T3.[U_Nivel],
					T3.[U_Columna],
					T3.[ItemCode],
					T3.[ItemName],
					T3.[SWW],
					T3.[SalUnitMsr],
					T3.[NumInBuy],
					T3.[NumInSale],
					T2.[Quantity]
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
				T1.[U_HBT_CodAlistamient] IN ({$DocNum})
			) AS Picking
		WHERE
			Cajas > 0
			OR Unidades > 0
			OR C1 > 0
		GROUP BY
			Casa, Codigo, Descripcion, UnEmpaque, UnVenta, Emb
		ORDER BY
			Casa,Codigo, Descripcion
		";

		$db_sql = DB::getInstance('SqlServer');
		$datos_sql=$db_sql->query($sql)->results();

		foreach ($datos_sql as $key => $value) {
			$model=new LogisticaPdaPickingDetalle();
			$model->IdPicking=$id_pick;
			$model->CasaEntrega=$value->Casa;
			$model->Codigo=$value->Codigo;
			$model->Descripcion=$value->Descripcion;
			$model->UnEmpaque=$value->UnEmpaque;
			$model->UnVenta=$value->UnVenta;
			$model->Embalaje=$value->Emb;
			$model->Cajas=$value->Cajas;
			$model->Unidades=$value->Unidades;
			$model->Unidades=$value->Unidades;
			$model->Estado='false';
			$model->CodeBars=$value->CodeBars;
			
			if(!$model->save()){
				H::dnd($model->getErrorMessages());
				return false;
			}
		}
		return true;
	}
}