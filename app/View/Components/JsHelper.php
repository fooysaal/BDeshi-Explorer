<?php

namespace App\View\Components;

use Illuminate\View\Component;

class JsHelper extends Component
{
    private $dataTable;
    private $select2;
    private $bootstrap;
    private $ckeditor;
    private $datepicker;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($dataTable = true, $select2 = true, $bootstrap = true, $ckeditor = true, $datepicker = true)
    {
        $this->dataTable = $dataTable;
        $this->select2 = $select2;
        $this->bootstrap = $bootstrap;
        $this->ckeditor = $ckeditor;
        $this->datepicker = $datepicker;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $viewBag['dataTable'] = $this->dataTable;
        $viewBag['select2'] = $this->select2;
        $viewBag['bootstrap'] = $this->bootstrap;
        $viewBag['ckeditor'] = $this->ckeditor;
        $viewBag['datepicker'] = $this->datepicker;

        return view('components.js-helper', $viewBag);
    }
}
