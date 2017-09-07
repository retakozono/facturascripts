<?php
/**
 * This file is part of FacturaScripts
 * Copyright (C) 2013-2017  Carlos Garcia Gomez  carlos@facturascripts.com
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace FacturaScripts\Core\Controller;

use FacturaScripts\Core\Base\ExtendedController;

/**
 * Controlador para la lista de Formas de Pago
 *
 * @author Carlos García Gómez <carlos@facturascripts.com>
 * @author Artex Trading sa <jcuello@artextrading.com>
 */
class ListFormaPago extends ExtendedController\ListController
{
    public function __construct(&$cache, &$i18n, &$miniLog, $className)
    {
        parent::__construct($cache, $i18n, $miniLog, $className);
    }

    public function privateCore(&$response, $user)
    {
        parent::privateCore($response, $user);
    }

    public function getPageData()
    {
        $pagedata = parent::getPageData();
        $pagedata['title'] = 'Formas de Pago';
        $pagedata['icon'] = 'fa-credit-card';
        $pagedata['menu'] = 'contabilidad';

        return $pagedata;
    }

    protected function createViews()
    {
        $className = $this->getClassName();
        $index = $this->addView('FacturaScripts\Core\Model\FormaPago', $className);
        $this->addSearchFields($index, ['descripcion', 'codpago', 'codcuenta']);

        $this->addOrderBy($index, 'codpago', 'code');
        $this->addOrderBy($index, 'descripcion', 'description');

        $this->addFilterSelect($index, 'generación', 'formaspago', '', 'genrecibos');
        $this->addFilterSelect($index, 'vencimiento', 'formaspago');
        $this->addFilterCheckbox($index, 'domiciliado', 'Domiciliado');
        $this->addFilterCheckbox($index, 'imprimir', 'Imprimir');
    }
}