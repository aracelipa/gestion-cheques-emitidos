<?php

namespace App\Http\Controllers;

class PanelController extends Controller
{
    // muestra panel segun rol
    public function index()
    {
        if (!session()->has('usuario_id')) {
            return redirect()->route('login');
        }

        return view('panel.index');
    }
}