<?php
/*
 * This file is part of FacturaSctipts
 * Copyright (C) 2014  Carlos Garcia Gomez  neorazorx@gmail.com
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once 'base/fs_model.php';

class fbm_socio extends fs_model
{
   public $idsocio;
   public $codcliente;
   public $fecha_alta;
   public $fecha_baja;
   public $en_alta;
   public $cuota;
   public $periodicidad;
   public $al_corriente;
   public $ultimo_pago;
   public $proximo_pago;
   
   public function __construct($s = FALSE)
   {
      parent::__construct('fbm_socios', 'plugins/veterinaria/');
      if($s)
      {
         $this->idsocio = $this->intval($s['idsocio']);
         $this->codcliente = $s['codcliente'];
         $this->fecha_alta = Date('d-m-Y', strtotime($s['fecha_alta']));
         
         $this->fecha_baja = NULL;
         if( isset($s['fecha_baja']) )
            $this->fecha_baja = Date('d-m-Y', strtotime($s['fecha_baja']));
         
         $this->en_alta = $this->str2bool($s['en_alta']);
         $this->cuota = floatval($s['cuota']);
         $this->periodicidad = $s['periodicidad'];
         $this->al_corriente = $this->str2bool($s['al_corriente']);
         
         $this->ultimo_pago = NULL;
         if( isset($s['ultimo_pago']) )
            $this->ultimo_pago = Date('d-m-Y', strtotime($s['ultimo_pago']));
         
         $this->proximo_pago = NULL;
         if( isset($s['proximo_pago']) )
            $this->proximo_pago = Date('d-m-Y', strtotime($s['proximo_pago']));
      }
      else
      {
         $this->idsocio = NULL;
         $this->codcliente = NULL;
         $this->fecha_alta = Date('d-m-Y');
         $this->fecha_baja = NULL;
         $this->en_alta = TRUE;
         $this->cuota = 0;
         $this->periodicidad = 'a';
         $this->al_corriente = TRUE;
         $this->ultimo_pago = NULL;
         $this->proximo_pago = NULL;
      }
   }
   
   protected function install()
   {
      return '';
   }
   
   public function exists()
   {
      if( is_null($this->idsocio) )
      {
         return FALSE;
      }
      else
         return $this->db->select("SELECT * FROM ".$this->table_name." WHERE idsocio = ".$this->var2str($this->idsocio).";");
   }
   
   public function save()
   {
      if( $this->exists() )
      {
         $sql = "UPDATE ".$this->table_name." SET codcliente = ".$this->var2str($this->codcliente).",
            fecha_alta = ".$this->var2str($this->fecha_alta).", fecha_baja = ".$this->var2str($this->fecha_baja).",
            en_alta = ".$this->var2str($this->en_alta).", cuota = ".$this->var2str($this->cuota).",
            periodicidad = ".$this->var2str($this->periodicidad).", al_corriente = ".$this->var2str($this->al_corriente).",
            ultimo_pago = ".$this->var2str($this->ultimo_pago).", proximo_pago = ".$this->var2str($this->proximo_pago)."
            WHERE idsocio = ".$this->var2str($this->idsocio).";";
         
         return $this->db->exec($sql);
      }
      else
      {
         $sql = "INSERT INTO ".$this->table_name." (codcliente,fecha_alta,fecha_baja,en_alta,cuota,periodicidad,al_corriente,ultimo_pago,proximo_pago)
            VALUES (".$this->var2str($this->codcliente).",".$this->var2str($this->fecha_alta).",".$this->var2str($this->fecha_baja).",
            ".$this->var2str($this->en_alta).",".$this->var2str($this->cuota).",".$this->var2str($this->periodicidad).",
            ".$this->var2str($this->al_corriente).",".$this->var2str($this->ultimo_pago).",".$this->var2str($this->proximo_pago).");";
         
         if( $this->db->exec($sql) )
         {
            $this->idsocio = $this->db->lastval();
            return TRUE;
         }
         else
            return FALSE;
      }
   }
   
   public function delete()
   {
      return $this->db->exec("DELETE FROM ".$this->table_name." WHERE idsocio = ".$this->var2str($this->idsocio).";");
   }
}