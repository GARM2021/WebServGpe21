<?php

namespace App\Http\Controllers\api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CatastroModel extends Model
{
    static function getAdeudoExpediente($Expe)
    {
        $WGRANTOTAL = 0;
        $sql = "SELECT a.*,b.descripcion FROM preddadeudos a, predmtpocar b 
		where a.exp='$Expe' and b.tpocar COLLATE DATABASE_DEFAULT =a.tpocar COLLATE DATABASE_DEFAULT and a.estatus < '0001' AND a.salimp > 0
		ORDER BY yearbim";
        $query = DB::connection('sqlsrv')->select($sql);
        foreach ($query as $row)
        {
            /* de prueba se agrega un dia mas 
            $hdthoy = trim(date("Ymd"));
            $hoy = date("Ymd",strtotime($hdthoy."+ 1 days"));*/ 
            
            
            $hoy = trim(date("Ymd"));
            $wfun	 = '00';
            $pbonimp = 0;
            $bonrec		= 0;
            $tpocar  = $row->tpocar;
            $bimsem	 = $row->bimsem;
            $WDIAMES = trim(date("j"));

            $sql2 = "SELECT * FROM bondbonpred where tpocar='$tpocar' and fecini<='$hoy' and fecfin>='$hoy' and estatus='0'";
            $query2 = DB::connection('sqlsrv')->select($sql2);
            foreach($query2 as $row2)
            {
                /* HDT 31/12/2020 */
                /* si el tipo de cargo es 002 (es decir que no tiene adeudo) se realiza un descuento adicional del 3% 
                if ($tpocar>'0002') 
                {
                    $paso1 = (($row->salimp-$row->salsub)*($row2->pctbonimp + 3))/100;    
                } 
                else 
                {
                    $paso1 = (($row->salimp-$row->salsub)*$row2->pctbonimp)/100;    
                }*/
                
                
                $paso1 = (($row->salimp-$row->salsub)*$row2->pctbonimp)/100;
                $paso2 = $paso1*10;
                $paso3 = (int)($paso2);
                $pbonimp = $paso3/10;
                $wfun	  = $row2->funautbon;
            }

            /********************************/
            if (trim($bimsem)=='06')
            {
                $wbsyb=trim($bimsem).substr(trim($row->yearbim),0,4).'04';
                //echo $wbsyb.'cambio a 04 <br>';
            }
            else
            {
                $wbsyb=trim($bimsem).trim($row->yearbim);
                //echo $wbsyb.'se quedo igual <br>';
            }

            //echo Busca en la tabla preddrequer si el expediente se encuentra requerido.
            $wofecven=$row->fechaven;
            $sql_Requerido= DB::connection('sqlsrv')->select("SELECT top 1 * FROM preddrequer where exp='$Expe' ORDER BY freq DESC");
            $row_cnt_Requerido =  count($sql_Requerido);
            //Fecha de ultimo requerimiento
            foreach($sql_Requerido as $row_reque)
            {
                $wRfecreq=$row_reque->freq;
                //echo  $wRfecreq;
            }

            if ($row_cnt_Requerido == 0)
            {
                //echo 'CALCULA RECARGOS CON LA TABLA 1 DE RECARGOS '.$wRfecreq.'  '.$wofecven;
                $sql_recargos= DB::connection('sqlsrv')->select("SELECT * FROM predmtabrec where bsyb='$wbsyb' ");
                $row_cnt_recargos= count($sql_recargos);
                if ($row_cnt_recargos==0)
                {
                    // cuando no se encuentra el bsyb en la tabla
                    $sql_recargos= DB::connection('sqlsrv')->select("SELECT top 1 * FROM predmtabrec order BY bsyb ");
                    $row_cnt_recargos= count($sql_recargos);
                    foreach($sql_recargos as $row_recargos)
                    {
                        $wpctrec=trim('pctrec_'.trim(date("n")));
                        IF  ($WDIAMES==1)
                        {
                            $WMESMENOS=trim(date("n"))-1;
                            $wpctrec=trim('pctrec_'.trim($WMESMENOS));
                            IF ($WMESMENOS==0)
                                $wpctrec=trim('pctrec_'.trim('1'));
                        }

                        $paso1 = ($row->salimp * $row_recargos->$wpctrec)/100;
                        $paso2 = $paso1*10;
                        $paso3 = (int)($paso2);
                        $wrecargos=$paso3/10;

                    }
                }
                else
                {
                    foreach($sql_recargos as $row_recargos)
                    {
                        $wpctrec=trim('pctrec_'.trim(date("n")));
                        IF  ($WDIAMES==1)
                        {
                            $WMESMENOS=trim(date("n"))-1;
                            $wpctrec=trim('pctrec_'.trim($WMESMENOS));
                            IF ($WMESMENOS==0)
                                $wpctrec=trim('pctrec_'.trim('1'));
                        }
                        //$wprecargos=$row_recargos[$wpctrec];
                        $paso1 = ($row->salimp * $row_recargos->$wpctrec)/100;
                        $paso2 = $paso1*10;
                        $paso3 = (int)($paso2);
                        $wrecargos=$paso3/10;
                    }
                }
            }
            else
            {
                //si la fecha de requerimiento es mayor o igual al vencimiento utiliza recargos 2
                //echo 'fecha de requerido '.$wRfecreq.' '.$wofecven.'<br>';
                if ($wRfecreq>=$wofecven)
                {
                    //echo'CALCULA RECARGOS CON LA TABLA 2 DE RECARGOS '.$wRfecreq.' >= '.$wofecven;
                    $sql_recargos= DB::connection('sqlsrv')->select("SELECT * FROM predmtabrec2 where bsyb='$wbsyb' ");
                    $row_cnt_recargos= count($sql_recargos);
                    if ($row_cnt_recargos==0)
                    {
                        // cuando no se encuentra el bsyb en la tabla
                        $sql_recargos= DB::connection('sqlsrv')->select("SELECT top 1 * FROM predmtabrec2 order BY bsyb ");
                        $row_cnt_recargos= count($sql_recargos);
                        foreach($sql_recargos as $row_recargos)
                        {
                            $wpctrec=trim('pctrec_'.trim(date("n")));
                            IF  ($WDIAMES==1)
                            {
                                $WMESMENOS=trim(date("n"))-1;
                                $wpctrec=trim('pctrec_'.trim($WMESMENOS));
                                IF ($WMESMENOS==0)
                                    $wpctrec=trim('pctrec_'.trim('1'));
                            }
                            //$wprecargos=$row_recargos[$wpctrec];
                            $paso1 = ($row->salimp * $row_recargos->$wpctrec)/100;
                            $paso2 = $paso1*10;
                            $paso3 = (int)($paso2);
                            $wrecargos=$paso3/10;

                        }
                    }
                    else
                    {
                        foreach($sql_recargos as $row_recargos)
                        {
                            $wpctrec=trim('pctrec_'.trim(date("n")));
                            IF  ($WDIAMES==1)
                            {
                                $WMESMENOS=trim(date("n"))-1;
                                $wpctrec=trim('pctrec_'.trim($WMESMENOS));
                                IF ($WMESMENOS==0)
                                    $wpctrec=trim('pctrec_'.trim('1'));
                            }
                            //$wprecargos=$row_recargos[$wpctrec];
                            $paso1 = ($row->salimp * $row_recargos->$wpctrec)/100;
                            $paso2 = $paso1*10;
                            $paso3 = (int)($paso2);
                            $wrecargos=$paso3/10;

                        }
                    }
                }
                else
                {
                    //echo 'CALCULA RECARGOS CON LA TABLA 1 DE RECARGOS '.$wRfecreq.' <= '.$wofecven;
                    $sql_recargos= DB::connection('sqlsrv')->select("SELECT * FROM predmtabrec where bsyb='$wbsyb' ");
                    $row_cnt_recargos= count($sql_recargos);
                    if ($row_cnt_recargos==0)
                    {
                        // cuando no se encuentra el bsyb en la tabla
                        $sql_recargos= DB::connection('sqlsrv')->select("SELECT top 1 * FROM predmtabrec order BY bsyb ");
                        $row_cnt_recargos= count($sql_recargos);
                        foreach($sql_recargos as $row_recargos)
                        {
                            $wpctrec=trim('pctrec_'.trim(date("n")));
                            IF  ($WDIAMES==1)
                            {
                                $WMESMENOS=trim(date("n"))-1;
                                $wpctrec=trim('pctrec_'.trim($WMESMENOS));
                                IF ($WMESMENOS==0)
                                    $wpctrec=trim('pctrec_'.trim('1'));
                            }
                            //$wprecargos=$row_recargos[$wpctrec];
                            $paso1 = ($row->salimp * $row_recargos->$wpctrec)/100;
                            $paso2 = $paso1*10;
                            $paso3 =(int)($paso2);
                            $wrecargos=$paso3/10;

                        }
                    }
                    else
                    {
                        foreach($sql_recargos as $row_recargos)
                        {
                            $wpctrec=trim('pctrec_'.trim(date("n")));
                            IF  ($WDIAMES==1)
                            {
                                $WMESMENOS=trim(date("n"))-1;
                                $wpctrec=trim('pctrec_'.trim($WMESMENOS));
                                IF ($WMESMENOS==0)
                                    $wpctrec=trim('pctrec_'.trim('1'));
                            }
                            //$wprecargos=$row_recargos[$wpctrec];
                            $paso1 = ($row->salimp * $row_recargos->$wpctrec)/100;
                            $paso2 = $paso1*10;
                            $paso3 = (int)($paso2);
                            $wrecargos = $paso3/10;

                        }
                    }
                }

            }

            if ($row_cnt_recargos==0)
            {
                $wpctrec=trim('pctrec_'.trim(date("n")));
                $wntabla=trim($bimsem);
                //echo 'NO SE ENCONTRO EL BSYB  '.$wbsyb.$wpctrec.'<br>';
                //echo "SELECT TOP 1 ".$wpctrec." FROM predmtabrec WHERE (SUBSTRING(bsyb, 1, 2) ='".$wntabla."') ORDER BY bsyb";
                $sql_recargos2= DB::connection('sqlsrv')->select("SELECT TOP 1 ".$wpctrec." FROM predmtabrec WHERE (SUBSTRING(bsyb, 1, 2) ='".$wntabla."') ORDER BY bsyb");
                $row_cnt_recargos2= count($sql_recargos2);
                foreach($sql_recargos2 as $row_recargos2)
                {
                    $wprecargos=$row_recargos2->$wpctrec;
                    IF  ($WDIAMES==1)
                    {
                        $WMESMENOS=trim(date("n"))-1;
                        $wpctrec=trim('pctrec_'.trim($WMESMENOS));
                        IF ($WMESMENOS==0)
                            $wpctrec=trim('pctrec_'.trim('1'));
                    }
                    $paso1	= ($row->salimp * $wprecargos)/100;
                    $paso2	= $paso1*10;
                    $paso3	= (int)($paso2);
                    $wrecargos = $paso3/10;
                }
            }

            /********************************/


            if ($tpocar>'0002')
            {
                $wprecargos= 0;
                $wrecargos = 0;
            }

            $pbonrec=0;
            $sql3= DB::connection('sqlsrv')->select("SELECT * FROM bondbonpred where tpocar='".$tpocar."' and fecini<='".$hoy."' and fecfin>='".$hoy."' and estatus='0' ");
            $row_cnt3 = count($sql3);
            foreach($sql3 as $row3)
            {
                $paso1=($wrecargos * $row3->pctbonrec/100);
                $paso2=$paso1*10;
                $paso3=(int)($paso2);
                $pbonrec=$paso3/10;
            }

            $WNETO		= (round($row->salimp,2) + round($wrecargos,2)) - (round($pbonimp,2) + round($pbonrec,2) + round($row->salsub, 2));
            $WGRANTOTAL	= round($WGRANTOTAL,2) + round($WNETO,2);
        }


        return $WGRANTOTAL;
    }
}