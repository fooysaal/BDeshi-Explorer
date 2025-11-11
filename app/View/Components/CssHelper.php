<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CssHelper extends Component
{
    private $dataTable;
    private $select2;
    private $bootstrap;
    private $ckeditor;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($dataTable = false, $select2 = false, $bootstrap = false, $ckeditor = false)
    {
        $this->dataTable = $dataTable;
        $this->select2 = $select2;
        $this->bootstrap = $bootstrap;
        $this->ckeditor = $ckeditor;
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

        return view('components.css-helper', $viewBag);
    }
}
