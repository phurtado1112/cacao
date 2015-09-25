<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Estado_resultado_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function saldo_cuenta($cuenta,$anio, $periodo) {
        $consulta_inicio = 'select eb.idestructura_base, descripcion_estructura_base, cc.idcategoria_cuenta, categoria_cuenta,
        gc.idgrupo_cuenta, grupo_cuenta,cac.idcuenta_contable, cuenta_contable,  ';
        
        $suma = '(saldo_inicial + ';
        
        for ($i = 1; $i <= $periodo; $i++) {
            if ($i != $periodo) {
                $suma .='periodo' . $i . ' + ';
            } else {
                $suma .='periodo' . $i . ') as suma_total, sal.anio as anio';
            }
        }
        
        $consulta_cierre = " from estructura_base as eb "
                . "right join categoria_cuenta as cc on cc.idestructura_base=eb.idestructura_base "
                . "right join grupo_cuenta as gc on gc.idcategoria_cuenta=cc.idcategoria_cuenta "
                . "right join catalogo_cuenta as cac on cac.idgrupo_cuenta=gc.idgrupo_cuenta "
                . "right join saldos as sal on sal.idcuenta_contable=cac.idcuenta_contable "
                . "where cac.idcuenta_contable ='".$cuenta."' and sal.anio=".$anio;
        $consulta = $consulta_inicio . $suma . $consulta_cierre;

        $consulta = $this->db->query($consulta);
        
        return $consulta->result_array();

    }
    
     public function saldo_cuenta_actual($cuenta,$anio, $periodo) {
        $consulta_inicio = 'select eb.idestructura_base, descripcion_estructura_base, cc.idcategoria_cuenta, categoria_cuenta,
        gc.idgrupo_cuenta, grupo_cuenta,cac.idcuenta_contable, cuenta_contable,periodo'.$periodo.' as suma_total, sal.anio as anio';
        
        $consulta_cierre = " from estructura_base as eb "
                . "right join categoria_cuenta as cc on cc.idestructura_base=eb.idestructura_base "
                . "right join grupo_cuenta as gc on gc.idcategoria_cuenta=cc.idcategoria_cuenta "
                . "right join catalogo_cuenta as cac on cac.idgrupo_cuenta=gc.idgrupo_cuenta "
                . "right join saldos as sal on sal.idcuenta_contable=cac.idcuenta_contable "
                . "where cac.idcuenta_contable ='".$cuenta."' and sal.anio=".$anio;
        $consulta = $consulta_inicio . $consulta_cierre;

        $consulta = $this->db->query($consulta);
        
        return $consulta->result_array();

    }
    
    public function niveles_grupo($nivel,$idgrup_cueta){
        $consulta ="select 
        gc1.idcategoria_cuenta as idcat_cuenta,
        gc1.idgrupo_cuenta as idgrupo_cuenta1, gc1.grupo_cuenta as grupo_cuenta1, gc1.nivel, 
        gc2.idgrupo_cuenta as idgrupocuenta2, gc2.grupo_cuenta as grupo_cuenta2,
        gc3.idgrupo_cuenta as idgrupocuenta3, gc3.grupo_cuenta as grupo_cuenta3,
        gc4.idgrupo_cuenta as idgrupocuenta4, gc4.grupo_cuenta as grupo_cuenta4, 
        gc5.idgrupo_cuenta as idgrupocuenta5, gc5.grupo_cuenta as grupo_cuenta5
        from grupo_cuenta as gc1 
        left join grupo_cuenta as gc2 on gc1.idgrupo_cuenta=gc2.idnivel_anterior
        left join grupo_cuenta as gc3 on gc2.idgrupo_cuenta=gc3.idnivel_anterior 
        left join grupo_cuenta as gc4 on gc3.idgrupo_cuenta=gc4.idnivel_anterior 
        left join grupo_cuenta as gc5 on gc4.idgrupo_cuenta=gc5.idnivel_anterior 
        where gc1.nivel=".$nivel." and gc1.idgrupo_cuenta=".$idgrup_cueta."";
        
        $consulta_f = $this->db->query($consulta);
        
        return $consulta_f->result_array();
        
    }
    
   


}
